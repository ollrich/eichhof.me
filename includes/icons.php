<?php
/**
 * Inline-SVG-Icons für Fließtext (aktuell: Footer-Zeile).
 * ======================================================
 * Einfarbig via fill="currentColor" — die Icons erben damit die umgebende
 * Textfarbe (z. B. --footer-color) statt als bunte Emojis auszubrechen.
 * Größe/Ausrichtung kommen aus .icon-inline (gleiches Muster wie .icon-github).
 *
 * aria-hidden, weil der vorlesbare Ersatztext sprachabhängig als sr-only-Span
 * direkt daneben in den i18n-Strings steht.
 *
 * Verwendung: die Platzhalter {heart}/{robot} in den Footer-Strings ersetzen:
 *   $m['footerDesktop'] = strtr($m['footerDesktop'], require 'includes/icons.php');
 */

return [
    // Herz (Material "favorite")
    '{heart}' => '<svg class="icon-inline" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">'
        . '<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>'
        . '</svg>',

    // Roboterkopf: Antennenkugel + Stiel + gefüllter Kopf, Augen als Löcher
    // (fill-rule=evenodd). Bewusst diese Form statt eines Standard-Icons: Die
    // Antenne bricht die Außenkontur, dadurch bleibt der Kopf auch bei 11px
    // als Roboter erkennbar — ein reiner Blockkopf wird in der Größe zum Klecks.
    // Gleiche Größe wie das Herz (1em); abweichende Größen machen die Zeile unruhig.
    '{robot}' => '<svg class="icon-inline" viewBox="0 0 24 24" fill="currentColor" fill-rule="evenodd" aria-hidden="true">'
        . '<circle cx="12" cy="2.6" r="1.6"/>'
        . '<rect x="11.1" y="3.6" width="1.8" height="3.4"/>'
        . '<path d="M6 6h12a4 4 0 0 1 4 4v6a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4v-6a4 4 0 0 1 4-4Zm3 4.6a2.2 2.2 0 1 0 0 4.4 2.2 2.2 0 0 0 0-4.4Zm6 0a2.2 2.2 0 1 0 0 4.4 2.2 2.2 0 0 0 0-4.4Z"/>'
        . '</svg>',
];
