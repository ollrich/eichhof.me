<?php
/**
 * About / Grounding Page — Multilingual Standalone
 * =================================================
 * Standalone visual page with full Person JSON-LD.
 * Serves all visitors (crawlers and browsers) with HTTP 200.
 * Styled to match the main site's visual appearance.
 *
 * URLs:
 * - /de/ueber   → German (legacy /ueber → 301 in .htaccess)
 * - /en/about   → English
 * - /da/om      → Danish (legacy /dk/om → 301 in .htaccess)
 */

$lang = $_GET['lang'] ?? 'de';
if (!in_array($lang, ['de', 'en', 'da'], true)) {
    $lang = 'de';
}

// ============================================================================
// TEMPLATE HELPERS
// ============================================================================

$e = fn($s) => htmlspecialchars($s, ENT_QUOTES, 'UTF-8');

// Explicit identity marker für $m-Werte, die bewusst vertrauenswürdigen
// Inline-HTML enthalten (<br>, <span class="sr-only">, <a>).
$rawHtml = fn($s) => $s;

// ============================================================================
// CONTENT LOADING
// ============================================================================
// $m       = gemeinsame Strings (common) + groundingpage-spezifische (about) für $lang.
// $routes  = Sprachrouten-Map für den Sprachwähler / hreflang.

$i18nAll = require __DIR__ . '/../includes/config/i18n.php';
$routes  = $i18nAll['common']['routes'];
$m       = array_merge($i18nAll['common'][$lang], $i18nAll['about'][$lang]);

// Aliased / derived fields, damit das Template ohne Umschreiben weiterläuft.
$m['lang']          = $lang;               // 2-Zeichen-Code (<html lang="…">)
$m['inLanguage']    = $lang;               // JSON-LD-Property
$m['canonical']     = $m['url'];           // about-spezifisch: Canonical = url
$m['ogUrl']         = $m['url'];
$m['homeUrl']       = 'https://eichhof.me' . $routes[$lang]['home'];
$m['legalUrl']      = $routes[$lang]['legal'];
$m['privacyUrl']    = $routes[$lang]['privacy'];

// Shared Person-Schema-Daten (sameAs, subjectOf) — identisch zwischen Haupt- und About-Seite.
$person = require __DIR__ . '/../includes/config/person.php';

// Asset-Helper für automatische Cache-Busting-Versionierung via filemtime().
require_once __DIR__ . '/../includes/asset.php';

// Route-Key für den Sprachwähler.
$routeKey = 'about';

