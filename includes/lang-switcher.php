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
 * Besonderheit beim DE-Home-Link (/): Ruft ein EN- oder DA-Browser-User
 * "DE" auf, müsste er erst den Accept-Language-302 in index.php umgehen,
 * der ihn sonst sofort wieder auf /en/ bzw. /dk/ zurückschubst. Daher
 * hängen wir in dem Fall ?lang=de als Override an. JS räumt das ?lang=
 * danach per history.replaceState aus der URL raus.
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
            <?php
            $target = $routes[$code][$routeKey];
            // DE-Home aus fremdsprachigem Kontext: ?lang=de-Override gegen
            // das Accept-Language-302 auf / in index.php.
            if ($code === 'de' && $routeKey === 'home' && $lang !== 'de') {
                $target .= '?lang=de';
            }
            ?>
            <li><a href="<?= $e($target) ?>"
                   class="lang-switcher-link"
                   hreflang="<?= $code ?>"><?= $label ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
