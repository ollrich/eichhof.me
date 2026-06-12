<?php
/**
 * 404 — Seite nicht gefunden
 * ===========================
 * Von Apache als ErrorDocument für nicht existierende URLs gerendert
 * (.htaccess: ErrorDocument 404 /404.php). REQUEST_URI bleibt beim
 * internen Redirect die ursprünglich angefragte URL — daraus wird das
 * Sprachpräfix abgeleitet, damit /en/* eine englische und /da/* (bzw.
 * Legacy /dk/*) eine dänische Fehlerseite bekommt.
 *
 * http_response_code(404) explizit, damit auch ein Direktaufruf von
 * /404.php keinen 200er liefert (Soft-404-Vermeidung).
 */

http_response_code(404);

// Sprache aus dem Pfad-Präfix der angefragten URL ableiten (Default: DE).
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$lang = 'de';
if (preg_match('~^/en(/|$)~', $requestPath)) {
    $lang = 'en';
} elseif (preg_match('~^/(da|dk)(/|$)~', $requestPath)) {
    $lang = 'da';
}

// HTML-Escape für Attribute / Textinhalte.
$e = function($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

$i18nAll = require __DIR__ . '/includes/config/i18n.php';
$m       = array_merge($i18nAll['common'][$lang], $i18nAll['notfound'][$lang]);
$homeUrl = $i18nAll['common']['routes'][$lang]['home'];

// Asset-Helper für automatische Cache-Busting-Versionierung via filemtime().
require_once __DIR__ . '/includes/asset.php';
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include __DIR__ . '/includes/theme-init.php'; ?>

    <meta name="theme-color" content="#764ba2" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0d0d14" media="(prefers-color-scheme: dark)">

    <meta name="robots" content="noindex">
    <title><?= $e($m['title']) ?></title>

    <?php include __DIR__ . '/includes/head-favicons.php'; ?>
    <link rel="stylesheet" href="<?= asset('/css/styles.css') ?>">
</head>
<body>
    <?php include __DIR__ . '/includes/theme-toggle.php'; ?>

    <main>
        <div class="container">
            <h1 class="name">404</h1>
            <p class="tagline"><?= $e($m['notFoundText']) ?> <a href="<?= $homeUrl ?>"><?= $e($m['notFoundBack']) ?></a></p>
        </div>
    </main>

    <script src="<?= asset('/js/theme.js') ?>" defer></script>
</body>
</html>
