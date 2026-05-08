<?php
/**
 * Person-Schema-Daten, die in beiden JSON-LD-Blöcken (Hauptseite + About)
 * identisch vorkommen. Single Source of Truth für Social-Profile und Presse.
 *
 * Verwendung:
 *   $person = require __DIR__ . '/includes/config/person.php';
 *   echo '"sameAs": ' . json_encode($person['sameAs'], JSON_UNESCAPED_SLASHES);
 */

return [
    // dateModified wird bei jedem main-Push automatisch auf das
    // Action-Datum gesetzt (siehe .github/workflows/update-sitemap.yml).
    // datePublished ist pro Seite im jeweiligen JSON-LD hinterlegt.
    'dateModified' => '2026-05-08',
    'sameAs' => [
        'https://www.linkedin.com/in/olivereichhof',
        'https://www.xing.com/profile/Oliver_Eichhof2/',
        'https://www.schongeil.de/',
        'https://github.com/ollrich',
        'https://bsky.app/profile/ollri.ch',
        'https://norden.social/@olli',
        'https://www.instagram.com/ollri.ch/',
        'https://soundcloud.com/livicxyz',
        'https://www.youtube.com/@schongeilDE',
        'https://bandcamp.com/livic',
        'https://unsplash.com/@ollrich',
        'https://sifa.id/p/ollri.ch',
    ],
    'subjectOf' => [
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/oliver-polak-interview-2/290215/'],
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/kid-simius-interview/276764/'],
        ['@type' => 'Article', 'url' => 'https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt'],
        ['@type' => 'Article', 'url' => 'https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22'],
    ],
];
