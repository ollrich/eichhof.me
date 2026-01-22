<?php
/**
 * GitHub Webhook Deploy Script
 *
 * Automatisches Deployment via Git Pull bei GitHub Push-Events
 */

// Konfiguration
$secret_file = __DIR__ . '/.webhook-secret';
$secret = file_exists($secret_file) ? trim(file_get_contents($secret_file)) : '';
$repo_dir = __DIR__; // Verzeichnis des Git-Repositories
$branch = 'main'; // Branch der deployed werden soll
$log_file = __DIR__ . '/.deploy-log.txt'; // Log-Datei

// Funktion zum Loggen
function writeLog($message) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    file_put_contents($log_file, $logEntry, FILE_APPEND);
}

// Webhook Secret validieren
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (!empty($secret)) {
    $expected_signature = 'sha256=' . hash_hmac('sha256', $payload, $secret);

    if (!hash_equals($expected_signature, $signature)) {
        writeLog('ERROR: Invalid webhook signature');
        http_response_code(403);
        die('Invalid signature');
    }
}

// Event-Typ prüfen
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
if ($event !== 'push') {
    writeLog("INFO: Ignoring event type: {$event}");
    die('Not a push event');
}

// Payload parsen
$data = json_decode($payload, true);
$pushed_branch = str_replace('refs/heads/', '', $data['ref'] ?? '');

if ($pushed_branch !== $branch) {
    writeLog("INFO: Push to branch '{$pushed_branch}' ignored (only deploying '{$branch}')");
    die("Not deploying branch: {$pushed_branch}");
}

writeLog("INFO: Received push to '{$branch}' branch - starting deployment");

// Git Pull ausführen
chdir($repo_dir);

// Git Pull
$output = [];
$return_var = 0;

exec('git fetch origin 2>&1', $output, $return_var);
if ($return_var !== 0) {
    writeLog('ERROR: git fetch failed: ' . implode("\n", $output));
    http_response_code(500);
    die('Git fetch failed');
}

exec("git reset --hard origin/{$branch} 2>&1", $output, $return_var);
if ($return_var !== 0) {
    writeLog('ERROR: git reset failed: ' . implode("\n", $output));
    http_response_code(500);
    die('Git reset failed');
}

// Erfolg loggen
$commit = $data['head_commit']['message'] ?? 'Unknown commit';
$pusher = $data['pusher']['name'] ?? 'Unknown';
writeLog("SUCCESS: Deployed commit by {$pusher}: {$commit}");

// Commit-Details
foreach ($output as $line) {
    writeLog("  {$line}");
}

echo "Deployment successful!\n";
writeLog(str_repeat('-', 60));
