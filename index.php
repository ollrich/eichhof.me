<?php
/**
 * eichhof.me - Multilingual Entry Point
 * =====================================
 * Handles language detection and serves all content server-side for SEO/Social
 * while keeping client-side language switching for UI elements via language.js.
 *
 * URL Structure:
 * - /              → Pure router: 302 to /de/|/en/|/da/ per Accept-Language
 *                     (Bots: 301 to /de/ — konsistente Kanonical, kein Cloaking)
 * - /de/           → German
 * - /en/           → English
 * - /da/           → Danish
 * - /de/impressum         → German legal notice
 * - /en/legal-notice      → English legal notice
 * - /da/kolofon           → Danish legal notice
 * - /de/kontakt           → German contact
 * - /en/contact           → English contact
 * - /da/kontakt           → Danish contact
 * - /de/ueber             → German about (grounding page)
 * - /en/about             → English about (grounding page)
 * - /da/om                → Danish about (grounding page)
 *
 * Legacy 301 in .htaccess:
 *   /dk/*              → /da/*               (ISO 639-1 statt Country-Code)
 *   /ueber             → /de/ueber           (symmetrisches Language-Prefix)
 *   /impressum         → /de/impressum       (symmetrisches Language-Prefix)
 *   /datenverarbeitung → /de/datenverarbeitung
 *   /kontakt           → /de/kontakt
 */

// ============================================================================
// BARE-ROOT ROUTER — reine Weiterleitung, nie selbst Content ausliefern
// ============================================================================
//
// Philosophie: "/" ist keine Sprache mehr, sondern ein sprach-agnostischer
// Einstiegspunkt. Jede der drei Sprachen hat ihre eigene Kanonische URL
// (/de/, /en/, /da/). Das löst den Redirect-Loop, den der alte ?lang=de-
// Override brauchte, und liefert gleichzeitig sauberes SEO: keine Seite
// existiert unter zwei URLs.
//
//  Bots   — 301 auf /de/ (permanent, damit Link-Equity konsolidiert
//           wird; DE ist die Default-Sprache, und hreflang x-default
//           zeigt direkt auf /de/ — ohne Umweg über die kurze /).
//  Humans — 302 auf /de/|/en/|/da/ je nach Accept-Language.
//           302, damit Browser/CDNs die Antwort nicht cachen und der
//           Nutzer beim nächsten Besuch nicht an eine Sprache klebt,
//           die nur einmal präferiert war.
//  Vary: Accept-Language — Shared Caches müssen pro Browser-Sprache
//                          separat speichern.

$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsedPath = parse_url($requestUri, PHP_URL_PATH) ?: '/';
$isBareRoot = ($parsedPath === '/' || $parsedPath === '/index.php');

if ($isBareRoot) {
    header('Vary: Accept-Language', false);

    $ua    = $_SERVER['HTTP_USER_AGENT'] ?? '';
    // Bots + Audit-Tools (PSI, Lighthouse, GTmetrix, WebPageTest, Headless)
    // bekommen den deterministischen 301 auf /de/ – sonst würde PSI mit
    // Accept-Language: en-US reports immer gegen /en/ erstellen.
    $isBot = (bool) preg_match(
        '~bot|crawler|spider|crawling|facebookexternalhit|slackbot|twitterbot|whatsapp|telegrambot|linkedinbot|discordbot|applebot|chrome-lighthouse|pagespeed|gtmetrix|ptst|webpagetest|headlesschrome~i',
        $ua
    );

    if ($isBot) {
        // Konsistente Kanonical für Bots + Audit-Tools: / → /de/ (permanent).
        header('Location: https://eichhof.me/de/', true, 301);
        exit;
    }

    // Humans: Accept-Language-basierter 302.
    $acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $primary    = strtolower(substr(trim(explode(',', $acceptLang)[0] ?? ''), 0, 2));
    if ($primary === 'en') {
        header('Location: /en/', true, 302);
        exit;
    }
    if ($primary === 'da') {
        header('Location: /da/', true, 302);
        exit;
    }
    // Default (DE oder andere/leer): /de/.
    header('Location: /de/', true, 302);
    exit;
}

