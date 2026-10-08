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
 *                 DA
 *
 * Klick auf einen anderen Eintrag navigiert; auf der neuen Seite ist dann
 * wieder nur die (neue) aktuelle Sprache als Trigger sichtbar.
 *
 * Erwartet aus dem Parent-Scope: $lang, $routeKey, $routes, $m, $e
 * (siehe includes/config/i18n.php).
 *
 * Sprachrouten sind symmetrisch: /de/, /en/, /da/ — jede Sprache hat ihre
 * eigene Kanonische URL, und der Sprachwähler verlinkt direkt dorthin.
 * Bare-Root "/" ist ein reiner Accept-Language-Router (siehe index.php)
 * und wird nie von UI-Elementen adressiert.
 */

// Feste Reihenfolge DE/EN/DA. Der aktuelle Code wird als Trigger gerendert,
// die beiden anderen als Menü-Items darunter — so bleibt die Reihenfolge
// der Menü-Einträge konstant, egal in welcher Sprache man gerade ist.
// Labels folgen ISO 639-1: DA (Dänisch als Sprache), nicht DK (Country-Code).
$switcherOrder = [
    'de' => 'DE',
    'en' => 'EN',
    'da' => 'DA',
];
$currentLabel = $switcherOrder[$lang] ?? 'DE';
// aria-label beginnt mit dem sichtbaren Kürzel ("DE, Sprache wechseln"):
// WCAG 2.5.3 — wer per Sprachsteuerung "klick DE" sagt, muss den Button
// treffen. Ein reines "Sprache wechseln" enthielt das sichtbare Label nicht.
?>
<div class="lang-switcher" data-expanded="false">
    <button type="button"
            class="lang-switcher-current"
            aria-haspopup="true"
            aria-expanded="false"
            aria-label="<?= $currentLabel ?>, <?= $e($m['langSwitcherLabel']) ?>"><?= $currentLabel ?></button>
    <ul class="lang-switcher-menu" role="list">
        <?php foreach ($switcherOrder as $code => $label): ?>
            <?php if ($code === $lang) continue; ?>
            <li><a href="<?= $e($routes[$code][$routeKey]) ?>"
                   class="lang-switcher-link"
                   hreflang="<?= $code ?>"><?= $label ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
