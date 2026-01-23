<?php
/**
 * Link Preview Screenshot Update Script
 *
 * Automatically generates preview screenshots for blog and SoundCloud links.
 *
 * Schedule: Weekly on Mondays at 10:10 AM
 * 
 * Improvements:
 * - Better error handling with detailed messages
 * - Request timeout to prevent hanging
 * - Response validation (checks for actual image data)
 * - Backup of existing files before overwriting
 * - Rate limiting between API requests
 * - Exit codes for cron job monitoring
 */

$api_key_file = __DIR__ . '/.apiflash-key';

if (!file_exists($api_key_file)) {
    fwrite(STDERR, "ERROR: API key file not found: {$api_key_file}\n");
    exit(1);
}

$api_key = trim(file_get_contents($api_key_file));

if (empty($api_key)) {
    fwrite(STDERR, "ERROR: API key file is empty\n");
    exit(1);
}

$config = [
    'access_key' => $api_key,
    'screenshots' => [
        [
            'url' => 'https://schongeil.de',
            'filename' => 'blog-preview.webp'
        ],
        [
            'url' => 'https://schongeil.de/en/',
            'filename' => 'blog-preview-en.webp'
        ],
        [
            'url' => 'https://soundcloud.com/ollie-eichhof',
            'filename' => 'soundcloud-preview.webp'
        ]
    ],
    'width' => 1280,
    'height' => 720,
    'format' => 'webp',
    'quality' => 80,
    'timeout' => 60,
    'rate_limit_delay' => 2,
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
];

$logFile = __DIR__ . '/update-log.txt';
$results = [];
$errorCount = 0;

foreach ($config['screenshots'] as $index => $screenshot) {
    if ($index > 0) {
        sleep($config['rate_limit_delay']);
    }

    $apiUrl = 'https://api.apiflash.com/v1/urltoimage?' . http_build_query([
        'access_key' => $config['access_key'],
        'url' => $screenshot['url'],
        'width' => $config['width'],
        'height' => $config['height'],
        'format' => $config['format'],
        'quality' => $config['quality'],
        'fresh' => 'true',
        'no_cookie_banners' => 'true',
        'no_ads' => 'true',
        'no_tracking' => 'true',
        'user_agent' => $config['user_agent']
    ]);

    $context = stream_context_create([
        'http' => [
            'header' => "User-Agent: {$config['user_agent']}\r\n",
            'timeout' => $config['timeout'],
            'ignore_errors' => true
        ]
    ]);

    $imageData = file_get_contents($apiUrl, false, $context);
    
    if ($imageData === false) {
        $error = error_get_last();
        $errorMessage = $error['message'] ?? 'Unknown error';
        $results[] = "[ERROR] {$screenshot['filename']} - Request failed: {$errorMessage}";
        $errorCount++;
        continue;
    }

    if (strlen($imageData) < 1000) {
        $jsonResponse = json_decode($imageData, true);
        if ($jsonResponse !== null && isset($jsonResponse['error'])) {
            $results[] = "[ERROR] {$screenshot['filename']} - API error: {$jsonResponse['error']}";
        } else {
            $results[] = "[ERROR] {$screenshot['filename']} - Response too small (" . strlen($imageData) . " bytes)";
        }
        $errorCount++;
        continue;
    }

    if (strpos($imageData, 'RIFF') !== 0) {
        $results[] = "[ERROR] {$screenshot['filename']} - Invalid image format (not a valid WebP file)";
        $errorCount++;
        continue;
    }

    $savePath = __DIR__ . '/' . $screenshot['filename'];
    $backupPath = $savePath . '.bak';

    if (file_exists($savePath)) {
        if (!copy($savePath, $backupPath)) {
            $results[] = "[WARN] {$screenshot['filename']} - Could not create backup";
        }
    }

    if (file_put_contents($savePath, $imageData)) {
        $sizeKB = round(strlen($imageData) / 1024);
        $results[] = "[OK] {$screenshot['filename']} ({$sizeKB} KB)";
        
        if (file_exists($backupPath)) {
            unlink($backupPath);
        }
    } else {
        $results[] = "[ERROR] {$screenshot['filename']} - Could not save file";
        $errorCount++;
        
        if (file_exists($backupPath)) {
            rename($backupPath, $savePath);
            $results[] = "[INFO] {$screenshot['filename']} - Restored from backup";
        }
    }
}

$timestamp = date('Y-m-d H:i:s');
$status = $errorCount === 0 ? 'SUCCESS' : "COMPLETED WITH {$errorCount} ERROR(S)";
$logEntry = "{$timestamp} [{$status}]\n" . implode("\n", $results) . "\n" . str_repeat('-', 50) . "\n";

file_put_contents($logFile, $logEntry, FILE_APPEND);
echo $logEntry;

exit($errorCount > 0 ? 1 : 0);