// Finale Sprachbestimmung: $_GET['lang'] kommt aus .htaccess-Rewrite
// (/de/, /en/, /da/, /de/ueber, /en/about, /de/kontakt etc.) — vertrauenswürdig.
$lang = $_GET['lang'] ?? 'de';
if (!in_array($lang, ['de', 'en', 'da'], true)) {
    $lang = 'de';
}
$overlay = $_GET['overlay'] ?? null;

// ============================================================================
// TEMPLATE HELPERS
// ============================================================================

// HTML-Escape für Attribute / Textinhalte.
$e = function($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); };

// Explicit identity marker for $m-Werte, die bewusst vertrauenswürdigen
// Inline-HTML enthalten (<br>, <span class="sr-only">, <a>). $rawHtml() an
// der Callsite dokumentiert den Intent, damit künftige Reviewer ein
// fehlendes $e() nicht als Oversight missverstehen.
$rawHtml = function($s) { return $s; };

// ============================================================================
// CONTENT LOADING
// ============================================================================
// $m      = gemeinsame Strings (common) + hauptseitenspezifische (home) für $lang.
// $routes = Sprachrouten-Map für den Sprachwähler / Hreflang-Varianten.

$i18nAll = require __DIR__ . '/includes/config/i18n.php';
$routes  = $i18nAll['common']['routes'];
$m       = array_merge($i18nAll['common'][$lang], $i18nAll['home'][$lang]);

// Aliased / derived fields, damit Templates ohne Umschreiben weiterlaufen.
$m['lang']       = $lang;                        // 2-Zeichen-Code (Template: <html lang="…">)
$m['baseUrl']    = $routes[$lang]['home'];
$m['legalUrl']   = $routes[$lang]['legal'];
$m['privacyUrl'] = $routes[$lang]['privacy'];
$m['contactUrl'] = $routes[$lang]['contact'];
$m['aboutUrl']   = $routes[$lang]['about'];

// Shared Person-Schema-Daten (sameAs, subjectOf) — identisch zwischen Haupt- und About-Seite.
$person = require __DIR__ . '/includes/config/person.php';

// Asset-Helper für automatische Cache-Busting-Versionierung via filemtime().
require_once __DIR__ . '/includes/asset.php';

// Normalisierter Route-Key (für Sprachwähler + data-overlay).
$routeKey = 'home';
if ($overlay === 'impressum' || $overlay === 'legal' || $overlay === 'kolofon') {
    $routeKey = 'legal';
} elseif ($overlay === 'privacy') {
    $routeKey = 'privacy';
} elseif ($overlay === 'contact' || $overlay === 'kontakt') {
    $routeKey = 'contact';
}

// data-overlay-Wert: normalisiert auf impressum/privacy/contact, damit
// language.js / overlay.js keine Sprachvarianten kennen müssen.
$openOverlay = null;
if ($routeKey === 'legal')   $openOverlay = 'impressum';
if ($routeKey === 'privacy') $openOverlay = 'privacy';
if ($routeKey === 'contact') $openOverlay = 'contact';
?>
<!DOCTYPE html>
<html lang="<?= $m['lang'] ?>">
<head>
    <!-- Character encoding and viewport configuration for responsive design -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include __DIR__ . '/includes/theme-init.php'; ?>

    <!-- Theme color for browser UI (address bar on mobile) -->
    <meta name="theme-color" content="#764ba2" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0d0d14" media="(prefers-color-scheme: dark)">

<?php // SEO, Social & Structured Data — auf Spalte 0, damit die 4-Space-
      // Einrückung des Partials 1:1 erhalten bleibt (sonst doppelte Spaces). ?>
