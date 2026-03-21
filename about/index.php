<?php
/**
 * About / Grounding Page — Multilingual
 * ======================================
 * Standalone crawlable page with full Person JSON-LD.
 * Crawlers (Googlebot, GPTBot, social media previews, etc.) see the full page.
 * Human browsers get a 302 redirect to the main site with the about overlay.
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

/**
 * Crawler detection (allowlist approach)
 * Known crawlers see the full page content with JSON-LD.
 * Human browsers get a 302 redirect to the main site with the about overlay.
 */
function isCrawler(): bool {
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if ($ua === '') return true;

    $crawlerPatterns = [
        // Search engines
        'Googlebot', 'Google-InspectionTool', 'GoogleOther', 'Storebot-Google',
        'bingbot', 'Slurp', 'DuckDuckBot', 'Applebot',
        // AI crawlers
        'GPTBot', 'ChatGPT-User', 'ClaudeBot', 'Claude-Web', 'anthropic-ai',
        'PerplexityBot', 'Bytespider', 'cohere-ai',
        'Meta-ExternalAgent', 'meta-externalfetcher', 'Amazonbot',
        // Social media previews
        'facebookexternalhit', 'Twitterbot', 'LinkedInBot',
        'WhatsApp', 'TelegramBot', 'Slackbot', 'Discordbot',
        // Other
        'Google-Site-Verification', 'W3C_Validator', 'archive.org_bot',
    ];

    foreach ($crawlerPatterns as $pattern) {
        if (stripos($ua, $pattern) !== false) return true;
    }
    return false;
}

