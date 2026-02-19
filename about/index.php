<?php
/**
 * About / Grounding Page — Multilingual
 * ======================================
 * Standalone crawlable page with full Person JSON-LD.
 * Human visitors are redirected to the main site with the about overlay.
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
        'description' => 'Digitaler Marken- und Kommunikationsstratege aus Hamburg. Leiter Marketing bei REGIOCAST. Über 15 Jahre Erfahrung in Kampagnenführung, Employer Branding und B2B-Kommunikation.',
        'ogDescription' => 'Digitaler Marken- und Kommunikationsstratege aus Hamburg. Leiter Marketing bei REGIOCAST.',
        'ogUrl' => 'https://eichhof.me/ueber',
        'locale' => 'de_DE',
        'canonical' => 'https://eichhof.me/ueber',
        'redirect' => '/?lang=de&overlay=ueber',
        'homeUrl' => 'https://eichhof.me/',
        'jobTitle' => 'Leiter Marketing',
        'personDescription' => 'Digitaler Marken- und Kommunikationsstratege aus Hamburg mit mehr als 15 Jahren Erfahrung in integrierter Kampagnenführung, Employer Branding und B2B-Kommunikation.',
        'inLanguage' => 'de',
        'birthPlace' => 'Bremerhaven',
        'nationality' => 'Deutschland',
        'homeLocation' => 'Hamburg',
        'occupationName' => 'Leiter Marketing',
        'occupationLocation' => 'Hamburg',
        'knowsAbout' => '["Marketing", "Markenentwicklung", "Zielgruppenanalyse", "Kampagnenplanung", "Kommunikationsstrategie", "Content-Strategie", "Digitale Kommunikation", "Employer Branding", "B2B-Kommunikation", "Journey Design", "KPI-Frameworks", "GEO/SEO/SEA", "Marketing Automation", "KI-gestützte Workflows", "Radio", "Audio", "Streaming Media", "Musik", "Musikmedien", "Bloggen"]',
        // Page content
        'h1' => 'Über Oliver Eichhof',
        'summary' => 'Digitaler Marken- und Kommunikationsstratege aus Hamburg mit mehr als 15 Jahren Erfahrung in integrierter Kampagnenführung, Employer Branding und B2B-Kommunikation.',
        'factsTitle' => 'Steckbrief',
        'dtRole' => 'Arbeitgeber', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Standort', 'ddLocation' => 'Hamburg',
        'dtBorn' => 'Geboren', 'ddBorn' => '1979 in Bremerhaven',
        'dtLanguages' => 'Sprachen', 'ddLanguages' => 'Deutsch (Muttersprache), Englisch (fließend), Dänisch (Grundkenntnisse)',
        'careerTitle' => 'Beruflicher Werdegang',
        'career' => [
            ['Leiter Marketing', 'REGIOCAST GmbH & Co. KG', 'seit 2026', null],
            ['Strategy Director Marketing', 'wirDesign communication AG', '2023–2025', null],
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
            ['https://ollrich.bandcamp.com/', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Erwähnungen',
        'mentions' => [
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s „Ehe für alle"'],
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO auf der Next Web Conference'],
            ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
            ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
        ],
    ],
    'en' => [
        'htmlLang' => 'en',
        'title' => 'About Oliver Eichhof – Communication Specialist from Hamburg',
        'description' => 'Digital brand and communication strategist from Hamburg. Head of Marketing at REGIOCAST. Over 15 years of experience in campaign management, employer branding and B2B communication.',
        'ogDescription' => 'Digital brand and communication strategist from Hamburg. Head of Marketing at REGIOCAST.',
        'ogUrl' => 'https://eichhof.me/en/about',
        'locale' => 'en_GB',
        'canonical' => 'https://eichhof.me/en/about',
        'redirect' => '/en/?overlay=about',
        'homeUrl' => 'https://eichhof.me/en/',
        'jobTitle' => 'Head of Marketing',
        'personDescription' => 'Digital brand and communication strategist from Hamburg with over 15 years of experience in integrated campaign management, employer branding and B2B communication.',
        'inLanguage' => 'en',
        'birthPlace' => 'Bremerhaven, Germany',
        'nationality' => 'Germany',
        'homeLocation' => 'Hamburg, Germany',
        'occupationName' => 'Head of Marketing',
        'occupationLocation' => 'Hamburg, Germany',
        'knowsAbout' => '["Marketing", "Brand Development", "Audience Analysis", "Campaign Planning", "Communication Strategy", "Content Strategy", "Digital Communication", "Employer Branding", "B2B Communication", "Journey Design", "KPI Frameworks", "GEO/SEO/SEA", "Marketing Automation", "AI-powered Workflows", "Radio", "Audio", "Streaming Media", "Music", "Music Media", "Blogging"]',
        'h1' => 'About Oliver Eichhof',
        'summary' => 'Digital brand and communication strategist from Hamburg with over 15 years of experience in integrated campaign management, employer branding and B2B communication.',
        'factsTitle' => 'Key Facts',
        'dtRole' => 'Employer', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Location', 'ddLocation' => 'Hamburg, Germany',
        'dtBorn' => 'Born', 'ddBorn' => '1979 in Bremerhaven, Germany',
        'dtLanguages' => 'Languages', 'ddLanguages' => 'German (native), English (fluent), Danish (beginner)',
        'careerTitle' => 'Career',
        'career' => [
            ['Head of Marketing', 'REGIOCAST GmbH & Co. KG', 'since 2026', null],
            ['Strategy Director Marketing', 'wirDesign communication AG', '2023–2025', null],
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
            ['https://ollrich.bandcamp.com/', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Mentions',
        'mentions' => [
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Marriage for All" campaign'],
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO at The Next Web Conference'],
            ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
            ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
        ],
    ],
    'da' => [
        'htmlLang' => 'da',
        'title' => 'Om Oliver Eichhof – Kommunikationsspecialist fra Hamborg',
        'description' => 'Digital brand- og kommunikationsstrateg fra Hamborg. Marketingchef hos REGIOCAST. Over 15 års erfaring inden for kampagneledelse, employer branding og B2B-kommunikation.',
        'ogDescription' => 'Digital brand- og kommunikationsstrateg fra Hamborg. Marketingchef hos REGIOCAST.',
        'ogUrl' => 'https://eichhof.me/dk/om',
        'locale' => 'da_DK',
        'canonical' => 'https://eichhof.me/dk/om',
        'redirect' => '/dk/?overlay=om',
        'homeUrl' => 'https://eichhof.me/dk/',
        'jobTitle' => 'Marketingchef',
        'personDescription' => 'Digital brand- og kommunikationsstrateg fra Hamborg med over 15 års erfaring inden for integreret kampagneledelse, employer branding og B2B-kommunikation.',
        'inLanguage' => 'da',
        'birthPlace' => 'Bremerhaven, Tyskland',
        'nationality' => 'Tyskland',
        'homeLocation' => 'Hamborg, Tyskland',
        'occupationName' => 'Marketingchef',
        'occupationLocation' => 'Hamborg, Tyskland',
        'knowsAbout' => '["Marketing", "Brandudvikling", "Målgruppeanalyse", "Kampagneplanlægning", "Kommunikationsstrategi", "Content-strategi", "Digital kommunikation", "Employer branding", "B2B-kommunikation", "Journey design", "KPI-frameworks", "GEO/SEO/SEA", "Marketing automation", "AI-drevne workflows", "Radio", "Audio", "Streaming media", "Musik", "Musikmedier", "Blogging"]',
        'h1' => 'Om Oliver Eichhof',
        'summary' => 'Digital brand- og kommunikationsstrateg fra Hamborg med over 15 års erfaring inden for integreret kampagneledelse, employer branding og B2B-kommunikation.',
        'factsTitle' => 'Nøglefakta',
        'dtRole' => 'Arbejdsgiver', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
        'dtLocation' => 'Placering', 'ddLocation' => 'Hamborg, Tyskland',
        'dtBorn' => 'Født', 'ddBorn' => '1979 i Bremerhaven, Tyskland',
        'dtLanguages' => 'Sprog', 'ddLanguages' => 'Tysk (modersmål), Engelsk (flydende), Dansk (begynder)',
        'careerTitle' => 'Karriere',
        'career' => [
            ['Marketingchef', 'REGIOCAST GmbH & Co. KG', 'siden 2026', null],
            ['Strategy Director Marketing', 'wirDesign communication AG', '2023–2025', null],
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
            ['https://ollrich.bandcamp.com/', 'Bandcamp'],
            ['https://unsplash.com/@ollrich', 'Unsplash'],
        ],
        'mentionsTitle' => 'Omtaler',
        'mentions' => [
            ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Ægteskab for alle"-kampagne'],
            ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO på The Next Web Conference'],
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
    <meta property="og:url" content="<?= $m['ogUrl'] ?>">
    <meta property="og:type" content="profile">
    <meta property="og:locale" content="<?= $m['locale'] ?>">

    <link rel="canonical" href="<?= $m['canonical'] ?>">
    <link rel="alternate" hreflang="de" href="https://eichhof.me/ueber">
    <link rel="alternate" hreflang="en" href="https://eichhof.me/en/about">
    <link rel="alternate" hreflang="da" href="https://eichhof.me/dk/om">
    <link rel="alternate" hreflang="x-default" href="https://eichhof.me/ueber">

    <link rel="icon" href="/favicon.ico" sizes="16x16 32x32 48x48">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/favicon180.png">
    <link rel="stylesheet" href="/css/styles.css">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Person",
        "@id": "https://eichhof.me/#person",
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
            "https://ollrich.bandcamp.com/",
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

    <meta http-equiv="refresh" content="0;url=<?= $e($m['redirect']) ?>">
</head>
<body>
    <main>
        <article>
            <h1><?= $e($m['h1']) ?></h1>
            <p><?= $e($m['summary']) ?></p>

            <h2><?= $e($m['factsTitle']) ?></h2>
            <dl>
                <dt><?= $e($m['dtRole']) ?></dt><dd><?= $e($m['ddRole']) ?></dd>
                <dt><?= $e($m['dtLocation']) ?></dt><dd><?= $e($m['ddLocation']) ?></dd>
                <dt><?= $e($m['dtBorn']) ?></dt><dd><?= $e($m['ddBorn']) ?></dd>
                <dt><?= $e($m['dtLanguages']) ?></dt><dd><?= $e($m['ddLanguages']) ?></dd>
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
                <li><a href="<?= $mention[0] ?>"><?= $e($mention[1]) ?></a> — <?= $e($mention[2]) ?></li>
<?php endforeach; ?>
            </ul>

        </article>
    </main>
    <footer>
        <p><a href="<?= $m['homeUrl'] ?>">eichhof.me</a></p>
    </footer>
</body>
</html>
