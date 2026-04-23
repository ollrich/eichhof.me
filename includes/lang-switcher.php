<?php
/**
 * Sprachwähler. Drei dezente Textlinks (DE/EN/DK) oben rechts,
 * links vom Theme-Toggle. Gedacht als Ergänzung zur automatischen
 * Browser-Spracherkennung — nicht als Ersatz.
 *
 * Erwartet aus dem Parent-Scope:
 *   $lang     — aktuelle Sprache ('de' | 'en' | 'da')
 *   $routeKey — 'home' | 'about' | 'legal' | 'privacy' | 'contact'
 *   $routes   — $i18nAll['common']['routes']
 *   $m        — Meta-Array mit langSwitcherLabel
 *   $e        — htmlspecialchars-Closure
 *
 * Besonderheit beim DE-Home-Link (/): Ruft ein EN- oder DA-Browser-User
 * "DE" auf, müsste er erst den Accept-Language-302 in index.php umgehen,
 * der ihn sonst sofort wieder auf /en/ bzw. /dk/ zurückschubst. Daher
 * hängen wir in dem Fall ?lang=de als Override an. index.php erkennt
 * den Query, setzt 'de' und überspringt das 302. JS räumt das ?lang=
 * danach per history.replaceState aus der URL raus.
 */

$switcherLanguages = [
    'de' => 'DE',
    'en' => 'EN',
    'da' => 'DK',
];
?>
<nav class="lang-switcher" aria-label="<?= $e($m['langSwitcherLabel']) ?>">
    <?php foreach ($switcherLanguages as $code => $label): ?>
        <?php
        $target = $routes[$code][$routeKey];
        // DE-Home aus fremdsprachigem Kontext: ?lang=de-Override, damit das
        // Accept-Language-302 in index.php bei EN/DA-Browsern nicht greift.
        if ($code === 'de' && $routeKey === 'home' && $lang !== 'de') {
            $target .= '?lang=de';
        }
        ?>
        <a href="<?= $e($target) ?>"
           class="lang-switcher-link"
           hreflang="<?= $code ?>"<?= $code === $lang ? ' aria-current="true"' : '' ?>><?= $label ?></a>
    <?php endforeach; ?>
</nav>
