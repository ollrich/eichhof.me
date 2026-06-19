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

    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";

    // Read existing log
    $existingLog = file_exists($log_file) ? file($log_file, FILE_IGNORE_NEW_LINES) : [];

    // Add new entry
    $existingLog[] = trim($logEntry);

    // Rotate if too many entries
    if (count($existingLog) > $max_log_entries) {
        $existingLog = array_slice($existingLog, -$max_log_entries);
    }

    // Write back
    file_put_contents($log_file, implode("\n", $existingLog) . "\n");
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

// Git reset
exec("git reset --hard origin/{$branch} 2>&1", $output, $return_var);
if ($return_var !== 0) {
    writeLog('ERROR: git reset failed: ' . implode("\n", $output));
    http_response_code(500);
    die('Git reset failed');
}

// Ensure rate limit file exists (may be deleted by git reset)
$ratelimit_file = __DIR__ . '/.contact-ratelimit.json';
if (!file_exists($ratelimit_file)) {
    file_put_contents($ratelimit_file, '{}');
    chmod($ratelimit_file, 0666);
    writeLog('INFO: Recreated .contact-ratelimit.json');
}

// Log success
$commit = $data['head_commit']['message'] ?? 'Unknown commit';
$pusher = $data['pusher']['name'] ?? 'Unknown';
writeLog("SUCCESS: Deployed commit by {$pusher}: " . substr($commit, 0, 50));

echo "Deployment successful!\n";
