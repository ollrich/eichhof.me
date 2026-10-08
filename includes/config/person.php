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
    'dateModified' => '2026-10-08',

    // DJ-Alias. Ohne ihn fehlt die Brücke zum SoundCloud-Profil, das nur
    // "livic" nennt und weder Klarnamen noch Rücklink trägt.
    'alternateName' => 'livic',

    // Aufnahmekriterium (Stand Oktober 2026, jedes Profil abgefragt):
    // Ein Profil gehört hierher, wenn eine Maschine dort etwas liest, das
    // den Steckbrief stützt, und von dort zur Person zurückfindet — nicht,
    // wie aktiv es genutzt wird. Deshalb bleibt z. B. XING (einziger
    // crawlbarer Rollenbeleg, LinkedIn liefert Crawlern HTTP 999).
    // Bewusst NICHT hier: Markenkanäle (YouTube @schongeilDE steht unter
    // "Projekte"), reine Fan-Sammlungen (Bandcamp), ruhende Dubletten.
    // Wer ein Profil ergänzt: auch die Präsenzen-Liste in i18n.php und
    // llms.txt nachziehen.
    'sameAs' => [
        'https://www.linkedin.com/in/olivereichhof',
        'https://www.xing.com/profile/Oliver_Eichhof2/',
        'https://www.schongeil.de/',
        'https://github.com/ollrich',
        'https://bsky.app/profile/ollri.ch',
        'https://norden.social/@olli',
        'https://www.instagram.com/ollri.ch/',
        'https://soundcloud.com/livicxyz',
        'https://sifa.id/p/ollri.ch',
    ],
    'subjectOf' => [
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/oliver-polak-interview-2/290215/'],
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/kid-simius-interview/276764/'],
    ],
];
