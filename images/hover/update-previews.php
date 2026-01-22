<?php
/**
 * Link Preview Screenshot Update Script
 *
 * Automatically generates preview screenshots for blog and SoundCloud links.
 *
 * Schedule: Weekly on Mondays at 10:10 AM
 */

// Load API key from external file for security
$api_key_file = __DIR__ . '/.apiflash-key';
$api_key = file_exists($api_key_file) ? trim(file_get_contents($api_key_file)) : '';

if (empty($api_key)) {
    die('ERROR: API key not found. Please create .apiflash-key file.');
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
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
];

$logFile = __DIR__ . '/update-log.txt';
$results = [];

foreach ($config['screenshots'] as $screenshot) {
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
            'header' => "User-Agent: {$config['user_agent']}\r\n"
        ]
    ]);

    $imageData = @file_get_contents($apiUrl, false, $context);
    
    if ($imageData !== false) {
        $savePath = __DIR__ . '/' . $screenshot['filename'];
        if (file_put_contents($savePath, $imageData)) {
            $results[] = "[OK] {$screenshot['filename']} (" . round(strlen($imageData) / 1024) . " KB)";
        } else {
            $results[] = "[ERROR] {$screenshot['filename']} - Could not save file";
        }
    } else {
        $results[] = "[ERROR] {$screenshot['filename']} - API request failed";
    }
}

$logEntry = date('Y-m-d H:i:s') . "\n" . implode("\n", $results) . "\n" . str_repeat('-', 40) . "\n";
file_put_contents($logFile, $logEntry, FILE_APPEND);

echo $logEntry;