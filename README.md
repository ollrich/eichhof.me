# eichhof.me

---

<a name="english"></a>
## English

**[Deutsch](#deutsch)** | **[Dansk](#dansk)**

Personal website of Oliver Eichhof – Communication Specialist from Hamburg.

Built with AI assistance as an exploration of modern web development practices. The code is open source for learning and inspiration.

### Highlights

- 🌐 Multilingual (DE/EN/DA) with symmetric clean URLs (/de/, /en/, /da/); bare root `/` is a pure Accept-Language router (302 for humans, 301 → /de/ for bots); top-right disclosure language switcher to the right of the theme toggle (hover/tap reveals the other two languages)
- 🎨 Dark mode with system preference support
- 🇪🇺 Profile toggle: switches the profile links from mainstream platforms (LinkedIn, Instagram, Bluesky) to European alternatives (XING, Pixelfed, Mastodon); choice stored locally, subtle attention pulse until first use
- 🔒 Privacy-first: no cookies, no tracking, no analytics
- 📬 Contact form with spam protection (honeypot, rate limiting, time-based checks)
- 🔍 SEO: schema.org JSON-LD graph (Person/WebSite/WebPage/BreadcrumbList with `@id` cross-references), hreflang with `x-default` → `/de/`, `noindex` on overlay URLs, audit tools (Lighthouse/PSI/GTmetrix) treated as bots for deterministic reports
- 📄 About / Grounding Page – machine-readable identity page for AI systems and search engines (standalone, styled)
- 🎊 Easter eggs (try pressing spacebar or double-clicking the photo)
- ♿ Accessible: keyboard navigation, ARIA labels, reduced motion support

### Tech

Pure HTML/CSS/JavaScript – no frameworks. Server-side rendered (PHP) for all body texts per language. All translations live in a single PHP array (`includes/config/i18n.php`) shared between server templates and browser-side JS via an inline `<script type="application/json">` block – no duplicated translation tables. Uses [Canvas-Confetti](https://github.com/catdad/canvas-confetti) for visual effects and [APIFlash](https://apiflash.com/) for generating link preview screenshots.

### Automation

Pushes to `main` that touch page content automatically update the sitemap's `<lastmod>` and the JSON-LD `dateModified` via GitHub Actions. Docs- or config-only pushes are ignored (path allowlist), so the freshness signal stays honest.

### Structure

```
eichhof.me/
├── index.php               # Main entry (multilingual routing, Accept-Language 302, meta tags)
├── 404.php                 # Custom error page (language from URL prefix) — via ErrorDocument
├── about/
│   └── index.php           # Grounding page (crawlable, styled) — consumes i18n.php
├── includes/
│   ├── config/
│   │   ├── i18n.php        # Single source of truth for all translations (DE/EN/DA + routes)
│   │   └── person.php      # Shared schema.org Person data (sameAs, subjectOf)
│   ├── lang-switcher.php   # Top-right disclosure menu (right of theme toggle, current lang as trigger)
│   ├── theme-toggle.php    # Top-right dark/light toggle (left of lang switcher)
│   ├── overlays/           # Impressum/Privacy/Contact modal partials
│   ├── head-favicons.php   # Favicon <link> block
│   ├── theme-init.php      # Inline no-flash theme bootstrap
│   └── asset.php           # filemtime()-based cache-busting helper
├── .htaccess               # URL rewrites (/de/, /en/, /da/, /de/ueber, /en/about, /da/om, etc.)
├── robots.txt              # Crawler rules
├── llms.txt                # Entry point for AI crawlers (key facts + grounding page links)
├── sitemap.xml             # Multilingual sitemap with hreflang
├── sitemap-images.xml      # Image sitemap
├── .github/
│   └── workflows/
│       └── update-sitemap.yml  # Bumps <lastmod> + JSON-LD dateModified on content pushes (path allowlist)
├── LICENSE                 # Open-source license
├── css/
│   └── styles.css          # All styles (variables, themes, components)
├── js/
│   ├── theme.js            # Dark mode toggle
│   ├── lang-switcher.js    # Disclosure-menu toggle (aria-expanded, outside-click, Escape)
│   ├── eu-mode.js          # Profile toggle (standard ↔ European alternatives), localStorage + attention pulse
│   ├── language.js         # Reads inline i18n JSON; email fill, overlay routing
│   ├── overlay.js          # Legal notice modal
│   ├── contact.js          # Contact form modal + AJAX
│   ├── easter-egg.js       # Animations + confetti
│   ├── link-preview.js     # Hover previews
│   ├── grounding-email.js  # Email obfuscation on grounding page
│   └── confetti.min.js     # Canvas-Confetti (lazy-loaded)
├── contact.php             # Contact form backend (rate limiting, CSRF, honeypot)
├── deploy.php              # GitHub webhook deploy (IP allowlist + HMAC signature, fail-closed)
├── DEPLOY-SETUP.md         # Deployment / webhook setup guide
├── images/
│   ├── oliver-eichhof.png  # Profile photo master (920w, lossless — build source)
│   ├── oliver-eichhof.avif # 920w AVIF (primary, ~54 KB) + 320w/640w responsive srcset
│   ├── oliver-eichhof.webp # 920w WebP (fallback, ~99 KB) + 320w/640w responsive srcset
│   ├── og-image.png        # Open Graph image for social sharing
│   ├── favicons/           # Favicon variants (180, 192, 512)
│   └── hover/              # Link preview screenshots
│       ├── update-previews.php  # Screenshot generation script (token-protected, run via cron)
│       ├── *.webp               # Preview images (server-only, gitignored)
│       ├── .apiflash-key        # APIFlash API key (server-only, gitignored)
│       └── .preview-cron-token  # Secret token for HTTP cron trigger (server-only, gitignored)
│
│   # Server-only (not in repo, gitignored)
├── .contact-config.json    # Email config (recipient, from address)
├── .contact-ratelimit.json # Rate limiting data (auto-generated)
└── .webhook-secret         # GitHub webhook secret
```

---

<a name="deutsch"></a>
## Deutsch

**[English](#english)** | **[Dansk](#dansk)**

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

Mit KI-Unterstützung gebaut als Exploration moderner Webentwicklung. Der Code ist Open Source zum Lernen und als Inspiration.

### Highlights

- 🌐 Mehrsprachig (DE/EN/DA) mit symmetrischen Clean URLs (/de/, /en/, /da/); Bare-Root `/` ist ein reiner Accept-Language-Router (302 für Menschen, 301 → /de/ für Bots); Disclosure-Sprachwähler oben rechts, rechts neben dem Theme-Toggle (Hover/Tap blendet die anderen zwei Sprachen ein)
- 🎨 Dark Mode mit System-Präferenz-Unterstützung
- 🇪🇺 Profil-Umschalter: wechselt die Profil-Links von Mainstream-Plattformen (LinkedIn, Instagram, Bluesky) zu europäischen Alternativen (XING, Pixelfed, Mastodon); Auswahl lokal gespeichert, dezenter Aufmerksamkeits-Puls bis zur ersten Nutzung
- 🔒 Privacy-First: keine Cookies, kein Tracking, keine Analytik
- 📬 Kontaktformular mit Spam-Schutz (Honeypot, Rate Limiting, Zeitprüfung)
- 🔍 SEO: schema.org-JSON-LD-Graph (Person/WebSite/WebPage/BreadcrumbList mit `@id`-Cross-References), hreflang mit `x-default` → `/de/`, `noindex` auf Overlay-URLs, Audit-Tools (Lighthouse/PSI/GTmetrix) als Bots für deterministische Reports
- 📄 About / Grounding Page – maschinenlesbare Identitätsseite für KI-Systeme und Suchmaschinen (Standalone, gestaltet)
- 🎊 Easter Eggs (Leertaste drücken oder Foto doppelklicken)
- ♿ Barrierefrei: Tastaturnavigation, ARIA-Labels, Reduced-Motion-Support

### Technik

Pures HTML/CSS/JavaScript – keine Frameworks. Server-Side Rendering (PHP) für alle Body-Texte je Sprache. Alle Übersetzungen liegen in einem einzigen PHP-Array (`includes/config/i18n.php`), das sich Server-Templates und Browser-JS über einen Inline-`<script type="application/json">`-Block teilen – keine doppelten Übersetzungs-Tabellen. Nutzt [Canvas-Confetti](https://github.com/catdad/canvas-confetti) für visuelle Effekte und [APIFlash](https://apiflash.com/) für Link-Preview-Screenshots.

### Automatisierung

Pushes auf `main`, die Seiteninhalt ändern, aktualisieren automatisch das `<lastmod>` der Sitemap und das JSON-LD-`dateModified` via GitHub Actions. Reine Docs-/Config-Pushes werden übersprungen (Pfad-Allowlist), damit das Freshness-Signal ehrlich bleibt.

---

<a name="dansk"></a>
## Dansk

**[English](#english)** | **[Deutsch](#deutsch)**

Personlig hjemmeside for Oliver Eichhof – Kommunikationsspecialist fra Hamborg.

Bygget med AI-assistance som en udforskning af moderne webudvikling. Koden er open source til læring og inspiration.

### Highlights

- 🌐 Flersproget (DE/EN/DA) med symmetriske clean URLs (/de/, /en/, /da/); bare root `/` er en ren Accept-Language-router (302 for mennesker, 301 → /de/ for bots); disclosure-sprogskifter øverst til højre, til højre for theme-toggle (hover/tap viser de to andre sprog)
- 🎨 Dark mode med systempræference-support
- 🇪🇺 Profilskifter: skifter profil-links fra mainstream-platforme (LinkedIn, Instagram, Bluesky) til europæiske alternativer (XING, Pixelfed, Mastodon); valg gemt lokalt, diskret opmærksomheds-puls indtil første brug
- 🔒 Privacy-first: ingen cookies, ingen tracking, ingen analytics
- 📬 Kontaktformular med spam-beskyttelse (honeypot, rate limiting, tidscheck)
- 🔍 SEO: schema.org JSON-LD-graf (Person/WebSite/WebPage/BreadcrumbList med `@id`-krydsreferencer), hreflang med `x-default` → `/de/`, `noindex` på overlay-URL'er, audit-værktøjer (Lighthouse/PSI/GTmetrix) behandles som bots for deterministiske rapporter
- 📄 About / Grounding Page – maskinlæsbar identitetsside til AI-systemer og søgemaskiner (standalone, styled)
- 🎊 Easter eggs (tryk mellemrum eller dobbeltklik på billedet)
- ♿ Tilgængelig: tastaturnavigation, ARIA-labels, reduced-motion support

### Teknik

Ren HTML/CSS/JavaScript – ingen frameworks. Server-side rendering (PHP) for alle body-tekster per sprog. Alle oversættelser ligger i ét PHP-array (`includes/config/i18n.php`), som server-templates og browser-JS deler via en inline `<script type="application/json">`-blok – ingen duplikerede oversættelsestabeller. Bruger [Canvas-Confetti](https://github.com/catdad/canvas-confetti) til visuelle effekter og [APIFlash](https://apiflash.com/) til link-preview screenshots.

### Automatisering

Push til `main`, der ændrer sideindhold, opdaterer automatisk sitemap'ens `<lastmod>` og JSON-LD-`dateModified` via GitHub Actions. Rene docs-/config-push springes over (sti-allowlist).

---

Made with ♥ and AI in Hamburg
