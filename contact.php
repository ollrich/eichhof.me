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

// Config-Werte strikt als RFC-valide Adressen validieren.
// Falls die Config je kompromittiert wird, schließt filter_var
// u. a. CR/LF-Injection in From:/Reply-To-Headern aus.
$recipient_email = filter_var($config['recipient_email'] ?? '', FILTER_VALIDATE_EMAIL);
$from_email = filter_var($config['from_email'] ?? '', FILTER_VALIDATE_EMAIL);

if (!$recipient_email || !$from_email) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'config_invalid']);
    exit;
}

$rate_limit_file = __DIR__ . '/.contact-ratelimit.json';

// Rate-Limit- und Anti-Spam-Schwellen
const CONTACT_MAX_REQUESTS = 3;        // max. Anfragen pro IP-Hash im Fenster
const CONTACT_TIME_WINDOW = 600;       // Fenster in Sekunden (10 Minuten)
const CONTACT_MIN_SUBMIT_TIME = 3;     // Mindestzeit zwischen Form-Load und Submit

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
 * Client-IP fürs Rate-Limiting.
 *
 * Bewusst NUR REMOTE_ADDR: Die Seite läuft ohne CDN/Reverse-Proxy direkt
 * beim Hoster. Proxy-Header wie X-Forwarded-For / CF-Connecting-IP sind
 * daher nicht vertrauenswürdig — würde man sie auswerten, könnte ein
 * Angreifer pro Request einen anderen Wert senden und das Rate-Limit
 * trivial umgehen (jede gefälschte IP = neuer Hash-Bucket).
 */
function getClientIP() {
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
    // Hash IP for privacy (rate limiting doesn't need the actual IP)
    $ipHash = hash('sha256', $ip . 'rate_limit_salt');
    $now = time();

    // 'c+': zum Lesen/Schreiben öffnen, Datei anlegen falls sie fehlt,
    // OHNE sie zu truncaten. Der exklusive Lock serialisiert gleichzeitige
    // Submits, damit das read-modify-write nicht durch eine Race verloren
    // geht (ohne Lock könnten parallele Requests sich gegenseitig
    // überschreiben und das Limit aushebeln oder die Datei korrumpieren).
    $fh = @fopen($file, 'c+');
    if ($fh === false) {
        // Datei nicht öffenbar: im Zweifel den Request durchlassen, statt
        // das Kontaktformular komplett zu blockieren.
        return true;
    }
    if (!flock($fh, LOCK_EX)) {
        fclose($fh);
        return true;
    }

    $content = stream_get_contents($fh);
    $data = json_decode($content, true) ?: [];

    // Alte Einträge ausserhalb des Zeitfensters entfernen
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
    $allowed = count($ipRequests) < $max;

    if ($allowed) {
        // Neuen Request speichern (mit Hash) und Datei von vorne neu schreiben
        $data[$ipHash][] = $now;
        rewind($fh);
        ftruncate($fh, 0);
        fwrite($fh, json_encode($data));
        fflush($fh);
    }

    flock($fh, LOCK_UN);
    fclose($fh);

    return $allowed;
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
if (!checkRateLimit($clientIP, $rate_limit_file, CONTACT_MAX_REQUESTS, CONTACT_TIME_WINDOW)) {
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

// Zeitbasierte Prüfung: contact.js setzt _t immer beim Öffnen des Formulars.
// Fehlendes _t heisst direkter POST am Formular vorbei = Bot. Timestamps aus
// der Zukunft ergeben eine negative Differenz und fallen ebenfalls durch.
$formLoadTime = (int) ($data['_t'] ?? 0);
$submitTime = time();

if ($formLoadTime <= 0 || ($submitTime - $formLoadTime) < CONTACT_MIN_SUBMIT_TIME) {
    // Fehlender Timestamp oder zu schnell = Bot, Fake-Erfolg
    echo json_encode(['success' => true]);
    exit;
}

// Formularfelder validieren
$name = sanitizeInput($data['name'] ?? '', 100);
// Name fliesst in den Mail-Subject: Zeilenumbrüche entfernen, damit ein
// präparierter Name dort keine zusätzlichen Header injizieren kann. Neuere
// PHP-Versionen blocken CRLF im Subject selbst, aber explizit ist robuster.
$name = trim(str_replace(["\r", "\n"], ' ', $name));
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
