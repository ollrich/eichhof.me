<?php
/**
 * About / Grounding Page — Multilingual Standalone
 * =================================================
 * Standalone visual page with full Person JSON-LD.
 * Serves all visitors (crawlers and browsers) with HTTP 200.
 * Styled to match the main site's visual appearance.
 *
 * URLs:
 * - /ueber      → German
 * - /en/about   → English
 * - /dk/om      → Danish
 */

$lang = $_GET['lang'] ?? 'de';
if (!in_array($lang, ['de', 'en', 'da'])) {
    $lang = 'de';
}

$meta = [
    'de' => [
        'htmlLang' => 'de',
        'title' => 'Über Oliver Eichhof – Kommunikationsspezialist aus Hamburg',
        'description' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen tätig.',
        'ogDescription' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing.',
        'ogUrl' => 'https://eichhof.me/ueber',
        'locale' => 'de_DE',
        'canonical' => 'https://eichhof.me/ueber',
        'homeUrl' => 'https://eichhof.me/',
        'jobTitle' => 'Leiter Marketing',
        'personDescription' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen tätig.',
        'inLanguage' => 'de',
        'birthPlace' => 'Bremerhaven, Deutschland',
        'nationality' => 'Deutschland',
        'homeLocation' => 'Hamburg, Deutschland',
        'occupationName' => 'Leiter Marketing',
        'occupationLocation' => 'Hamburg, Deutschland',
        'knowsAbout' => '["Marketing", "Markenentwicklung", "Zielgruppenanalyse", "Kampagnenplanung", "Kommunikationsstrategie", "Content-Strategie", "Digitale Kommunikation", "Employer Branding", "B2B-Kommunikation", "Journey Design", "KPI-Frameworks", "GEO/SEO/SEA", "Marketing Automation", "KI-gestützte Workflows", "Radio", "Audio", "Streaming Media", "Musik", "Musikmedien", "Bloggen"]',
        // UI
        'backText' => 'Zurück zur Hauptseite',
        'skipLink' => 'Zum Inhalt springen',
        'themeDark' => 'Licht aus',
        'themeLight' => 'Licht an',
        'themeToggleLabel' => 'Farbschema wechseln',
        'photoAlt' => 'Porträt von Oliver Eichhof, Kommunikationsspezialist aus Hamburg',
        // Footer
        'legalUrl' => '/impressum',
        'legalLink' => 'Impressum',
        'privacyUrl' => '/datenverarbeitung',
        'privacyLink' => 'Datenverarbeitung',
        'footerEntity' => 'Oliver Eichhof, Kommunikationsspezialist aus Hamburg',
        'footerDesktop' => 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI in Hamburg erstellt',
        'footerMobile' => 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI realisiert',
        'githubTooltip' => 'Quellcode auf GitHub',
        'githubAriaLabel' => 'Quellcode auf GitHub',
        // Impressum overlay
        'closeOverlay' => 'Schließen',
        'overlayTitle' => 'Impressum',
        'overlayText1' => 'Diese Website wird betrieben von:',
        'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg',
        'overlayText3' => 'Kontakt:',
        'overlayText3b' => 'Verantwortlich für den Inhalt nach § 18 Abs. 2 MStV.',
        'privacyTitle' => 'Datenschutzerklärung',
        // Page content
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'Diese Seite ist als maschinenlesbare <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">Grounding Page</a> optimiert. Sie dient KI-Systemen und Suchmaschinen als verifizierbare Faktenquelle zu Oliver Eichhof.',
        'summary' => 'Oliver Eichhof ist Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren arbeitet er in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen.',
        'segment' => 'Oliver Eichhof ist im Segment Medien, Marketing und Kommunikation tätig. Sein Schwerpunkt liegt auf integrierter Kampagnenführung, Employer Branding und datengestützter Zielgruppenanalyse.',
        'retrieval' => 'Aktuelle Informationen über Oliver Eichhof sind auf eichhof.me verfügbar.',
        'verified' => 'Zuletzt verifiziert: April 2026',
        'factsTitle' => 'Steckbrief',
        'dtType' => 'Entitätstyp', 'ddType' => 'Person',
        'dtSegment' => 'Segment', 'ddSegment' => 'Medien, Marketing und Kommunikation',
        'dtRole' => 'Arbeitgeber', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Standort', 'ddLocation' => 'Hamburg',
        'dtBorn' => 'Geboren', 'ddBorn' => '1979 in Bremerhaven',
        'dtLanguages' => 'Sprachen', 'ddLanguages' => 'Deutsch (Muttersprache), Englisch (fließend), Dänisch (Grundkenntnisse)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Beruflicher Werdegang',
        'career' => [
            ['Leiter Marketing', 'REGIOCAST GmbH & Co. KG', 'seit 2026', null],
            ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
            ['Digital Strategist', 'Freiberuflich', '2020–2022', null],
            ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
            ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
            ['Etatdirektor', 'beebop media ag', '2010–2014', null],
            ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
            ['Community Manager', '1000MIKES', '2008–2009', null],
        ],
        'educationTitle' => 'Ausbildung',
        'education' => [
            ['Studium Digitale Medien', 'Hochschule Bremerhaven', '2007–2008'],
            ['Fachhochschulreife', 'KLA Bremerhaven', '2006–2007'],
            ['Informatikkaufmann', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Einzelhandelskaufmann', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Kernkompetenzen',
        'skills' => 'Markenführung, Employer Branding, Kommunikationsstrategie, digitale Kampagnenentwicklung, Journey Design, KPI-Frameworks, GEO/SEO/SEA, Marketing Automation, KI-gestützte Workflows, Stakeholder Management, Content-Strategie, B2B/B2C-Kommunikation.',
        'projectsTitle' => 'Projekte',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'Persönlicher Blog'],
            ['https://github.com/ollrich', 'GitHub', 'Open-Source-Projekte'],
        ],
        'profilesTitle' => 'Präsenzen',
        'profiles' => [
            ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
            ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
            ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
            ['https://norden.social/@olli', 'Mastodon'],
            ['https://www.instagram.com/ollri.ch/', 'Instagram'],
            ['https://soundcloud.com/livicxyz', 'SoundCloud'],
            ['https://www.youtube.com/@schongeilDE', 'YouTube'],
            ['https://bandcamp.com/livic', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Erwähnungen',
        'mentions' => [
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO auf der Next Web Conference'],
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s „Ehe für alle"'],
            ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
            ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
        ],
    ],
    'en' => [
        'htmlLang' => 'en',
        'title' => 'About Oliver Eichhof – Communication Specialist from Hamburg',
        'description' => 'Communication specialist from Hamburg with a focus on digital and marketing. Around 20 years of experience in agencies and companies for B2C and B2B brands across a wide range of industries.',
        'ogDescription' => 'Communication specialist from Hamburg with a focus on digital and marketing.',
        'ogUrl' => 'https://eichhof.me/en/about',
        'locale' => 'en_GB',
        'canonical' => 'https://eichhof.me/en/about',
        'homeUrl' => 'https://eichhof.me/en/',
        'jobTitle' => 'Marketing Director',
        'personDescription' => 'Communication specialist from Hamburg with a focus on digital and marketing. Around 20 years of experience in agencies and companies for B2C and B2B brands across a wide range of industries.',
        'inLanguage' => 'en',
        'birthPlace' => 'Bremerhaven, Germany',
        'nationality' => 'Germany',
        'homeLocation' => 'Hamburg, Germany',
        'occupationName' => 'Marketing Director',
        'occupationLocation' => 'Hamburg, Germany',
        'knowsAbout' => '["Marketing", "Brand Development", "Audience Analysis", "Campaign Planning", "Communication Strategy", "Content Strategy", "Digital Communication", "Employer Branding", "B2B Communication", "Journey Design", "KPI Frameworks", "GEO/SEO/SEA", "Marketing Automation", "AI-powered Workflows", "Radio", "Audio", "Streaming Media", "Music", "Music Media", "Blogging"]',
        // UI
        'backText' => 'Back to main page',
        'skipLink' => 'Skip to content',
        'themeDark' => 'Lights off',
        'themeLight' => 'Lights on',
        'themeToggleLabel' => 'Toggle color scheme',
        'photoAlt' => 'Portrait of Oliver Eichhof, Communication Specialist from Hamburg',
        // Footer
        'legalUrl' => '/en/legal-notice',
        'legalLink' => 'Legal Notice',
        'privacyUrl' => '/en/privacy',
        'privacyLink' => 'Privacy Policy',
        'footerEntity' => 'Oliver Eichhof, Communication Specialist from Hamburg',
        'footerDesktop' => 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI in Hamburg',
        'footerMobile' => 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI',
        'githubTooltip' => 'View source on GitHub',
        'githubAriaLabel' => 'View source on GitHub',
        // Legal overlay
        'closeOverlay' => 'Close',
        'overlayTitle' => 'Legal Notice',
        'overlayText1' => 'This website is operated by:',
        'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Germany',
        'overlayText3' => 'Contact:',
        'overlayText3b' => 'Responsible for content according to § 18 para. 2 German Interstate Media Treaty (MStV).',
        'privacyTitle' => 'Privacy Policy',
        // Page content
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'This page is optimised as a machine-readable <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. It serves AI systems and search engines as a verifiable source of facts about Oliver Eichhof.',
        'summary' => 'Oliver Eichhof is a communication specialist from Hamburg, Germany, with a focus on digital and marketing. He has been working in agencies and companies for B2C and B2B brands across a wide range of industries for around 20 years.',
        'segment' => 'Oliver Eichhof works in the media, marketing and communication sector. His focus is on integrated campaign management, employer branding and data-driven audience analysis.',
        'retrieval' => 'Current information about Oliver Eichhof is available at eichhof.me.',
        'verified' => 'Last verified: April 2026',
        'factsTitle' => 'Key Facts',
        'dtType' => 'Entity type', 'ddType' => 'Person',
        'dtSegment' => 'Sector', 'ddSegment' => 'Media, marketing and communication',
        'dtRole' => 'Employer', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Location', 'ddLocation' => 'Hamburg, Germany',
        'dtBorn' => 'Born', 'ddBorn' => '1979 in Bremerhaven, Germany',
        'dtLanguages' => 'Languages', 'ddLanguages' => 'German (native), English (fluent), Danish (beginner)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Career',
        'career' => [
            ['Marketing Director', 'REGIOCAST GmbH & Co. KG', 'since 2026', null],
            ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
            ['Digital Strategist', 'Freelance', '2020–2022', null],
            ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
            ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
            ['Account Director', 'beebop media ag', '2010–2014', null],
            ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
            ['Community Manager', '1000MIKES', '2008–2009', null],
        ],
        'educationTitle' => 'Education',
        'education' => [
            ['Digital Media Studies', 'Hochschule Bremerhaven', '2007–2008'],
            ['University Entrance Qualification', 'KLA Bremerhaven', '2006–2007'],
            ['IT Specialist (apprenticeship)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Retail Sales Specialist (apprenticeship)', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Core Competencies',
        'skills' => 'Brand management, employer branding, communication strategy, digital campaign development, journey design, KPI frameworks, GEO/SEO/SEA, marketing automation, AI-powered workflows, stakeholder management, content strategy, B2B/B2C communication.',
        'projectsTitle' => 'Projects',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'personal blog'],
            ['https://github.com/ollrich', 'GitHub', 'open source projects'],
        ],
        'profilesTitle' => 'Profiles',
        'profiles' => [
            ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
            ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
            ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
            ['https://norden.social/@olli', 'Mastodon'],
            ['https://www.instagram.com/ollri.ch/', 'Instagram'],
            ['https://soundcloud.com/livicxyz', 'SoundCloud'],
            ['https://www.youtube.com/@schongeilDE', 'YouTube'],
            ['https://bandcamp.com/livic', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Mentions',
        'mentions' => [
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO at The Next Web Conference'],
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Marriage for All" campaign'],
            ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
            ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
        ],
    ],
    'da' => [
        'htmlLang' => 'da',
        'title' => 'Om Oliver Eichhof – Kommunikationsspecialist fra Hamborg',
        'description' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing. Omkring 20 års erfaring i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher.',
        'ogDescription' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing.',
        'ogUrl' => 'https://eichhof.me/dk/om',
        'locale' => 'da_DK',
        'canonical' => 'https://eichhof.me/dk/om',
        'homeUrl' => 'https://eichhof.me/dk/',
        'jobTitle' => 'Marketingchef',
        'personDescription' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing. Omkring 20 års erfaring i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher.',
        'inLanguage' => 'da',
        'birthPlace' => 'Bremerhaven, Tyskland',
        'nationality' => 'Tyskland',
        'homeLocation' => 'Hamborg, Tyskland',
        'occupationName' => 'Marketingchef',
        'occupationLocation' => 'Hamborg, Tyskland',
        'knowsAbout' => '["Marketing", "Brandudvikling", "Målgruppeanalyse", "Kampagneplanlægning", "Kommunikationsstrategi", "Content-strategi", "Digital kommunikation", "Employer branding", "B2B-kommunikation", "Journey design", "KPI-frameworks", "GEO/SEO/SEA", "Marketing automation", "AI-drevne workflows", "Radio", "Audio", "Streaming media", "Musik", "Musikmedier", "Blogging"]',
        // UI
        'backText' => 'Tilbage til hovedsiden',
        'skipLink' => 'Spring til indhold',
        'themeDark' => 'Sluk lyset',
        'themeLight' => 'Tænd lyset',
        'themeToggleLabel' => 'Skift farveskema',
        'photoAlt' => 'Portræt af Oliver Eichhof, Kommunikationsspecialist fra Hamborg',
        // Footer
        'legalUrl' => '/dk/kolofon',
        'legalLink' => 'Kolofon',
        'privacyUrl' => '/dk/privatlivspolitik',
        'privacyLink' => 'Privatlivspolitik',
        'footerEntity' => 'Oliver Eichhof, Kommunikationsspecialist fra Hamborg',
        'footerDesktop' => 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI i Hamburg',
        'footerMobile' => 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI',
        'githubTooltip' => 'Se kildekoden på GitHub',
        'githubAriaLabel' => 'Se kildekoden på GitHub',
        // Kolofon overlay
        'closeOverlay' => 'Luk',
        'overlayTitle' => 'Kolofon',
        'overlayText1' => 'Denne hjemmeside drives af:',
        'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Tyskland',
        'overlayText3' => 'Kontakt:',
        'overlayText3b' => 'Ansvarlig for indhold i henhold til § 18 stk. 2 tysk statslig medieaftale (MStV).',
        'privacyTitle' => 'Privatlivspolitik',
        // Page content
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'Denne side er optimeret som en maskinlæsbar <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. Den tjener AI-systemer og søgemaskiner som en verificerbar faktakilde om Oliver Eichhof.',
        'summary' => 'Oliver Eichhof er kommunikationsspecialist fra Hamborg, Tyskland, med fokus på digital og marketing. I omkring 20 år har han arbejdet i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher.',
        'segment' => 'Oliver Eichhof arbejder inden for medie-, marketing- og kommunikationssektoren. Hans fokus er på integreret kampagneledelse, employer branding og datadrevet målgruppeanalyse.',
        'retrieval' => 'Aktuelle oplysninger om Oliver Eichhof er tilgængelige på eichhof.me.',
        'verified' => 'Sidst verificeret: april 2026',
        'factsTitle' => 'Nøglefakta',
        'dtType' => 'Entitetstype', 'ddType' => 'Person',
        'dtSegment' => 'Sektor', 'ddSegment' => 'Medier, marketing og kommunikation',
        'dtRole' => 'Arbejdsgiver', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Placering', 'ddLocation' => 'Hamborg, Tyskland',
        'dtBorn' => 'Født', 'ddBorn' => '1979 i Bremerhaven, Tyskland',
        'dtLanguages' => 'Sprog', 'ddLanguages' => 'Tysk (modersmål), Engelsk (flydende), Dansk (begynder)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Karriere',
        'career' => [
            ['Marketingchef', 'REGIOCAST GmbH & Co. KG', 'siden 2026', null],
            ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
            ['Digital Strategist', 'Freelance', '2020–2022', null],
            ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
            ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
            ['Account Director', 'beebop media ag', '2010–2014', null],
            ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
            ['Community Manager', '1000MIKES', '2008–2009', null],
        ],
        'educationTitle' => 'Uddannelse',
        'education' => [
            ['Studium i digitale medier', 'Hochschule Bremerhaven', '2007–2008'],
            ['Højere forberedelseseksamen', 'KLA Bremerhaven', '2006–2007'],
            ['IT-specialist (erhvervsuddannelse)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Detailhandelsspecialist (erhvervsuddannelse)', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Kernekompetencer',
        'skills' => 'Brandledelse, employer branding, kommunikationsstrategi, digital kampagneudvikling, journey design, KPI-frameworks, GEO/SEO/SEA, marketing automation, AI-drevne workflows, stakeholder management, content-strategi, B2B/B2C-kommunikation.',
        'projectsTitle' => 'Projekter',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'personlig blog'],
            ['https://github.com/ollrich', 'GitHub', 'open source-projekter'],
        ],
        'profilesTitle' => 'Profiler',
        'profiles' => [
            ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
            ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
            ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
            ['https://norden.social/@olli', 'Mastodon'],
            ['https://www.instagram.com/ollri.ch/', 'Instagram'],
            ['https://soundcloud.com/livicxyz', 'SoundCloud'],
            ['https://www.youtube.com/@schongeilDE', 'YouTube'],
            ['https://bandcamp.com/livic', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Omtaler',
        'mentions' => [
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO på The Next Web Conference'],
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Ægteskab for alle"-kampagne'],
            ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
            ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
        ],
    ],
];

$m = $meta[$lang];
$e = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

// Explicit identity marker for $meta values that intentionally contain
// trusted hardcoded HTML (e.g. <br>, <span class="sr-only">, <a>).
// Using $rawHtml() at the callsite documents the intent so future readers
// don't mistake a missing $e() for an oversight.
$rawHtml = fn($s) => $s;

// Shared Person-Schema-Daten (sameAs, subjectOf) — identisch zwischen Haupt- und About-Seite
$person = require __DIR__ . '/../includes/config/person.php';

// Asset-Helper für automatische Cache-Busting-Versionierung via filemtime()
require_once __DIR__ . '/../includes/asset.php';
?>
<!DOCTYPE html>
<html lang="<?= $m['htmlLang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include __DIR__ . '/../includes/theme-init.php'; ?>

    <meta name="theme-color" content="#764ba2" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0d0d14" media="(prefers-color-scheme: dark)">
    <title><?= $e($m['title']) ?></title>
    <meta name="description" content="<?= $e($m['description']) ?>">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Oliver Eichhof">

    <meta property="og:title" content="<?= $e($m['title']) ?>">
    <meta property="og:description" content="<?= $e($m['ogDescription']) ?>">
    <meta property="og:image" content="https://eichhof.me/images/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="og:url" content="<?= $m['ogUrl'] ?>">
    <meta property="og:type" content="profile">
    <meta property="og:site_name" content="Oliver Eichhof">
    <meta property="og:locale" content="<?= $m['locale'] ?>">
    <meta property="og:locale:alternate" content="de_DE">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:locale:alternate" content="da_DK">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $e($m['title']) ?>">
    <meta name="twitter:description" content="<?= $e($m['ogDescription']) ?>">
    <meta name="twitter:image" content="https://eichhof.me/images/og-image.png">

    <link rel="canonical" href="<?= $m['canonical'] ?>">
    <link rel="alternate" hreflang="de" href="https://eichhof.me/ueber">
    <link rel="alternate" hreflang="en" href="https://eichhof.me/en/about">
    <link rel="alternate" hreflang="da" href="https://eichhof.me/dk/om">
    <link rel="alternate" hreflang="x-default" href="https://eichhof.me/ueber">

    <?php include __DIR__ . '/../includes/head-favicons.php'; ?>
    <link rel="stylesheet" href="<?= asset('/css/styles.css') ?>">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "@id": "https://eichhof.me/#person",
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "<?= $m['canonical'] ?>"
        },
        "name": "Oliver Eichhof",
        "givenName": "Oliver",
        "familyName": "Eichhof",
        "url": "https://eichhof.me/",
        "image": "https://eichhof.me/images/oliver-eichhof.webp",
        "jobTitle": "<?= $e($m['jobTitle']) ?>",
        "description": "<?= $e($m['personDescription']) ?>",
        "inLanguage": "<?= $m['inLanguage'] ?>",
        "birthPlace": { "@type": "Place", "name": "<?= $e($m['birthPlace']) ?>" },
        "birthDate": "1979",
        "homeLocation": { "@type": "Place", "name": "<?= $e($m['homeLocation']) ?>" },
        "nationality": { "@type": "Country", "name": "<?= $e($m['nationality']) ?>" },
        "knowsLanguage": ["de", "en", "da"],
        "knowsAbout": <?= $m['knowsAbout'] ?>,
        "worksFor": {
            "@type": "Organization",
            "name": "REGIOCAST GmbH & Co. KG",
            "url": "https://www.regiocast.de/"
        },
        "alumniOf": [
            { "@type": "EducationalOrganization", "name": "Hochschule Bremerhaven" },
            { "@type": "EducationalOrganization", "name": "KLA Bremerhaven" },
            { "@type": "EducationalOrganization", "name": "Kreishandwerkerschaft Bremerhaven" }
        ],
        "hasOccupation": [
            {
                "@type": "Occupation",
                "name": "<?= $e($m['occupationName']) ?>",
                "occupationLocation": { "@type": "Place", "name": "<?= $e($m['occupationLocation']) ?>" }
            }
        ],
        "sameAs": <?= json_encode($person['sameAs'], JSON_UNESCAPED_SLASHES) ?>,
        "subjectOf": <?= json_encode($person['subjectOf'], JSON_UNESCAPED_SLASHES) ?>
    }
    </script>
</head>
<body>
    <a href="#main" class="skip-link"><?= $e($m['skipLink']) ?></a>

    <!-- Theme Toggle Button -->
    <?php include __DIR__ . '/../includes/theme-toggle.php'; ?>

    <main id="main" class="grounding-page">
        <a href="<?= $m['homeUrl'] ?>" class="grounding-back">&larr; <?= $e($m['backText']) ?></a>

        <img src="/images/oliver-eichhof.webp"
             srcset="/images/oliver-eichhof-320.webp 320w, /images/oliver-eichhof-640.webp 640w, /images/oliver-eichhof.webp 960w"
             sizes="120px"
             width="120" height="120"
             decoding="async"
             fetchpriority="high"
             alt="<?= $e($m['photoAlt']) ?>"
             class="profile-photo">

        <h1 class="name"><?= $e($m['h1']) ?></h1>

        <div class="overlay-content about-content">
            <div class="about-section">
                <p><?= $e($m['summary']) ?></p>
                <p><?= $e($m['segment']) ?></p>
            </div>

            <section class="about-section">
                <h3><?= $e($m['factsTitle']) ?></h3>
                <dl class="about-facts">
                    <dt><?= $e($m['dtType']) ?></dt><dd><?= $e($m['ddType']) ?></dd>
                    <dt><?= $e($m['dtSegment']) ?></dt><dd><?= $e($m['ddSegment']) ?></dd>
                    <dt><?= $e($m['dtRole']) ?></dt><dd><?= $e($m['ddRole']) ?></dd>
                    <dt><?= $e($m['dtLocation']) ?></dt><dd><?= $e($m['ddLocation']) ?></dd>
                    <dt><?= $e($m['dtBorn']) ?></dt><dd><?= $e($m['ddBorn']) ?></dd>
                    <dt><?= $e($m['dtLanguages']) ?></dt><dd><?= $e($m['ddLanguages']) ?></dd>
                    <dt><?= $e($m['dtWebsite']) ?></dt><dd><a href="<?= $e($m['homeUrl']) ?>"><?= $e($m['ddWebsite']) ?></a></dd>
                </dl>
            </section>

            <section class="about-section">
                <h3><?= $e($m['careerTitle']) ?></h3>
                <ul class="about-career">
<?php foreach ($m['career'] as $c): ?>
                    <li><strong><?= $e($c[0]) ?></strong> — <?php if (!empty($c[3])): ?><a href="<?= $e($c[3]) ?>"><?= $e($c[1]) ?></a><?php else: ?><?= $e($c[1]) ?><?php endif; ?> <span class="about-year"><?= $e($c[2]) ?></span></li>
<?php endforeach; ?>
                </ul>
            </section>

            <section class="about-section">
                <h3><?= $e($m['educationTitle']) ?></h3>
                <ul class="about-career">
<?php foreach ($m['education'] as $edu): ?>
                    <li><strong><?= $e($edu[0]) ?></strong> — <?= $e($edu[1]) ?> <span class="about-year"><?= $e($edu[2]) ?></span></li>
<?php endforeach; ?>
                </ul>
            </section>

            <section class="about-section">
                <h3><?= $e($m['skillsTitle']) ?></h3>
                <p><?= $e($m['skills']) ?></p>
            </section>

            <section class="about-section">
                <h3><?= $e($m['projectsTitle']) ?></h3>
                <ul class="about-links">
<?php foreach ($m['projects'] as $p): ?>
                    <li><a href="<?= $e($p[0]) ?>" target="_blank" rel="noopener noreferrer"><?= $e($p[1]) ?></a> — <?= $e($p[2]) ?></li>
<?php endforeach; ?>
                </ul>
            </section>

            <section class="about-section">
                <h3><?= $e($m['profilesTitle']) ?></h3>
                <ul class="about-links">
<?php foreach ($m['profiles'] as $p): ?>
                    <li><a href="<?= $e($p[0]) ?>" target="_blank" rel="noopener noreferrer me"><?= $e($p[1]) ?></a></li>
<?php endforeach; ?>
                </ul>
            </section>

            <section class="about-section">
                <h3><?= $e($m['mentionsTitle']) ?></h3>
                <ul class="about-links">
<?php foreach ($m['mentions'] as $mention): ?>
                    <li><a href="<?= $e($mention[0]) ?>" target="_blank" rel="noopener noreferrer"><?= $e($mention[1]) ?></a> — <?= $e($mention[2]) ?></li>
<?php endforeach; ?>
                </ul>
            </section>

            <p class="about-notice"><?= $rawHtml($m['humanNotice']) ?></p>

            <p class="about-notice"><?= $e($m['retrieval']) ?> <em><?= $e($m['verified']) ?></em></p>
        </div>
        <!-- Mobile-only footer -->
        <div class="mobile-footer">
            <a href="<?= $m['legalUrl'] ?>" id="footer-link-mobile"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> · </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link-mobile"><?= $e($m['privacyLink']) ?></a>
            <span class="sr-only"><?= $e($m['footerEntity']) ?></span>
            <span><?= $rawHtml($m['footerMobile']) ?></span>
        </div>
    </main>

    <!-- Footer Elements -->
    <div class="footer-left">
        <a href="<?= $m['legalUrl'] ?>" id="footer-link"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> · </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link"><?= $e($m['privacyLink']) ?></a>
    </div>

    <span class="sr-only"><?= $e($m['footerEntity']) ?></span>

    <div class="footer">
        <span><?= $rawHtml($m['footerDesktop']) ?></span>
        <span class="github-link-wrapper">•
            <span class="github-tooltip"><?= $e($m['githubTooltip']) ?></span>
            <a href="https://github.com/ollrich/eichhof.me" target="_blank" rel="noopener noreferrer" class="footer-link">
                <svg class="icon-github" viewBox="0 0 16 16" fill="currentColor" aria-label="<?= $e($m['githubAriaLabel']) ?>">
                    <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"/>
                </svg>
            </a>
        </span>
    </div>

    <!-- Modal Overlay (Impressum/Legal Notice) -->
    <div class="overlay" id="overlay">
        <div class="overlay-content">
            <button class="close-overlay" id="close-overlay-btn" aria-label="<?= $e($m['closeOverlay']) ?>">
                <svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="2" y1="2" x2="12" y2="12"/><line x1="12" y1="2" x2="2" y2="12"/>
                </svg>
            </button>
            <h2 id="overlay-title"><?= $e($m['overlayTitle']) ?></h2>
            <p id="overlay-text-1"><?= $e($m['overlayText1']) ?></p>
            <p id="overlay-text-2"><?= $rawHtml($m['overlayText2']) ?></p>
            <p><span id="overlay-text-3"><?= $e($m['overlayText3']) ?></span> <a href="#" id="overlay-email-link" class="overlay-email-link"></a></p>
            <p id="overlay-text-3b"><?= $e($m['overlayText3b']) ?></p>
        </div>
    </div>

    <!-- Modal Overlay (Privacy / Datenschutzerklärung) -->
    <div class="overlay" id="privacy-overlay">
        <div class="overlay-content">
            <button class="close-overlay" id="close-privacy-btn" aria-label="<?= $e($m['closeOverlay']) ?>">
                <svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="2" y1="2" x2="12" y2="12"/><line x1="12" y1="2" x2="2" y2="12"/>
                </svg>
            </button>
            <h2 id="privacy-title"><?= $e($m['privacyTitle']) ?></h2>
            <?php include __DIR__ . '/../includes/overlays/privacy-' . ($lang === 'da' ? 'da' : $lang) . '.php'; ?>
        </div>
    </div>

    <script src="<?= asset('/js/grounding-email.js') ?>" defer></script>
    <script src="<?= asset('/js/theme.js') ?>" defer></script>
    <script src="<?= asset('/js/overlay.js') ?>" defer></script>
</body>
</html>
