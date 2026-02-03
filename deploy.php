<?php
/**
 * GitHub Webhook Deploy Script
 *
 * Automatisches Deployment via Git Pull bei GitHub Push-Events
 *
 * Security Features:
 * - GitHub IP whitelist validation
 * - Webhook signature verification (SHA256)
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
 * GitHub IP ranges (CIDR notation)
 * Source: https://api.github.com/meta
 * Updated: 2024-01 - Should be periodically verified
 */
$github_ip_ranges = [
    '192.30.252.0/22',
    '185.199.108.0/22',
    '140.82.112.0/20',
    '143.55.64.0/20',
    '2a0a:a440::/29',
    '2606:50c0::/32'
];

/**
 * Log function with rotation
 */
function writeLog($message) {
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
 * Check if IP is within CIDR range
 */
function ipInRange($ip, $cidr) {
    // Handle IPv6
    if (strpos($cidr, ':') !== false) {
        return ipv6InRange($ip, $cidr);
    }

    list($subnet, $bits) = explode('/', $cidr);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask;

    return ($ip & $mask) === $subnet;
}

/**
 * Check if IPv6 is within CIDR range
 */
function ipv6InRange($ip, $cidr) {
    list($subnet, $bits) = explode('/', $cidr);
    $bits = (int) $bits;

    $ipBin = inet_pton($ip);
    $subnetBin = inet_pton($subnet);

    if ($ipBin === false || $subnetBin === false) {
        return false;
    }

    $ipHex = bin2hex($ipBin);
    $subnetHex = bin2hex($subnetBin);

    $ipBits = '';
    $subnetBits = '';

    for ($i = 0; $i < strlen($ipHex); $i++) {
        $ipBits .= str_pad(base_convert($ipHex[$i], 16, 2), 4, '0', STR_PAD_LEFT);
        $subnetBits .= str_pad(base_convert($subnetHex[$i], 16, 2), 4, '0', STR_PAD_LEFT);
    }

    return substr($ipBits, 0, $bits) === substr($subnetBits, 0, $bits);
}

/**
 * Validate request comes from GitHub
 */
function isGitHubRequest($ip, $ranges) {
    foreach ($ranges as $range) {
        if (ipInRange($ip, $range)) {
            return true;
        }
    }
    return false;
}

/**
 * Get client IP (handles proxies)
 */
function getClientIP() {
    $headers = [
        'HTTP_CF_CONNECTING_IP',     // Cloudflare
        'HTTP_X_FORWARDED_FOR',      // General proxy
        'HTTP_X_REAL_IP',            // Nginx proxy
        'REMOTE_ADDR'                // Direct connection
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = $_SERVER[$header];
            // X-Forwarded-For can contain multiple IPs
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

// ============================================================================
// VALIDATION
// ============================================================================

$clientIP = getClientIP();

// IP Whitelist check
if (!isGitHubRequest($clientIP, $github_ip_ranges)) {
    writeLog("ERROR: Request from non-GitHub IP: {$clientIP}");
    http_response_code(403);
    die('Forbidden: Invalid source IP');
}

// Webhook Secret validation
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

// Log success
$commit = $data['head_commit']['message'] ?? 'Unknown commit';
$pusher = $data['pusher']['name'] ?? 'Unknown';
writeLog("SUCCESS: Deployed commit by {$pusher}: " . substr($commit, 0, 50));

echo "Deployment successful!\n";