// Created-Datum dieser Seite (datePublished). Einmalige Quelle für JSON-LD
// UND die sichtbare Timestamp-Zeile, damit beide nicht auseinanderlaufen.
// Updated/Verified kommen aus $person['dateModified'] (Action-gebumpt) bzw.
// $m['tsVerifiedValue'] (manuell gepflegt).
$datePublished = '2026-02-19';
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
    <meta property="og:image:height" content="630">
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
    <link rel="alternate" hreflang="de" href="https://eichhof.me/de/ueber">
    <link rel="alternate" hreflang="en" href="https://eichhof.me/en/about">
    <link rel="alternate" hreflang="da" href="https://eichhof.me/da/om">
    <link rel="alternate" hreflang="x-default" href="https://eichhof.me/de/ueber">

    <!-- Identity verification (IndieAuth / rel=me) -->
    <link rel="me" href="https://sifa.id/p/ollri.ch">
    <link rel="me" href="https://pixelfed.de/olli">

    <?php include __DIR__ . '/../includes/head-favicons.php'; ?>

    <!-- Preload Hero-AVIF (LCP). Ohne AVIF-Support ignoriert der Browser den
         Hint; der <picture>-Fallback liefert dann WebP. -->
    <link rel="preload" as="image"
          type="image/avif"
          imagesrcset="/images/oliver-eichhof-320.avif 320w, /images/oliver-eichhof-640.avif 640w, /images/oliver-eichhof.avif 920w"
          imagesizes="120px"
          fetchpriority="high">

    <link rel="stylesheet" href="<?= asset('/css/styles.css') ?>">

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "WebSite",
                "@id": "https://eichhof.me/#website",
                "url": "https://eichhof.me/",
                "name": "Oliver Eichhof",
                "inLanguage": ["de", "en", "da"],
                "publisher": { "@id": "https://eichhof.me/#person" }
            },
            {
                "@type": "WebPage",
                "@id": "<?= $m['canonical'] ?>#webpage",
                "url": "<?= $m['canonical'] ?>",
                "name": "<?= $e($m['title']) ?>",
                "description": "<?= $e($m['description']) ?>",
                "inLanguage": "<?= $m['inLanguage'] ?>",
                "isPartOf": { "@id": "https://eichhof.me/#website" },
                "about": { "@id": "https://eichhof.me/#person" },
                "breadcrumb": { "@id": "<?= $m['canonical'] ?>#breadcrumbs" },
                "primaryImageOfPage": "https://eichhof.me/images/oliver-eichhof.webp",
                "datePublished": "<?= $datePublished ?>",
                "dateModified": "<?= $person['dateModified'] ?>"
            },
            {
                "@type": "BreadcrumbList",
                "@id": "<?= $m['canonical'] ?>#breadcrumbs",
                "itemListElement": [
                    {
                        "@type": "ListItem",
                        "position": 1,
                        "name": "Oliver Eichhof",
                        "item": "<?= $m['homeUrl'] ?>"
                    },
                    {
                        "@type": "ListItem",
                        "position": 2,
                        "name": "<?= $e($m['breadcrumbLabel']) ?>",
                        "item": "<?= $m['canonical'] ?>"
                    }
                ]
            },
            {
                "@type": "Person",
                "@id": "https://eichhof.me/#person",
                "name": "Oliver Eichhof",
                "givenName": "Oliver",
                "familyName": "Eichhof",
                "url": "https://eichhof.me/",
                "image": "https://eichhof.me/images/oliver-eichhof.webp",
                "jobTitle": "<?= $e($m['jobTitle']) ?>",
                "description": "<?= $e($m['personDescription']) ?>",
                "birthPlace": { "@type": "Place", "name": "<?= $e($m['birthPlace']) ?>" },
                "birthDate": "1979",
                "homeLocation": { "@type": "Place", "name": "<?= $e($m['homeLocation']) ?>" },
                "nationality": { "@type": "Country", "name": "<?= $e($m['nationality']) ?>" },
                "knowsLanguage": ["de", "en", "da"],
                "knowsAbout": <?= json_encode($m['knowsAbout'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
                "worksFor": {
                    "@type": "Organization",
                    "name": "REGIOCAST GmbH & Co. KG",
                    "url": "https://www.regiocast.de/",
                    "sameAs": [
                        "https://de.wikipedia.org/wiki/Regiocast",
                        "https://www.linkedin.com/company/regiocast/"
                    ]
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
                        "occupationLocation": { "@type": "Place", "name": "<?= $e($m['occupationLocation']) ?>" },
                        "startDate": "2026"
                    }
                ],
                "sameAs": <?= json_encode($person['sameAs'], JSON_UNESCAPED_SLASHES) ?>,
                "subjectOf": <?= json_encode($person['subjectOf'], JSON_UNESCAPED_SLASHES) ?>,
                "mainEntityOfPage": { "@id": "<?= $m['canonical'] ?>#webpage" }
            }
        ]
    }
    </script>
