<?php
/**
 * Contact Form Handler
 *
 * Empfängt Kontaktformular-Daten und sendet sie per E-Mail.
 * Kein Logging, nur Mail-Versand.
 *
 * Security Features:
 * - CSRF-Token Validation (via Session)
 * - Honeypot Field (Bot-Detection)
 * - Time-based Spam Protection (min. 3 Sekunden)
 * - Rate Limiting (max 3 Anfragen pro IP in 10 Minuten)
 * - Input Validation & Sanitization
 */

// Konfiguration aus externer Datei laden (nicht im Repo)
$config_file = __DIR__ . '/.contact-config.json';
if (!file_exists($config_file)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'config_missing']);
    exit;
}
$config = json_decode(file_get_contents($config_file), true);
$recipient_email = $config['recipient_email'] ?? '';
$from_email = $config['from_email'] ?? '';

if (empty($recipient_email)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'config_invalid']);
    exit;
}

$rate_limit_file = __DIR__ . '/.contact-ratelimit.json';
$max_requests = 3;
$time_window = 600; // 10 Minuten in Sekunden
$min_submit_time = 3; // Mindestzeit in Sekunden

// Session starten (mit sicheren Cookie-Flags)
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

// CORS Headers für AJAX
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

/**
 * Get client IP (handles proxies)
 */
function getClientIP() {
    $headers = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR'
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = $_SERVER[$header];
            if (strpos($ip, ',') !== false) {
                $ip = trim(explode(',', $ip)[0]);
            }
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

/**
 * Generate CSRF Token
 */
function generateCsrfToken() {
    return bin2hex(random_bytes(32));
}

/**
 * Check rate limit for IP
 */
function checkRateLimit($ip, $file, $max, $window) {
    $data = [];

    // Hash IP for privacy (rate limiting doesn't need the actual IP)
    $ipHash = hash('sha256', $ip . 'rate_limit_salt');

    if (file_exists($file)) {
        $content = file_get_contents($file);
        $data = json_decode($content, true) ?: [];
    }

    $now = time();

    // Alte Einträge entfernen
    foreach ($data as $storedHash => $timestamps) {
        $data[$storedHash] = array_filter($timestamps, function($t) use ($now, $window) {
            return ($now - $t) < $window;
        });
        if (empty($data[$storedHash])) {
            unset($data[$storedHash]);
        }
    }

    // IP-Hash prüfen
    $ipRequests = $data[$ipHash] ?? [];

    if (count($ipRequests) >= $max) {
        return false;
    }

    // Neuen Request speichern (mit Hash)
    $data[$ipHash][] = $now;
    file_put_contents($file, json_encode($data));

    return true;
}

/**
 * Sanitize input string
 */
function sanitizeInput($input, $maxLength = 1000) {
    $input = trim($input);
    $input = strip_tags($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return mb_substr($input, 0, $maxLength);
}

// ============================================================================
// REQUEST HANDLING
// ============================================================================

// GET-Request: CSRF-Token generieren und zurückgeben
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = generateCsrfToken();
    $_SESSION['contact_csrf'] = $token;

    echo json_encode([
        'success' => true,
        'csrf_token' => $token
    ]);
    exit;
}

// Nur POST-Requests für Formular-Submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'method_not_allowed']);
    exit;
}

// JSON-Payload lesen
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'invalid_request']);
    exit;
}

// Rate Limiting prüfen
$clientIP = getClientIP();
if (!checkRateLimit($clientIP, $rate_limit_file, $max_requests, $time_window)) {
    http_response_code(429);
    echo json_encode(['success' => false, 'error' => 'rate_limit']);
    exit;
}

// CSRF-Token prüfen
$csrfToken = $data['csrf_token'] ?? '';
$sessionToken = $_SESSION['contact_csrf'] ?? '';

if (empty($csrfToken) || empty($sessionToken) || !hash_equals($sessionToken, $csrfToken)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'csrf_invalid']);
    exit;
}

// Honeypot prüfen (muss leer sein)
$honeypot = $data['website'] ?? '';
if (!empty($honeypot)) {
    // Fake-Erfolg für Bots
    echo json_encode(['success' => true]);
    exit;
}

// Zeitbasierte Prüfung
$formLoadTime = $data['_t'] ?? 0;
$submitTime = time();

if ($formLoadTime > 0 && ($submitTime - $formLoadTime) < $min_submit_time) {
    // Zu schnell = Bot, Fake-Erfolg
    echo json_encode(['success' => true]);
    exit;
}

// Formularfelder validieren
$name = sanitizeInput($data['name'] ?? '', 100);
$email = filter_var(trim($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$message = sanitizeInput($data['message'] ?? '', 5000);
$lang = in_array($data['lang'] ?? 'de', ['de', 'en', 'da']) ? $data['lang'] : 'de';

// Pflichtfelder prüfen
if (empty($name) || mb_strlen($name) < 2) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'name_invalid']);
    exit;
}

if (!$email) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'email_invalid']);
    exit;
}

if (empty($message) || mb_strlen($message) < 10) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'message_invalid']);
    exit;
}

// E-Mail zusammenstellen
$subject = "Kontaktanfrage von {$name} via eichhof.me";

$emailBody = "Neue Kontaktanfrage über eichhof.me\n";
$emailBody .= "=====================================\n\n";
$emailBody .= "Name: {$name}\n";
$emailBody .= "E-Mail: {$email}\n";
$emailBody .= "Sprache: {$lang}\n";
$emailBody .= "Zeit: " . date('Y-m-d H:i:s') . "\n\n";
$emailBody .= "Nachricht:\n";
$emailBody .= "-------------------------------------\n";
$emailBody .= html_entity_decode($message, ENT_QUOTES, 'UTF-8') . "\n";
$emailBody .= "-------------------------------------\n";

$headers = [
    'From: ' . $from_email,
    'Reply-To: ' . $email,
    'X-Mailer: eichhof.me Contact Form',
    'Content-Type: text/plain; charset=UTF-8'
];

// E-Mail senden
$mailSent = mail($recipient_email, $subject, $emailBody, implode("\r\n", $headers));

if ($mailSent) {
    // CSRF-Token nach erfolgreichem Submit invalidieren
    unset($_SESSION['contact_csrf']);

    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'send_failed']);
}
