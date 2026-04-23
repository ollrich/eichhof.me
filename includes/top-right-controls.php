<?php
/**
 * Top-Right-Controls-Wrapper. Bündelt Sprachwähler und Theme-Toggle
 * zu einer Fixed-Gruppe oben rechts. Gemeinsam, damit Abstand und
 * Ausrichtung zentral gepflegt werden — nicht je Seite dupliziert.
 *
 * Erwartet $m, $e, $lang, $routeKey, $routes aus dem Parent-Scope
 * (siehe lang-switcher.php und theme-toggle.php).
 */
?>
<div class="top-right-controls">
    <?php include __DIR__ . '/lang-switcher.php'; ?>
    <?php include __DIR__ . '/theme-toggle.php'; ?>
</div>
