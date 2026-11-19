<?php
/**
 * GitHub Webhook Deploy Script
 *
 * Automatisches Deployment via Git Pull bei GitHub Push-Events
 *
 * Security: Die HMAC-SHA256-Signaturprüfung (fail-closed) ist die alleinige
 * Authentisierung. Früher gab es zusätzlich eine GitHub-IP-Whitelist — bewusst
 * entfernt: GitHub rotiert seine Hook-IP-Ranges, eine hartcodierte Liste bricht
 * Deploys still, sobald sie veraltet, bei kaum Sicherheitsgewinn obendrauf.
 *
 * - Webhook signature verification (HMAC-SHA256, fail-closed)
 * - Log rotation (max 100 entries)
 */

// Konfiguration
$secret_file = __DIR__ . '/.webhook-secret';
$secret = file_exists($secret_file) ? trim(file_get_contents($secret_file)) : '';
$repo_dir = __DIR__;
$branch = 'main';
$log_file = __DIR__ . '/.deploy-log.txt';
$max_log_entries = 100;

/**
 * Log function with rotation
 */
function writeLog(string $message): void {
    global $log_file, $max_log_entries;

    $logEntry = '[' . date('Y-m-d H:i:s') . '] ' . trim($message);

    // Gleiches Muster wie checkRateLimit() in contact.php:
    // - umask 0077: neu angelegt ist das Log nur für den PHP-Nutzer lesbar
    //   (es enthält Client-IPs).
    // - Exklusiver Lock: zwei gleichzeitige Webhook-Aufrufe würden sich sonst
    //   beim read-modify-write gegenseitig Zeilen überschreiben.
    $oldUmask = umask(0077);
    $fh = @fopen($log_file, 'c+');
    umask($oldUmask);
    if ($fh === false) {
        return;   // Logging darf den Deploy nicht verhindern
    }
    if (flock($fh, LOCK_EX)) {
        $content = stream_get_contents($fh);
        $lines = $content === '' ? [] : explode("\n", rtrim($content, "\n"));
        $lines[] = $logEntry;

        // Rotate if too many entries
        if (count($lines) > $max_log_entries) {
            $lines = array_slice($lines, -$max_log_entries);
        }

        rewind($fh);
        ftruncate($fh, 0);
        fwrite($fh, implode("\n", $lines) . "\n");
        fflush($fh);
        flock($fh, LOCK_UN);
    }
    fclose($fh);

    // Bestehendes Log aus der Zeit vor dem umask auf 0600 ziehen (gelingt nur,
    // wenn PHP Eigentümer ist — dann bleibt es für PHP beschreibbar).
    if ((fileperms($log_file) & 0777) !== 0600) {
        @chmod($log_file, 0600);
    }
}

/**
 * Client-IP — nur fürs Deploy-Log (Herkunft des Push), nicht für Auth.
 * Bewusst NUR REMOTE_ADDR: ohne CDN/Reverse-Proxy sind Proxy-Header wie
 * X-Forwarded-For frei spoofbar und damit wertlos.
 */
function getClientIP(): string {
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

// ============================================================================
// VALIDATION
// ============================================================================

$clientIP = getClientIP();

// Webhook Secret validation (fail-closed: missing secret refuses deployment)
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if ($secret === '') {
    writeLog('ERROR: Webhook secret missing or empty - refusing to deploy');
    http_response_code(500);
    die('Server misconfigured: webhook secret not set');
}

if ($signature === '') {
    writeLog('ERROR: Missing X-Hub-Signature-256 header');
    http_response_code(403);
    die('Missing signature');
}

$expected_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected_signature, $signature)) {
    writeLog('ERROR: Invalid webhook signature');
    http_response_code(403);
    die('Invalid signature');
}

// Event type check
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
if ($event !== 'push') {
    writeLog("INFO: Ignoring event type: {$event}");
    die('Not a push event');
}

// Parse payload
$data = json_decode($payload, true);
if ($data === null) {
    writeLog('ERROR: Invalid JSON payload');
    http_response_code(400);
    die('Invalid payload');
}

$pushed_branch = str_replace('refs/heads/', '', $data['ref'] ?? '');

if ($pushed_branch !== $branch) {
    writeLog("INFO: Push to branch '{$pushed_branch}' ignored (only deploying '{$branch}')");
    die("Not deploying branch: {$pushed_branch}");
}

writeLog("INFO: Received push to '{$branch}' from {$clientIP} - starting deployment");

// ============================================================================
// DEPLOYMENT
// ============================================================================

chdir($repo_dir);

$output = [];
$return_var = 0;

// Git fetch
exec('git fetch origin 2>&1', $output, $return_var);
if ($return_var !== 0) {
    writeLog('ERROR: git fetch failed: ' . implode("\n", $output));
    http_response_code(500);
    die('Git fetch failed');
}

// Git reset — $output leeren: exec() hängt an ein bestehendes Array an, ein
// Fehler-Log enthielte sonst auch die Ausgabe von git fetch.
$output = [];
exec("git reset --hard origin/{$branch} 2>&1", $output, $return_var);
if ($return_var !== 0) {
    writeLog('ERROR: git reset failed: ' . implode("\n", $output));
    http_response_code(500);
    die('Git reset failed');
}

// Rate-Limit-Datei: contact.php legt sie bei Bedarf selbst an (fopen 'c+',
// Rechte 0600), und git reset --hard lässt die gitignorte Datei ohnehin
// unangetastet. Früher wurde sie hier mit 0666 (weltweit beschreibbar)
// angelegt. Bestehende Dateien werden deshalb auf 0600 gezogen: chmod
// gelingt nur, wenn PHP Eigentümer ist — dann bleibt sie für PHP
// beschreibbar. Sonst ändert sich nichts.
$ratelimit_file = __DIR__ . '/.contact-ratelimit.json';
if (file_exists($ratelimit_file) && (fileperms($ratelimit_file) & 0777) !== 0600) {
    if (@chmod($ratelimit_file, 0600)) {
        writeLog('INFO: .contact-ratelimit.json auf 0600 gesetzt');
    }
}

// Log success
$commit = $data['head_commit']['message'] ?? 'Unknown commit';
$pusher = $data['pusher']['name'] ?? 'Unknown';
writeLog("SUCCESS: Deployed commit by {$pusher}: " . substr($commit, 0, 50));

echo "Deployment successful!\n";
