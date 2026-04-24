<?php
/**
 * Sprachwähler als Disclosure-Menü.
 * =================================
 * Standardmäßig sichtbar ist nur die aktuelle Sprache als Button-Trigger.
 * Auf Hover (Desktop), Fokus (Tastatur) oder Tap (Mobile) öffnet sich
 * darunter ein kleines Menü mit den beiden anderen Sprachen:
 *
 *   DE            DE
 *                 EN      ← nach Hover/Tap
 *                 DK
 *
 * Klick auf einen anderen Eintrag navigiert; auf der neuen Seite ist dann
 * wieder nur die (neue) aktuelle Sprache als Trigger sichtbar.
 *
 * Erwartet aus dem Parent-Scope: $lang, $routeKey, $routes, $m, $e
 * (siehe includes/config/i18n.php).
 *
 * Sprachrouten sind symmetrisch: /de/, /en/, /dk/ — jede Sprache hat ihre
 * eigene Kanonische URL, und der Sprachwähler verlinkt direkt dorthin.
 * Bare-Root "/" ist ein reiner Accept-Language-Router (siehe index.php)
 * und wird nie von UI-Elementen adressiert.
 */

// Feste Reihenfolge DE/EN/DK. Der aktuelle Code wird als Trigger gerendert,
// die beiden anderen als Menü-Items darunter — so bleibt die Reihenfolge
// der Menü-Einträge konstant, egal in welcher Sprache man gerade ist.
$switcherOrder = [
    'de' => 'DE',
    'en' => 'EN',
    'da' => 'DK',
];
$currentLabel = $switcherOrder[$lang] ?? 'DE';
?>
<div class="lang-switcher" data-expanded="false">
    <button type="button"
            class="lang-switcher-current"
            aria-haspopup="true"
            aria-expanded="false"
            aria-label="<?= $e($m['langSwitcherLabel']) ?>"><?= $currentLabel ?></button>
    <ul class="lang-switcher-menu">
        <?php foreach ($switcherOrder as $code => $label): ?>
            <?php if ($code === $lang) continue; ?>
            <li><a href="<?= $e($routes[$code][$routeKey]) ?>"
                   class="lang-switcher-link"
                   hreflang="<?= $code ?>"><?= $label ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
