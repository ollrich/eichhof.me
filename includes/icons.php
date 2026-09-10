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

    // Roboterkopf (Material "smart_toy")
    '{robot}' => '<svg class="icon-inline" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">'
        . '<path d="M20 9V7c0-1.1-.9-2-2-2h-3c0-1.66-1.34-3-3-3S9 3.34 9 5H6c-1.1 0-2 .9-2 2v2c-1.66 0-3 1.34-3 3s1.34 3 3 3v4c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-4c1.66 0 3-1.34 3-3s-1.34-3-3-3zM7.5 11.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5S9.83 13 9 13s-1.5-.67-1.5-1.5zM16 17H8v-2h8v2zm-1-4c-.83 0-1.5-.67-1.5-1.5S14.17 10 15 10s1.5.67 1.5 1.5S15.83 13 15 13z"/>'
        . '</svg>',
];
