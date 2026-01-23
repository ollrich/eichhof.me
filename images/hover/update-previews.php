<?php
/**
 * Link Preview Screenshot Update Script
 * =====================================
 *
 * PURPOSE:
 * Automatically generates preview screenshots for blog and social media links
 * that appear in hover tooltips on the main page.
 *
 * REQUIREMENTS:
 * - API Key: Requires ApiFlash API key stored in .apiflash-key file
 *   (Get your key at https://apiflash.com)
 * - Cron Job: Designed to run weekly (e.g., Mondays at 10:10 AM)
 * - PHP 7.4+: Uses null coalescing operator and modern PHP features
 *
 * USAGE:
 * - CLI: php update-previews.php
 * - HTTP: https://yourdomain.com/images/hover/update-previews.php
 * - Cron: 10 10 * * 1 /usr/bin/php /path/to/update-previews.php
 *
 * FEATURES:
 * - Robust error handling with detailed logging
 * - Request timeout protection (60s default)
 * - Response validation (size and format checks)
 * - Automatic file backup before overwriting
 * - Rate limiting between requests (2s delay)
 * - Exit codes for cron monitoring (0=success, 1=error)
 *
 * SECURITY:
 * - API key stored in separate file (.apiflash-key)
 * - File is gitignored and blocked by .htaccess
 * - Privacy-respecting API options (no_cookie_banners, no_ads, no_tracking)
 */

// ============================================================================
// CONFIGURATION LOADING
// ============================================================================

// Load API key from separate file (not in git repository)
// WHY: Keeps sensitive credentials out of version control
$api_key_file = __DIR__ . '/.apiflash-key';

if (!file_exists($api_key_file)) {
    fwrite(STDERR, "ERROR: API key file not found: {$api_key_file}\n");
    exit(1); // Exit code 1 = error (useful for cron monitoring)
}

$api_key = trim(file_get_contents($api_key_file));

if (empty($api_key)) {
    fwrite(STDERR, "ERROR: API key file is empty\n");
    exit(1);
}

// ============================================================================
// SCREENSHOT CONFIGURATION
// ============================================================================

$config = [
    'access_key' => $api_key,

    // List of URLs to screenshot
    // HOW: Each screenshot appears when hovering over corresponding social links
    'screenshots' => [
        [
            'url' => 'https://schongeil.de',
            'filename' => 'blog-preview.webp'  // German version
        ],
        [
            'url' => 'https://schongeil.de/en/',
            'filename' => 'blog-preview-en.webp'  // English version
        ],
        [
            'url' => 'https://soundcloud.com/livicxyz',
            'filename' => 'soundcloud-preview.webp'
        ]
    ],

    // Screenshot dimensions
    // WHY: 1280x720 (16:9) is a good balance between detail and file size
    'width' => 1280,
    'height' => 720,

    // Image format and quality
    // WHY: WebP offers best compression (~30% smaller than JPEG)
    'format' => 'webp',
    'quality' => 80,  // Good balance between quality and file size

    // Request timeout in seconds
    // WHY: Prevents script from hanging if API is slow
    'timeout' => 60,

    // Delay between requests in seconds
    // WHY: Respects API rate limits and prevents overwhelming the service
    'rate_limit_delay' => 2,

    // User agent for requests
    // WHY: Some sites render differently for different browsers
    // We use Chrome user agent for consistent, modern rendering
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
];

// ============================================================================
// INITIALIZATION
// ============================================================================

$logFile = __DIR__ . '/update-log.txt';  // Persistent log file
$results = [];  // Results for current run
$errorCount = 0;  // Track failures for exit code

// ============================================================================
// SCREENSHOT GENERATION LOOP
// ============================================================================