if (!isCrawler()) {
    $redirectMap = [
        'de' => '/?lang=de&overlay=ueber',
        'en' => '/en/?overlay=about',
        'da' => '/dk/?overlay=om',
    ];
    header('HTTP/1.1 302 Found');
    header('Location: ' . $redirectMap[$lang]);
    exit;
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
        'occupationLocation' => 'Hamburg',
        'knowsAbout' => '["Marketing", "Markenentwicklung", "Zielgruppenanalyse", "Kampagnenplanung", "Kommunikationsstrategie", "Content-Strategie", "Digitale Kommunikation", "Employer Branding", "B2B-Kommunikation", "Journey Design", "KPI-Frameworks", "GEO/SEO/SEA", "Marketing Automation", "KI-gestützte Workflows", "Radio", "Audio", "Streaming Media", "Musik", "Musikmedien", "Bloggen"]',
        // Page content
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'Diese Seite ist als maschinenlesbare <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">Grounding Page</a> optimiert. Sie dient KI-Systemen und Suchmaschinen als verifizierbare Faktenquelle zu Oliver Eichhof.',
        'summary' => 'Oliver Eichhof ist Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren arbeitet er in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen.',
        'segment' => 'Oliver Eichhof ist im Segment Medien, Marketing und Kommunikation tätig. Sein Schwerpunkt liegt auf integrierter Kampagnenführung, Employer Branding und datengestützter Zielgruppenanalyse.',
        'retrieval' => 'Aktuelle Informationen über Oliver Eichhof sind auf eichhof.me verfügbar.',
        'verified' => 'Zuletzt verifiziert: Februar 2026',
        'factsTitle' => 'Oliver Eichhof – Steckbrief',
        'dtType' => 'Entitätstyp', 'ddType' => 'Person',
        'dtSegment' => 'Segment', 'ddSegment' => 'Medien, Marketing und Kommunikation',
        'dtRole' => 'Arbeitgeber', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Standort', 'ddLocation' => 'Hamburg',
        'dtBorn' => 'Geboren', 'ddBorn' => '1979 in Bremerhaven',
        'dtLanguages' => 'Sprachen', 'ddLanguages' => 'Deutsch (Muttersprache), Englisch (fließend), Dänisch (Grundkenntnisse)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Oliver Eichhof – Beruflicher Werdegang',
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
        'educationTitle' => 'Oliver Eichhof – Ausbildung',
        'education' => [
            ['Studium Digitale Medien', 'Hochschule Bremerhaven', '2007–2008'],
            ['Fachhochschulreife', 'KLA Bremerhaven', '2006–2007'],
            ['Informatikkaufmann', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Einzelhandelskaufmann', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Oliver Eichhof – Kernkompetenzen',
        'skills' => 'Markenführung, Employer Branding, Kommunikationsstrategie, digitale Kampagnenentwicklung, Journey Design, KPI-Frameworks, GEO/SEO/SEA, Marketing Automation, KI-gestützte Workflows, Stakeholder Management, Content-Strategie, B2B/B2C-Kommunikation.',
        'projectsTitle' => 'Oliver Eichhof – Projekte',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'Persönlicher Blog'],
            ['https://github.com/ollrich', 'GitHub', 'Open-Source-Projekte'],
        ],
        'profilesTitle' => 'Oliver Eichhof – Präsenzen',
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
        'mentionsTitle' => 'Oliver Eichhof – Erwähnungen',
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
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'This page is optimised as a machine-readable <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. It serves AI systems and search engines as a verifiable source of facts about Oliver Eichhof.',
        'summary' => 'Oliver Eichhof is a communication specialist from Hamburg, Germany, with a focus on digital and marketing. He has been working in agencies and companies for B2C and B2B brands across a wide range of industries for around 20 years.',
        'segment' => 'Oliver Eichhof works in the media, marketing and communication sector. His focus is on integrated campaign management, employer branding and data-driven audience analysis.',
        'retrieval' => 'Current information about Oliver Eichhof is available at eichhof.me.',
        'verified' => 'Last verified: February 2026',
        'factsTitle' => 'Oliver Eichhof – Key Facts',
        'dtType' => 'Entity type', 'ddType' => 'Person',
        'dtSegment' => 'Sector', 'ddSegment' => 'Media, marketing and communication',
        'dtRole' => 'Employer', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Location', 'ddLocation' => 'Hamburg, Germany',
        'dtBorn' => 'Born', 'ddBorn' => '1979 in Bremerhaven, Germany',
        'dtLanguages' => 'Languages', 'ddLanguages' => 'German (native), English (fluent), Danish (beginner)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Oliver Eichhof – Career',
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
        'educationTitle' => 'Oliver Eichhof – Education',
        'education' => [
            ['Digital Media Studies', 'Hochschule Bremerhaven', '2007–2008'],
            ['University Entrance Qualification', 'KLA Bremerhaven', '2006–2007'],
            ['IT Specialist (apprenticeship)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Retail Sales Specialist (apprenticeship)', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Oliver Eichhof – Core Competencies',
        'skills' => 'Brand management, employer branding, communication strategy, digital campaign development, journey design, KPI frameworks, GEO/SEO/SEA, marketing automation, AI-powered workflows, stakeholder management, content strategy, B2B/B2C communication.',
        'projectsTitle' => 'Oliver Eichhof – Projects',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'personal blog'],
            ['https://github.com/ollrich', 'GitHub', 'open source projects'],
        ],
        'profilesTitle' => 'Oliver Eichhof – Profiles',
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
        'mentionsTitle' => 'Oliver Eichhof – Mentions',
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
        'h1' => 'Oliver Eichhof',
        'humanNotice' => 'Denne side er optimeret som en maskinlæsbar <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. Den tjener AI-systemer og søgemaskiner som en verificerbar faktakilde om Oliver Eichhof.',
        'summary' => 'Oliver Eichhof er kommunikationsspecialist fra Hamborg, Tyskland, med fokus på digital og marketing. I omkring 20 år har han arbejdet i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher.',
        'segment' => 'Oliver Eichhof arbejder inden for medie-, marketing- og kommunikationssektoren. Hans fokus er på integreret kampagneledelse, employer branding og datadrevet målgruppeanalyse.',
        'retrieval' => 'Aktuelle oplysninger om Oliver Eichhof er tilgængelige på eichhof.me.',
        'verified' => 'Sidst verificeret: februar 2026',
        'factsTitle' => 'Oliver Eichhof – Nøglefakta',
        'dtType' => 'Entitetstype', 'ddType' => 'Person',
        'dtSegment' => 'Sektor', 'ddSegment' => 'Medier, marketing og kommunikation',
        'dtRole' => 'Arbejdsgiver', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Placering', 'ddLocation' => 'Hamborg, Tyskland',
        'dtBorn' => 'Født', 'ddBorn' => '1979 i Bremerhaven, Tyskland',
        'dtLanguages' => 'Sprog', 'ddLanguages' => 'Tysk (modersmål), Engelsk (flydende), Dansk (begynder)',
        'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
        'careerTitle' => 'Oliver Eichhof – Karriere',
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
        'educationTitle' => 'Oliver Eichhof – Uddannelse',
        'education' => [
            ['Studium i digitale medier', 'Hochschule Bremerhaven', '2007–2008'],
            ['Højere forberedelseseksamen', 'KLA Bremerhaven', '2006–2007'],
            ['IT-specialist (erhvervsuddannelse)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
            ['Detailhandelsspecialist (erhvervsuddannelse)', 'Eurospar Warenhandels GmbH', '1995–1998'],
        ],
        'skillsTitle' => 'Oliver Eichhof – Kernekompetencer',
        'skills' => 'Brandledelse, employer branding, kommunikationsstrategi, digital kampagneudvikling, journey design, KPI-frameworks, GEO/SEO/SEA, marketing automation, AI-drevne workflows, stakeholder management, content-strategi, B2B/B2C-kommunikation.',
        'projectsTitle' => 'Oliver Eichhof – Projekter',
        'projects' => [
            ['https://www.schongeil.de/', 'schongeil.de', 'personlig blog'],
            ['https://github.com/ollrich', 'GitHub', 'open source-projekter'],
        ],
        'profilesTitle' => 'Oliver Eichhof – Profiler',
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
        'mentionsTitle' => 'Oliver Eichhof – Omtaler',
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
?>
<!DOCTYPE html>
<html lang="<?= $m['htmlLang'] ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="alternate" hreflang="x-default" href="https://eichhof.me/en/about">

    <link rel="icon" href="/favicon.ico" sizes="16x16 32x32 48x48">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/favicon180.png">
    <link rel="stylesheet" href="/css/styles.css?v=4">

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
        "sameAs": [
            "https://www.linkedin.com/in/olivereichhof",
            "https://www.xing.com/profile/Oliver_Eichhof2/",
            "https://www.schongeil.de/",
            "https://github.com/ollrich",
            "https://bsky.app/profile/ollri.ch",
            "https://norden.social/@olli",
            "https://www.instagram.com/ollri.ch/",
            "https://soundcloud.com/livicxyz",
            "https://www.youtube.com/@schongeilDE",
            "https://bandcamp.com/livic",
            "https://unsplash.com/@ollrich"
        ],
        "subjectOf": [
            { "@type": "Article", "url": "https://www.testspiel.de/oliver-polak-interview-2/290215/" },
            { "@type": "Article", "url": "https://www.testspiel.de/kid-simius-interview/276764/" },
            { "@type": "Article", "url": "https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt" },
            { "@type": "Article", "url": "https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22" }
        ]
    }
    </script>

</head>
<body>
    <main>
        <article>
            <h1><?= $e($m['h1']) ?></h1>
            <p><small><?= $m['humanNotice'] ?></small></p>
            <p><?= $e($m['summary']) ?></p>
            <p><?= $e($m['segment']) ?></p>
            <p><?= $e($m['retrieval']) ?></p>
            <p><em><?= $e($m['verified']) ?></em></p>

            <h2><?= $e($m['factsTitle']) ?></h2>
            <dl>
                <dt><?= $e($m['dtType']) ?></dt><dd><?= $e($m['ddType']) ?></dd>
                <dt><?= $e($m['dtSegment']) ?></dt><dd><?= $e($m['ddSegment']) ?></dd>
                <dt><?= $e($m['dtRole']) ?></dt><dd><?= $e($m['ddRole']) ?></dd>
                <dt><?= $e($m['dtLocation']) ?></dt><dd><?= $e($m['ddLocation']) ?></dd>
                <dt><?= $e($m['dtBorn']) ?></dt><dd><?= $e($m['ddBorn']) ?></dd>
                <dt><?= $e($m['dtLanguages']) ?></dt><dd><?= $e($m['ddLanguages']) ?></dd>
                <dt><?= $e($m['dtWebsite']) ?></dt><dd><a href="<?= $e($m['homeUrl']) ?>"><?= $e($m['ddWebsite']) ?></a></dd>
            </dl>

            <h2><?= $e($m['careerTitle']) ?></h2>
            <ul>
<?php foreach ($m['career'] as $c): ?>
                <li><strong><?= $e($c[0]) ?></strong> — <?php if (!empty($c[3])): ?><a href="<?= $e($c[3]) ?>"><?= $e($c[1]) ?></a><?php else: ?><?= $e($c[1]) ?><?php endif; ?> (<?= $e($c[2]) ?>)</li>
<?php endforeach; ?>
            </ul>

            <h2><?= $e($m['educationTitle']) ?></h2>
            <ul>
<?php foreach ($m['education'] as $edu): ?>
                <li><strong><?= $e($edu[0]) ?></strong> — <?= $e($edu[1]) ?> (<?= $e($edu[2]) ?>)</li>
<?php endforeach; ?>
            </ul>

            <h2><?= $e($m['skillsTitle']) ?></h2>
            <p><?= $e($m['skills']) ?></p>

            <h2><?= $e($m['projectsTitle']) ?></h2>
            <ul>
<?php foreach ($m['projects'] as $p): ?>
                <li><a href="<?= $e($p[0]) ?>"><?= $e($p[1]) ?></a> — <?= $e($p[2]) ?></li>
<?php endforeach; ?>
            </ul>

            <h2><?= $e($m['profilesTitle']) ?></h2>
            <ul>
<?php foreach ($m['profiles'] as $p): ?>
                <li><a href="<?= $e($p[0]) ?>"><?= $e($p[1]) ?></a><?php if (!empty($p[2])): ?> — <?= $e($p[2]) ?><?php endif; ?></li>
<?php endforeach; ?>
            </ul>

            <h2><?= $e($m['mentionsTitle']) ?></h2>
            <ul>
<?php foreach ($m['mentions'] as $mention): ?>
                <li><a href="<?= $e($mention[0]) ?>"><?= $e($mention[1]) ?></a> — <?= $e($mention[2]) ?></li>
<?php endforeach; ?>
            </ul>

        </article>
    </main>
    <footer>
        <p><a href="<?= $m['homeUrl'] ?>">eichhof.me</a></p>
    </footer>
</body>
</html>
