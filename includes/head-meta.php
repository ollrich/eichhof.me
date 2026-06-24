<?php
/**
 * SEO-, Social- und Structured-Data-Block für den <head> der Hauptseite.
 * =====================================================================
 * Bündelt alles, was die Auffindbarkeit betrifft, an einer Stelle:
 * Meta-Description/Robots, Open Graph, Twitter Cards, Canonical + hreflang,
 * rel=me und das JSON-LD-@graph (WebSite/WebPage/Person).
 *
 * Erwartet aus dem Parent-Scope (index.php):
 *   $m       — Meta-/Content-Array für die aktuelle Sprache
 *   $e       — htmlspecialchars-Closure
 *   $overlay — aktiver Overlay-Parameter (für noindex auf Overlay-URLs) oder null
 *   $person  — geteilte Person-Schema-Daten (sameAs, subjectOf, dateModified)
 *
 * Bewusst NICHT geteilt mit about/index.php: die Grounding Page hat ein
 * eigenes JSON-LD (hasOccupation/alumniOf …) und eigene hreflang-Ziele.
 */
?>
    <!-- SEO meta tags for search engines -->
    <meta name="description" content="<?= $e($m['description']) ?>">
    <?php // Overlay-URLs (/de/kontakt, /de/impressum, /de/datenverarbeitung etc.) rendern
          // dieselbe Home-HTML wie /de/ nur mit data-overlay-Attribut. Canonical
          // zeigt bereits auf /de/, zusätzlich noindex verhindert, dass Google
          // sie als Thin-Duplicates behandelt. follow bleibt, damit Link-Juice
          // durch die Footer-Nav fließt. ?>
    <meta name="robots" content="<?= $overlay !== null ? 'noindex, follow' : 'index, follow' ?>">
    <meta name="author" content="Oliver Eichhof">

    <!-- Open Graph meta tags for rich social media sharing (Facebook, LinkedIn) -->
    <meta property="og:title" content="<?= $e($m['title']) ?>">
    <meta property="og:description" content="<?= $e($m['description']) ?>">
    <meta property="og:image" content="https://eichhof.me/images/og-image.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:url" content="<?= $m['url'] ?>">
    <meta property="og:type" content="profile">
    <meta property="og:site_name" content="Oliver Eichhof">
    <meta property="og:locale" content="<?= $m['locale'] ?>">
    <meta property="og:locale:alternate" content="de_DE">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:locale:alternate" content="da_DK">

    <!-- Twitter Card meta tags for rich Twitter sharing -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $e($m['title']) ?>">
    <meta name="twitter:description" content="<?= $e($m['description']) ?>">
    <meta name="twitter:image" content="https://eichhof.me/images/og-image.png">

    <!-- Canonical URL and hreflang for international SEO -->
    <link rel="canonical" href="<?= $m['url'] ?>">
    <link rel="alternate" hreflang="de" href="https://eichhof.me/de/">
    <link rel="alternate" hreflang="en" href="https://eichhof.me/en/">
    <link rel="alternate" hreflang="da" href="https://eichhof.me/da/">
    <link rel="alternate" hreflang="x-default" href="https://eichhof.me/de/">

    <!-- Identity verification (IndieAuth / rel=me) -->
    <link rel="me" href="https://sifa.id/p/ollri.ch">
    <link rel="me" href="https://pixelfed.de/olli">

    <title><?= $e($m['title']) ?></title>

    <!-- JSON-LD structured data for rich search results (Google Knowledge Panel) -->
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
                "@id": "<?= $m['url'] ?>#webpage",
                "url": "<?= $m['url'] ?>",
                "name": "<?= $e($m['title']) ?>",
                "description": "<?= $e($m['description']) ?>",
                "inLanguage": "<?= $m['lang'] ?>",
                "isPartOf": { "@id": "https://eichhof.me/#website" },
                "about": { "@id": "https://eichhof.me/#person" },
                "primaryImageOfPage": "https://eichhof.me/images/oliver-eichhof.webp",
                "datePublished": "2026-01-22",
                "dateModified": "<?= $person['dateModified'] ?>"
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
                "description": "<?= $e($m['description']) ?>",
                "knowsAbout": <?= json_encode($m['knowsAbout'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
                "homeLocation": { "@type": "Place", "name": "Hamburg" },
                "birthPlace": { "@type": "Place", "name": "Bremerhaven" },
                "worksFor": {
                    "@type": "Organization",
                    "name": "REGIOCAST GmbH & Co. KG",
                    "url": "https://www.regiocast.de/",
                    "sameAs": [
                        "https://de.wikipedia.org/wiki/Regiocast",
                        "https://www.linkedin.com/company/regiocast/"
                    ]
                },
                "sameAs": <?= json_encode($person['sameAs'], JSON_UNESCAPED_SLASHES) ?>,
                "subjectOf": <?= json_encode($person['subjectOf'], JSON_UNESCAPED_SLASHES) ?>,
                "mainEntityOfPage": { "@id": "<?= $m['url'] ?>#webpage" }
            }
        ]
    }
    </script>