</head>
<body class="about-page">
    <a href="#main" class="skip-link"><?= $e($m['skipLink']) ?></a>

    <!-- Theme-Toggle (oben rechts) und Sprachwähler (direkt darunter).
         Reihenfolge im DOM = visuelle Reihenfolge = Tab-Reihenfolge.
         Auf der Grounding-Page per .about-page-Regel auf position:absolute
         gestellt, damit sie beim Scrollen mit weglaufen und nicht über den
         Textblöcken hängen bleiben (anders als auf der schmalen Homepage). -->
    <?php include __DIR__ . '/../includes/theme-toggle.php'; ?>
    <?php include __DIR__ . '/../includes/lang-switcher.php'; ?>

    <main id="main" class="grounding-page">
        <a href="<?= $m['homeUrl'] ?>" class="grounding-back">&larr; <?= $e($m['backText']) ?></a>

        <picture>
            <source type="image/avif"
                    srcset="/images/oliver-eichhof-320.avif 320w, /images/oliver-eichhof-640.avif 640w, /images/oliver-eichhof.avif 920w"
                    sizes="120px">
            <source type="image/webp"
                    srcset="/images/oliver-eichhof-320.webp 320w, /images/oliver-eichhof-640.webp 640w, /images/oliver-eichhof.webp 920w"
                    sizes="120px">
            <img src="/images/oliver-eichhof.webp"
                 width="120" height="120"
                 decoding="async"
                 fetchpriority="high"
                 alt="<?= $e($m['photoAlt']) ?>"
                 class="profile-photo">
        </picture>

        <h1 class="name"><?= $e($m['h1']) ?></h1>

        <div class="overlay-content about-content">
            <div class="about-section">
                <p><?= $e($m['summary']) ?></p>
                <p><?= $e($m['segment']) ?></p>
            </div>

            <section class="about-section">
                <h3><?= $e($m['distinctionTitle']) ?></h3>
                <p><?= $e($m['distinction']) ?></p>
            </section>

            <section class="about-section">
                <h3><?= $e($m['factsTitle']) ?></h3>
                <dl class="about-facts">
                    <dt><?= $e($m['dtType']) ?></dt><dd><?= $e($m['ddType']) ?></dd>
                    <dt><?= $e($m['dtSegment']) ?></dt><dd><?= $e($m['ddSegment']) ?></dd>
                    <dt><?= $e($m['dtRole']) ?></dt><dd><?= $e($m['ddRole']) ?></dd>
                    <dt><?= $e($m['dtLocation']) ?></dt><dd><?= $e($m['ddLocation']) ?></dd>
                    <dt><?= $e($m['dtBorn']) ?></dt><dd><?= $e($m['ddBorn']) ?></dd>
                    <dt><?= $e($m['dtNationality']) ?></dt><dd><?= $e($m['ddNationality']) ?></dd>
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

            <p class="about-notice"><?= $e($m['retrieval']) ?></p>

            <p class="about-notice about-timestamps">
                <?= $e($m['tsCreatedLabel']) ?>: <time datetime="<?= $e($datePublished) ?>"><?= $e($datePublished) ?></time> ·
                <?= $e($m['tsUpdatedLabel']) ?>: <time datetime="<?= $e($person['dateModified']) ?>"><?= $e($person['dateModified']) ?></time> ·
                <?= $e($m['tsVerifiedLabel']) ?>: <?= $e($m['tsVerifiedValue']) ?>
            </p>
        </div>
        <!-- Mobile-only footer -->
        <div class="mobile-footer">
            <a href="<?= $m['legalUrl'] ?>" id="footer-link-mobile"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> • </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link-mobile"><?= $e($m['privacyLink']) ?></a>
            <span class="sr-only"><?= $e($m['footerEntity']) ?></span>
            <span><?= $rawHtml($m['footerMobile']) ?></span>
        </div>
    </main>

    <!-- Footer Elements -->
    <div class="footer-left">
        <a href="<?= $m['legalUrl'] ?>" id="footer-link"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> • </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link"><?= $e($m['privacyLink']) ?></a>
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
    <script src="<?= asset('/js/lang-switcher.js') ?>" defer></script>
    <script src="<?= asset('/js/overlay.js') ?>" defer></script>
</body>
</html>