<?php include __DIR__ . '/includes/head-meta.php'; ?>

    <!-- Favicon configuration for various devices and contexts -->
    <?php include __DIR__ . '/includes/head-favicons.php'; ?>

    <!-- Preload Hero-AVIF (LCP). `type="image/avif"` sorgt dafür, dass
         Browser ohne AVIF-Support den Preload ignorieren und stattdessen
         über den <picture>-Fallback die WebP-Variante laden. -->
    <link rel="preload" as="image"
          type="image/avif"
          imagesrcset="/images/oliver-eichhof-320.avif 320w, /images/oliver-eichhof-640.avif 640w, /images/oliver-eichhof.avif 920w"
          imagesizes="(max-width: 768px) 140px, 160px"
          fetchpriority="high">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="<?= asset('/css/styles.css') ?>">

    <!-- i18n-Daten für JS (Single Source mit PHP geteilt).
         `type="application/json"` ist kein ausführbares Script — keine CSP-Hash
         nötig. `JSON_HEX_TAG | JSON_HEX_AMP` verhindert, dass eingebettetes
         HTML (z. B. `</script>` im Tagline-Text, falls jemals möglich) den
         Parser ausbrechen lässt. -->
    <script id="i18n-data" type="application/json"><?= json_encode($m, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?></script>
</head>
<body data-lang="<?= $lang ?>"<?= $openOverlay ? ' data-overlay="' . $openOverlay . '"' : '' ?>>
    <a href="#main" class="skip-link"><?= $e($m['skipLink']) ?></a>
    <main id="main">
    <!-- Theme-Toggle (oben rechts) und Sprachwähler (direkt darunter).
         Reihenfolge im DOM = visuelle Reihenfolge = Tab-Reihenfolge. -->
    <?php include __DIR__ . '/includes/theme-toggle.php'; ?>
    <?php include __DIR__ . '/includes/lang-switcher.php'; ?>

    <!-- Main Content Container -->
    <div class="container">
        <!-- Profile photo with Easter egg animation (double-click or spacebar).
             fetchpriority=high / decoding=async — LCP-Hero, daher bewusst
             kein loading=lazy. <picture> liefert AVIF wo möglich, sonst
             WebP als Fallback. srcset liefert auf Mobile ~2 KB statt 40 KB. -->
        <picture>
            <source type="image/avif"
                    srcset="/images/oliver-eichhof-320.avif 320w, /images/oliver-eichhof-640.avif 640w, /images/oliver-eichhof.avif 920w"
                    sizes="(max-width: 768px) 140px, 160px">
            <source type="image/webp"
                    srcset="/images/oliver-eichhof-320.webp 320w, /images/oliver-eichhof-640.webp 640w, /images/oliver-eichhof.webp 920w"
                    sizes="(max-width: 768px) 140px, 160px">
            <img src="/images/oliver-eichhof.webp"
                 width="160" height="160"
                 decoding="async"
                 fetchpriority="high"
                 alt="<?= $e($m['photoAlt']) ?>"
                 class="profile-photo">
        </picture>

        <h1 class="name">Oliver Eichhof</h1>

        <!-- Visually-hidden H2 as topical SEO heading (Role + Location).
             Breaks the H1 → P gap without affecting the minimalist visual
             layout. Screen-readers pick it up as secondary heading. -->
        <h2 class="sr-only"><?= $e($m['subtitle']) ?></h2>

        <!-- Tagline with inline links -->
        <p class="tagline" id="tagline"><?= $m['tagline'] ?></p>

        <!-- Profil-Umschalter: default (links) = Standard-Profile,
             aktiviert (rechts) = europäische Alternativen. Wechselt rein
             visuell die sichtbaren Buttons (html.eu-mode), beide Sets sind
             im DOM. Pre-paint in theme-init.php gesetzt = kein Flash. -->
        <div class="profile-toggle">
            <button type="button" class="profile-toggle-btn" id="profile-toggle" role="switch" aria-checked="false" aria-label="<?= $e($m['euToggleLabel']) ?>">
                <span class="profile-toggle-knob"></span>
            </button>
            <span class="profile-tooltip" id="profile-tooltip">
                <span class="profile-tooltip-off" id="profile-tooltip-off"><?= $e($m['euTooltipOff']) ?></span>
                <span class="profile-tooltip-on" id="profile-tooltip-on"><?= $e($m['euTooltipOn']) ?></span>
            </span>
        </div>

        <!-- Social media and contact links. Pro Slot ein Standard- und ein
             EU-Button (profile-default / profile-eu), Sichtbarkeit via
             html.eu-mode. -->
        <nav class="links" aria-label="Social Links">
            <!-- Slot 1: LinkedIn ↔ XING -->
            <a href="<?= $m['linkedinUrl'] ?>" target="_blank" rel="noopener noreferrer me" class="link-card linkedin profile-default">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
                <div class="link-text">LinkedIn</div>
            </a>
            <a href="<?= $m['xingUrl'] ?>" target="_blank" rel="noopener noreferrer me" class="link-card xing profile-eu">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.188 0c-.517 0-.741.325-.927.66 0 0-7.455 13.224-7.702 13.657.015.024 4.919 9.023 4.919 9.023.17.308.436.66.967.66h3.454c.211 0 .375-.078.463-.22.089-.151.089-.346-.009-.536l-4.879-8.916c-.004-.006-.004-.016 0-.022L22.139.756c.095-.191.097-.387.006-.535C22.056.078 21.894 0 21.686 0h-3.498zM3.648 4.74c-.211 0-.385.074-.473.216-.09.149-.078.339.02.531l2.34 4.05c.004.01.004.016 0 .021L1.86 16.051c-.099.188-.093.381 0 .529.085.142.239.234.45.234h3.461c.518 0 .766-.348.945-.667l3.734-6.609-2.378-4.155c-.172-.315-.434-.659-.962-.659H3.648v.016z"/>
                </svg>
                <div class="link-text">XING</div>
            </a>

            <!-- Slot 2: Instagram ↔ Pixelfed -->
            <a href="https://www.instagram.com/ollri.ch/" target="_blank" rel="noopener noreferrer me" class="link-card instagram profile-default">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                </svg>
                <div class="link-text">Instagram</div>
            </a>
            <a href="https://pixelfed.de/olli" target="_blank" rel="noopener noreferrer me" class="link-card pixelfed profile-eu">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm-1.624 7.604h3.49c2.198 0 3.977 1.779 3.977 3.977s-1.779 3.953-3.977 3.953h-1.85v2.862H8.375V9.557c0-1.078.875-1.953 2-1.953z"/>
                </svg>
                <div class="link-text">Pixelfed</div>
            </a>

            <!-- Slot 3: Bluesky ↔ Mastodon -->
            <a href="https://bsky.app/profile/ollri.ch" target="_blank" rel="noopener noreferrer me" class="link-card bluesky profile-default">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 10.8c-1.087-2.114-4.046-6.053-6.798-7.995C2.566.944 1.561 1.266.902 1.565.139 1.908 0 3.08 0 3.768c0 .69.378 5.65.624 6.479.815 2.736 3.713 3.66 6.383 3.364.136-.02.275-.039.415-.056-.138.022-.276.04-.415.056-3.912.58-7.387 2.005-2.83 7.078 5.013 5.19 6.87-1.113 7.823-4.308.953 3.195 2.05 9.271 7.733 4.308 4.267-4.308 1.172-6.498-2.74-7.078a8.741 8.741 0 0 1-.415-.056c.14.017.279.036.415.056 2.67.297 5.568-.628 6.383-3.364.246-.828.624-5.79.624-6.478 0-.69-.139-1.861-.902-2.206-.659-.298-1.664-.62-4.3 1.24C16.046 4.748 13.087 8.687 12 10.8Z"/>
                </svg>
                <div class="link-text">Bluesky</div>
            </a>
            <a href="https://norden.social/@olli" target="_blank" rel="noopener noreferrer me" class="link-card mastodon profile-eu">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M23.268 5.313c-.35-2.578-2.617-4.61-5.304-5.004C17.51.242 15.792 0 11.813 0h-.03c-3.98 0-4.835.242-5.288.309C3.882.692 1.496 2.518.917 5.127.64 6.412.61 7.837.661 9.143c.074 1.874.088 3.745.26 5.611.118 1.24.325 2.47.62 3.68.55 2.237 2.777 4.098 4.96 4.857 2.336.792 4.849.923 7.256.38.265-.061.527-.132.786-.213.585-.184 1.27-.39 1.774-.753a.057.057 0 0 0 .023-.043v-1.809a.052.052 0 0 0-.02-.041.053.053 0 0 0-.046-.01 20.282 20.282 0 0 1-4.709.545c-2.73 0-3.463-1.284-3.674-1.818a5.593 5.593 0 0 1-.319-1.433.053.053 0 0 1 .066-.054c1.517.363 3.072.546 4.632.546.376 0 .75 0 1.125-.01 1.57-.044 3.224-.124 4.768-.422.038-.008.077-.015.11-.024 2.435-.464 4.753-1.92 4.989-5.604.008-.145.03-1.52.03-1.67.002-.512.167-3.63-.024-5.545zm-3.748 9.195h-2.561V8.29c0-1.309-.55-1.976-1.67-1.976-1.23 0-1.846.79-1.846 2.35v3.403h-2.546V8.663c0-1.56-.617-2.35-1.848-2.35-1.112 0-1.668.668-1.67 1.977v6.218H4.822V8.102c0-1.31.337-2.35 1.011-3.12.696-.77 1.608-1.164 2.74-1.164 1.311 0 2.302.5 2.962 1.498l.638 1.06.638-1.06c.66-.999 1.65-1.498 2.96-1.498 1.13 0 2.043.395 2.74 1.164.675.77 1.012 1.81 1.012 3.12z"/>
                </svg>
                <div class="link-text">Mastodon</div>
            </a>

            <!-- Email link - opens contact form, href serves as fallback -->
            <a href="<?= $m['contactUrl'] ?>" id="email-link" class="link-card email" aria-label="<?= $e($m['emailAriaLabel']) ?>">
                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
                <div class="link-text" id="email-text"><?= $e($m['emailText']) ?></div>
            </a>
        </nav>

        <!-- Mobile-only footer -->
        <div class="mobile-footer">
            <a href="<?= $m['legalUrl'] ?>" id="footer-link-mobile"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> • </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link-mobile"><?= $e($m['privacyLink']) ?></a>
            <span class="sr-only" id="footer-entity-mobile"><?= $e($m['footerEntity']) ?></span>
            <span id="footer-text-mobile"><?= $rawHtml($m['footerMobile']) ?></span>
        </div>
    </div>
</main>

    <!-- Footer Elements -->
    <div class="footer-left">
        <a href="<?= $m['legalUrl'] ?>" id="footer-link"><?= $e($m['legalLink']) ?></a><span class="footer-separator" aria-hidden="true"> • </span><a href="<?= $m['privacyUrl'] ?>" id="footer-privacy-link"><?= $e($m['privacyLink']) ?></a>
    </div>

    <!-- Hidden entity info for crawlers -->
    <span class="sr-only" id="footer-entity-desktop"><?= $e($m['footerEntity']) ?></span>

    <div class="footer">
        <span id="footer-text-desktop"><?= $rawHtml($m['footerDesktop']) ?></span>
        <span class="github-link-wrapper">•
            <span class="github-tooltip" id="github-tooltip"><?= $e($m['githubTooltip']) ?></span>
            <a href="https://github.com/ollrich/eichhof.me" target="_blank" rel="noopener noreferrer" class="footer-link">
                <svg class="icon-github" viewBox="0 0 16 16" fill="currentColor" aria-label="<?= $e($m['githubAriaLabel']) ?>">
                    <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"/>
                </svg>
            </a>
        </span>
    </div>

    <!-- Hint text for Easter egg discovery -->
    <div class="footer-hint" id="footer-hint"><?= $e($m['hint']) ?></div>

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
            <?php include __DIR__ . '/includes/overlays/privacy-' . $lang . '.php'; ?>
        </div>
    </div>

    <!-- Link Preview Tooltip -->
    <div class="link-preview" id="link-preview">
        <button class="preview-close" id="preview-close" aria-label="<?= $e($m['closePreview']) ?>">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <line x1="2" y1="2" x2="12" y2="12"/><line x1="12" y1="2" x2="2" y2="12"/>
            </svg>
        </button>
    </div>

    <!-- Contact Form Modal -->
    <div class="overlay" id="contact-overlay">
        <div class="overlay-content contact-form-content">
            <button class="close-overlay" id="close-contact-btn" aria-label="<?= $e($m['closeOverlay']) ?>">
                <svg width="16" height="16" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <line x1="2" y1="2" x2="12" y2="12"/><line x1="12" y1="2" x2="2" y2="12"/>
                </svg>
            </button>
            <h2 id="contact-title"><?= $e($m['contactTitle']) ?></h2>

            <form id="contact-form" novalidate>
                <!-- Honeypot field (hidden from users, visible to bots) -->
                <div class="contact-honeypot" aria-hidden="true">
                    <label>Website</label>
                    <input type="text" name="website" id="contact-website" tabindex="-1" autocomplete="off">
                </div>

                <!-- Hidden timestamp for time-based spam check -->
                <input type="hidden" name="_t" id="contact-timestamp">

                <!-- Hidden CSRF token -->
                <input type="hidden" name="csrf_token" id="contact-csrf">

                <div class="contact-field">
                    <label class="sr-only" for="contact-name"><?= $e($m['contactName']) ?></label>
                    <input type="text" id="contact-name" name="name" placeholder="<?= $e($m['contactName']) ?>" required minlength="2" maxlength="100" autocomplete="name">
                </div>

                <div class="contact-field">
                    <label class="sr-only" for="contact-email"><?= $e($m['contactEmail']) ?></label>
                    <input type="email" id="contact-email" name="email" placeholder="<?= $e($m['contactEmail']) ?>" required autocomplete="email">
                </div>

                <div class="contact-field">
                    <label class="sr-only" for="contact-message"><?= $e($m['contactMessage']) ?></label>
                    <textarea id="contact-message" name="message" placeholder="<?= $e($m['contactMessage']) ?>" required minlength="10" maxlength="5000" rows="5"></textarea>
                </div>

                <p class="contact-privacy" id="contact-privacy"><?= $e($m['contactPrivacy']) ?></p>

                <button type="submit" class="contact-submit" id="contact-submit">
                    <span id="contact-submit-text"><?= $e($m['contactSubmit']) ?></span>
                    <span class="contact-spinner" id="contact-spinner"></span>
                </button>

                <div class="contact-feedback" id="contact-feedback" role="alert" aria-live="polite"></div>
            </form>

            <div class="contact-fallback">
                <span id="contact-fallback-text"><?= $e($m['contactFallback']) ?></span>
                <a href="#" id="contact-fallback-link"></a>
            </div>
        </div>
    </div>

    <!-- JavaScript Modules -->
    <script src="<?= asset('/js/theme.js') ?>" defer></script>
    <script src="<?= asset('/js/eu-mode.js') ?>" defer></script>
    <script src="<?= asset('/js/lang-switcher.js') ?>" defer></script>
    <script src="<?= asset('/js/language.js') ?>" defer></script>
    <script src="<?= asset('/js/overlay.js') ?>" defer></script>
    <script src="<?= asset('/js/contact.js') ?>" defer></script>
    <script src="<?= asset('/js/easter-egg.js') ?>" defer></script>
    <script src="<?= asset('/js/link-preview.js') ?>" defer></script>
</body>
</html>
