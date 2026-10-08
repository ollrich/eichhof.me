<?php
/**
 * Person-Schema-Daten, die in beiden JSON-LD-Blöcken (Hauptseite + About)
 * identisch vorkommen. Single Source of Truth für Profile, Orte und Presse.
 *
 * Verwendung:
 *   $person = require __DIR__ . '/includes/config/person.php';
 *   echo '"sameAs": ' . json_encode($person['sameAs'], JSON_UNESCAPED_SLASHES);
 */

// Profile — erscheinen auf der Grounding Page unter "Präsenzen" (mit rel=me)
// und bilden zusammen mit den identifizierenden Projekten das sameAs-Array.
// Einmal hier statt dreimal in i18n.php: Namen sind Marken und werden nicht
// übersetzt, und eine zweite Kopie der Liste lief in der Vergangenheit
// bereits auseinander.
//
// Aufnahmekriterium (Stand Oktober 2026, jedes Profil abgefragt):
// Ein Profil gehört hierher, wenn eine Maschine dort etwas liest, das den
// Steckbrief stützt, und von dort zur Person zurückfindet — nicht, wie
// aktiv es genutzt wird. Deshalb bleibt z. B. XING (einziger crawlbarer
// Rollenbeleg, LinkedIn liefert Crawlern HTTP 999). Bewusst NICHT hier:
// Markenkanäle (YouTube @schongeilDE steht unter "Projekte"), reine
// Fan-Sammlungen (Bandcamp), ruhende Dubletten.
// llms.txt ist statisch und muss bei Änderungen von Hand nachgezogen werden.
$profiles = [
    ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
    ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
    ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
    ['https://norden.social/@olli', 'Mastodon'],
    ['https://www.instagram.com/ollri.ch/', 'Instagram'],
    ['https://soundcloud.com/livicxyz', 'SoundCloud'],
    ['https://sifa.id/p/ollri.ch', 'sifa.id'],
];

return [
    // dateModified wird bei jedem main-Push automatisch auf das
    // Action-Datum gesetzt (siehe .github/workflows/update-sitemap.yml).
    // Format der Zeile nicht ändern — die Action ersetzt sie per sed.
    // datePublished ist pro Seite im jeweiligen JSON-LD hinterlegt.
    'dateModified' => '2026-10-08',

    // DJ-Alias. Ohne ihn fehlt die Brücke zum SoundCloud-Profil, das nur
    // "livic" nennt und weder Klarnamen noch Rücklink trägt.
    'alternateName' => 'livic',

    // Orte sprachneutral mit Wikidata-Kennung. Vorher stand hier je Seite
    // und Sprache ein anderer String ("Hamburg", "Hamburg, Deutschland",
    // "Hamborg, Tyskland") — für dieselbe @id. Die Kennung macht den Ort
    // eindeutig, der Name ist dann nur noch Beschriftung.
    'homeLocation' => ['@type' => 'Place',   'name' => 'Hamburg',     'sameAs' => 'https://www.wikidata.org/wiki/Q1055'],
    'birthPlace'   => ['@type' => 'Place',   'name' => 'Bremerhaven', 'sameAs' => 'https://www.wikidata.org/wiki/Q2706'],
    'nationality'  => ['@type' => 'Country', 'name' => 'Deutschland', 'sameAs' => 'https://www.wikidata.org/wiki/Q183'],

    'profiles' => $profiles,

    // Profile + Projekte, die die Person identifizieren. YouTube @schongeilDE
    // steht zwar unter "Projekte", ist aber ein Markenkanal und fehlt hier
    // deshalb bewusst.
    'sameAs' => array_merge(array_column($profiles, 0), [
        'https://www.schongeil.de/',
        'https://github.com/ollrich',
    ]),

    'subjectOf' => [
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/oliver-polak-interview-2/290215/'],
        ['@type' => 'Article', 'url' => 'https://www.testspiel.de/kid-simius-interview/276764/'],
    ],
];