foreach ($config['screenshots'] as $index => $screenshot) {
    // Rate limiting: Wait between requests (except for first one)
    // WHY: Prevents hitting API rate limits
    if ($index > 0) {
        sleep($config['rate_limit_delay']);
    }

    // Build ApiFlash API URL with all parameters
    // WHAT: ApiFlash is a URL-to-image service (https://apiflash.com)
    // HOW: Parameters control screenshot behavior and privacy options
    $apiUrl = 'https://api.apiflash.com/v1/urltoimage?' . http_build_query([
        'access_key' => $config['access_key'],
        'url' => $screenshot['url'],
        'width' => $config['width'],
        'height' => $config['height'],
        'format' => $config['format'],
        'quality' => $config['quality'],
        'fresh' => 'true',  // Force fresh screenshot (bypass cache)

        // Privacy-respecting options
        // WHY: Creates cleaner screenshots and respects user privacy
        'no_cookie_banners' => 'true',  // Auto-hide cookie consent popups
        'no_ads' => 'true',              // Remove advertisements
        'no_tracking' => 'true',         // Block tracking scripts

        'user_agent' => $config['user_agent']
    ]);

    // Create HTTP context with timeout and error handling
    // WHY: Prevents script from hanging on slow responses
    $context = stream_context_create([
        'http' => [
            'header' => "User-Agent: {$config['user_agent']}\r\n",
            'timeout' => $config['timeout'],
            'ignore_errors' => true  // Continue on HTTP errors (we'll validate manually)
        ]
    ]);

    // Fetch screenshot from API
    $imageData = file_get_contents($apiUrl, false, $context);

    // ========================================================================
    // ERROR HANDLING: Request failed
    // ========================================================================

    if ($imageData === false) {
        $error = error_get_last();
        $errorMessage = $error['message'] ?? 'Unknown error';
        $results[] = "[ERROR] {$screenshot['filename']} - Request failed: {$errorMessage}";
        $errorCount++;
        continue;  // Skip to next screenshot
    }

    // ========================================================================
    // VALIDATION: Check response size
    // ========================================================================

    // Minimum size check (1000 bytes)
    // WHY: Valid images are always larger; small responses are usually errors
    if (strlen($imageData) < 1000) {
        // Try to parse as JSON error response
        $jsonResponse = json_decode($imageData, true);
        if ($jsonResponse !== null && isset($jsonResponse['error'])) {
            $results[] = "[ERROR] {$screenshot['filename']} - API error: {$jsonResponse['error']}";
        } else {
            $results[] = "[ERROR] {$screenshot['filename']} - Response too small (" . strlen($imageData) . " bytes)";
        }
        $errorCount++;
        continue;
    }

    // ========================================================================
    // VALIDATION: Check file format
    // ========================================================================

    // WebP files start with "RIFF" magic bytes
    // WHY: Ensures we got an actual image, not an error page
    if (strpos($imageData, 'RIFF') !== 0) {
        $results[] = "[ERROR] {$screenshot['filename']} - Invalid image format (not a valid WebP file)";
        $errorCount++;
        continue;
    }

    // ========================================================================
    // FILE BACKUP & SAVE
    // ========================================================================

    $savePath = __DIR__ . '/' . $screenshot['filename'];
    $backupPath = $savePath . '.bak';

    // Create backup of existing file before overwriting
    // WHY: If save fails, we can restore the old version
    if (file_exists($savePath)) {
        if (!copy($savePath, $backupPath)) {
            $results[] = "[WARN] {$screenshot['filename']} - Could not create backup";
        }
    }

    // Save new screenshot
    if (file_put_contents($savePath, $imageData)) {
        $sizeKB = round(strlen($imageData) / 1024);
        $results[] = "[OK] {$screenshot['filename']} ({$sizeKB} KB)";

        // Success: Remove backup file
        if (file_exists($backupPath)) {
            unlink($backupPath);
        }
    } else {
        // Save failed: Try to restore backup
        $results[] = "[ERROR] {$screenshot['filename']} - Could not save file";
        $errorCount++;

        if (file_exists($backupPath)) {
            rename($backupPath, $savePath);
            $results[] = "[INFO] {$screenshot['filename']} - Restored from backup";
        }
    }
}

// ============================================================================
// LOGGING & EXIT
// ============================================================================

// Create log entry with timestamp and results
$timestamp = date('Y-m-d H:i:s');
$status = $errorCount === 0 ? 'SUCCESS' : "COMPLETED WITH {$errorCount} ERROR(S)";
$logEntry = "{$timestamp} [{$status}]\n" . implode("\n", $results) . "\n" . str_repeat('-', 50) . "\n";

// Append to log file
file_put_contents($logFile, $logEntry, FILE_APPEND);

// Output to console (useful for manual runs and cron emails)
echo $logEntry;

// Exit with appropriate code
// WHY: Allows cron monitoring tools to detect failures
// 0 = success, 1 = errors occurred
exit($errorCount > 0 ? 1 : 0);
