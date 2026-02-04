# eichhof.me

<a name="english"></a>
## English

*[Deutsch](#deutsch) | [Dansk](#dansk)*

Personal website of Oliver Eichhof – Communication Specialist from Hamburg.

This project explores modern web development workflows with AI assistance, featuring automated deployment, multilingual support, and privacy-first design.

### About This Project

This is a personal website built as an exploration of modern web development practices. While the code is open source for learning and inspiration:

- **Use as reference**: Study the implementation patterns, copy specific features, or adapt the approach for your own projects
- **Production deployment requires setup**: You'll need to configure your own API keys and secrets (see [DEPLOY-SETUP.md](DEPLOY-SETUP.md))
- **Educational focus**: This project demonstrates modern web development workflows with AI assistance, automated deployment, and privacy-first design

### Features

- 🌐 Multilingual (DE, EN, DA) with automatic language detection
- 🎨 Dark mode with system preference detection and CSS custom properties
- 📱 Responsive design with mobile-optimized layout
- 🔒 Privacy-first (no cookies, no tracking, no analytics)
- ⚡ Performance optimized (CSS variables, vendor prefixes, optimized JS)
- 🖼️ Hover previews for external links (desktop only)
- 🔍 SEO optimized with schema.org structured data (Person, WebSite, WebPage) and sitemap
- 🤖 AI-optimized discovery with llms.txt/html/md (multiple formats due to server-side bot blocking of .txt files from datacenter IPs)
- 🎊 Easter eggs: Confetti (timer), photo animation (space/double-click)
- ♿ Accessibility: ARIA labels, keyboard navigation, reduced motion support

### Tech Stack

- Pure HTML/CSS/JavaScript (no frameworks)
- Schema.org structured data (JSON-LD) for enhanced search engine visibility
- WebP images for optimal performance
- [Canvas-Confetti](https://github.com/catdad/canvas-confetti) for visual effects
- [APIFlash](https://apiflash.com/) for screenshot generation
- GitHub Actions for automation

### Structure

```
├── .github/
│   └── workflows/
│       └── update-sitemap.yml   # GitHub Action for sitemap updates
├── .gitignore                   # Git ignore rules (includes .webhook-secret, .apiflash-key)
├── .htaccess                    # Server config (GZIP, caching, security)
├── deploy.php                   # Webhook handler (reads secret from file)
├── DEPLOY-SETUP.md              # Deployment setup instructions
├── index.html                   # Main page
├── robots.txt                   # Crawler control
├── sitemap.xml                  # Sitemap
├── sitemap-images.xml           # Google Image Sitemap
├── llms.txt                     # LLM-optimized profile (AI discovery)
├── llms.html                    # LLM profile as HTML (workaround for bot blocking)
├── llms.md                      # LLM profile as Markdown
├── favicon.ico                  # Multi-resolution favicon
├── README.md                    # This file
├── css/
│   └── styles.css               # Main stylesheet (reset, variables, theme, components)
├── js/
│   ├── theme.js                 # Dark mode with system preference fallback
│   ├── language.js              # Multilingual content switching
│   ├── overlay.js               # Modal (Impressum) with focus trap
│   ├── easter-egg.js            # Heartbeat animation + confetti
│   ├── link-preview.js          # Hover previews for tagline links
│   └── confetti.min.js          # Canvas-Confetti library (lazy-loaded)
└── images/
    ├── favicons/                # Favicon variants (180x180, 192x192, 512x512)
    ├── hover/                   # Link preview screenshots
    │   ├── blog-preview.webp           # Blog preview (DE)
    │   ├── blog-preview-en.webp        # Blog preview (EN)
    │   ├── soundcloud-preview.webp     # SoundCloud preview
    │   ├── update-previews.php         # Screenshot update script
    │   └── update-log.txt              # Screenshot update log
    ├── icons.svg                # SVG icon sprite
    ├── og-image.webp            # Open Graph image for social media
    └── oliver-eichhof.webp      # Profile photo
```

### Automation

#### Sitemap Date (GitHub Actions)
Every push to `main` automatically updates the `<lastmod>` date in the sitemap via GitHub Action. The action ignores changes to README and `.github/` files.

#### Link Preview Screenshots
The script `images/hover/update-previews.php` automatically generates screenshots of linked websites (blog, SoundCloud) for hover previews. Uses the [APIFlash](https://apiflash.com/) API for high-quality WebP screenshots (1280x720, 80% quality).

**Security Note**: The API key is stored in `.apiflash-key` (not in the repository). Create this file on your server with your own APIFlash API key.

### Local Development

For local testing with PHP:
```bash
php -S localhost:8000
```

Or with Python:
```bash
python -m http.server 8000
```

### Deployment

#### Automated Deployment via GitHub Webhook ✅

Every push to `main` automatically deploys the website to the server:

1. **GitHub** sends push notification to `deploy.php` on the server
2. **Server** validates webhook signature and executes `git pull`
3. **Logs** are saved in `.deploy-log.txt`

##### Setup Instructions

**Detailed setup instructions are in [`DEPLOY-SETUP.md`](DEPLOY-SETUP.md)**

Quick summary:

**On the server:**
```bash
cd /path/to/webroot
git clone https://github.com/ollrich/eichhof.me.git .

# Generate and store webhook secret
openssl rand -hex 32 > .webhook-secret
chmod 600 .webhook-secret
```

**In GitHub:**
1. Repository Settings → Webhooks → Add webhook
2. **Payload URL:** `https://eichhof.me/deploy.php`
3. **Content type:** `application/json`
4. **Secret:** Content from `.webhook-secret` file
5. **Events:** Only "Just the push event"

⚠️ **Security Note:** The webhook secret is stored in `.webhook-secret` (not in the repository) for security reasons.

##### Manual Deployment

Alternatively, deploy manually:
```bash
ssh yourserver
cd /path/to/webroot
git pull
```

---

<a name="deutsch"></a>
## Deutsch

*[English](#english) | [Dansk](#dansk)*

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

Dieses Projekt erkundet moderne Webentwicklungs-Workflows mit KI-Unterstützung und umfasst automatisiertes Deployment, mehrsprachige Unterstützung und datenschutzfreundliches Design.

### Über dieses Projekt

Dies ist eine persönliche Website, die als Exploration moderner Webentwicklungspraktiken entstanden ist. Der Code ist Open Source zum Lernen und zur Inspiration:

- **Als Referenz nutzen**: Implementierungsmuster studieren, spezifische Features kopieren oder den Ansatz für eigene Projekte adaptieren
- **Produktiv-Deployment erfordert Setup**: API-Keys und Secrets müssen selbst konfiguriert werden (siehe [DEPLOY-SETUP.md](DEPLOY-SETUP.md))
- **Bildungsfokus**: Dieses Projekt demonstriert moderne Webentwicklungs-Workflows mit KI-Unterstützung, automatisiertem Deployment und datenschutzfreundlichem Design

### Features

- 🌐 Mehrsprachig (DE, EN, DA) mit automatischer Spracherkennung
- 🎨 Dark Mode mit System-Präferenz-Erkennung und CSS Custom Properties
- 📱 Responsive Design mit mobil-optimiertem Layout
- 🔒 Privacy-First (keine Cookies, kein Tracking, keine Analytik)
- ⚡ Performance-optimiert (CSS-Variablen, Vendor-Präfixe, optimiertes JS)
- 🖼️ Hover-Previews für externe Links (nur Desktop)
- 🔍 SEO-optimiert mit schema.org strukturierten Daten (Person, WebSite, WebPage) und Sitemap
- 🤖 KI-optimierte Discovery mit llms.txt/html/md (mehrere Formate wegen Server-seitiger Bot-Blockierung von .txt-Dateien aus Rechenzentrum-IPs)
- 🎊 Easter Eggs: Konfetti (Timer), Foto-Animation (Leertaste/Doppelklick)
- ♿ Barrierefreiheit: ARIA-Labels, Tastaturnavigation, Reduced-Motion-Support

### Tech Stack

- Pure HTML/CSS/JavaScript (keine Frameworks)
- Schema.org strukturierte Daten (JSON-LD) für bessere Suchmaschinen-Sichtbarkeit
- WebP-Bilder für optimale Performance
- [Canvas-Confetti](https://github.com/catdad/canvas-confetti) für visuelle Effekte
- [APIFlash](https://apiflash.com/) für Screenshot-Generierung
- GitHub Actions für Automatisierung

### Struktur

```
├── .github/
│   └── workflows/
│       └── update-sitemap.yml   # GitHub Action für Sitemap-Updates
├── .gitignore                   # Git-Ignore-Regeln (inkl. .webhook-secret, .apiflash-key)
├── .htaccess                    # Server-Konfiguration (GZIP, Caching, Security)
├── deploy.php                   # Webhook-Handler (liest Secret aus Datei)
├── DEPLOY-SETUP.md              # Deployment-Setup-Anleitung
├── index.html                   # Hauptseite
├── robots.txt                   # Crawler-Steuerung
├── sitemap.xml                  # Sitemap
├── sitemap-images.xml           # Google Image Sitemap
├── llms.txt                     # LLM-optimiertes Profil (KI-Discovery)
├── llms.html                    # LLM-Profil als HTML (Workaround für Bot-Blocking)
├── llms.md                      # LLM-Profil als Markdown
├── favicon.ico                  # Multi-Resolution Favicon
├── README.md                    # Diese Datei
├── css/
│   └── styles.css               # Hauptstylesheet (Reset, Variablen, Theme, Komponenten)
├── js/
│   ├── theme.js                 # Dark Mode mit System-Präferenz-Fallback
│   ├── language.js              # Mehrsprachiger Content-Switch
│   ├── overlay.js               # Modal (Impressum) mit Focus-Trap
│   ├── easter-egg.js            # Heartbeat-Animation + Konfetti
│   ├── link-preview.js          # Hover-Previews für Tagline-Links
│   └── confetti.min.js          # Canvas-Confetti Library (lazy-loaded)
└── images/
    ├── favicons/                # Favicon-Varianten (180x180, 192x192, 512x512)
    ├── hover/                   # Link-Preview-Screenshots
    │   ├── blog-preview.webp           # Blog-Preview (DE)
    │   ├── blog-preview-en.webp        # Blog-Preview (EN)
    │   ├── soundcloud-preview.webp     # SoundCloud-Preview
    │   ├── update-previews.php         # Script zum Aktualisieren der Screenshots
    │   └── update-log.txt              # Log-Datei der Screenshot-Updates
    ├── icons.svg                # SVG-Icon-Sprite
    ├── og-image.webp            # Open Graph Image für Social Media
    └── oliver-eichhof.webp      # Profilbild
```

### Automatisierungen

#### Sitemap-Datum (GitHub Actions)
Bei jedem Push auf `main` wird das `<lastmod>`-Datum in der Sitemap automatisch über eine GitHub Action aktualisiert. Die Action ignoriert dabei Änderungen an der README und `.github/`-Dateien.

#### Link-Preview Screenshots
Das Script `images/hover/update-previews.php` generiert automatisch Screenshots von verlinkten Websites (Blog, SoundCloud) für die Hover-Previews. Nutzt die [APIFlash](https://apiflash.com/) API für hochwertige WebP-Screenshots (1280x720, 80% Qualität).

**Sicherheitshinweis**: Der API-Key wird in `.apiflash-key` (nicht im Repository) gespeichert. Diese Datei auf dem Server mit dem eigenen APIFlash-API-Key erstellen.

### Lokale Entwicklung

Für lokales Testen mit PHP:
```bash
php -S localhost:8000
```

Oder mit Python:
```bash
python -m http.server 8000
```

### Deployment

#### Automatisches Deployment via GitHub Webhook ✅

Bei jedem Push auf `main` wird die Website automatisch auf den Server deployed:

1. **GitHub** sendet Push-Notification an `deploy.php` auf dem Server
2. **Server** validiert Webhook-Signatur und führt `git pull` aus
3. **Logs** werden in `.deploy-log.txt` gespeichert

##### Setup-Anleitung

**Detaillierte Anleitung in [`DEPLOY-SETUP.md`](DEPLOY-SETUP.md)**

Kurzübersicht:

**Auf dem Server:**
```bash
cd /pfad/zum/webroot
git clone git@github.com:ollrich/eichhof.me.git .

# Webhook-Secret generieren und speichern
openssl rand -hex 32 > .webhook-secret
chmod 600 .webhook-secret
```

**In GitHub:**
1. Repository Settings → Webhooks → Add webhook
2. **Payload URL:** `https://eichhof.me/deploy.php`
3. **Content type:** `application/json`
4. **Secret:** Inhalt aus `.webhook-secret`-Datei
5. **Events:** Nur "Just the push event"

⚠️ **Sicherheitshinweis:** Das Webhook-Secret wird aus Sicherheitsgründen in `.webhook-secret` (nicht im Repository) gespeichert.

##### Manuelles Deployment

Alternativ kann auch manuell deployed werden:
```bash
ssh deinserver
cd /pfad/zum/webroot
git pull
```

---

<a name="dansk"></a>
## Dansk

*[English](#english) | [Deutsch](#deutsch)*

Personlig hjemmeside for Oliver Eichhof – Kommunikationsspecialist fra Hamborg.

Dette projekt udforsker moderne webudviklingsprocesser med AI-assistance og omfatter automatiseret deployment, flersproget support og privacy-first design.

### Om dette projekt

Dette er en personlig hjemmeside bygget som en udforskning af moderne webudviklingspraksis. Koden er open source til læring og inspiration:

- **Brug som reference**: Studér implementeringsmønstre, kopiér specifikke funktioner eller tilpas tilgangen til dine egne projekter
- **Produktions-deployment kræver opsætning**: Du skal konfigurere dine egne API-nøgler og secrets (se [DEPLOY-SETUP.md](DEPLOY-SETUP.md))
- **Uddannelsesfokus**: Dette projekt demonstrerer moderne webudviklingsprocesser med AI-assistance, automatiseret deployment og privacy-first design

### Features

- 🌐 Flersproget (DE, EN, DA) med automatisk sprogdetektion
- 🎨 Dark mode med systempræferencedetektering og CSS custom properties
- 📱 Responsivt design med mobil-optimeret layout
- 🔒 Privacy-first (ingen cookies, ingen tracking, ingen analytics)
- ⚡ Performance-optimeret (CSS-variabler, vendor-præfikser, optimeret JS)
- 🖼️ Hover-previews for eksterne links (kun desktop)
- 🔍 SEO-optimeret med schema.org strukturerede data (Person, WebSite, WebPage) og sitemap
- 🤖 AI-optimeret discovery med llms.txt/html/md (flere formater pga. server-side bot-blokering af .txt-filer fra datacenter-IP'er)
- 🎊 Easter eggs: Konfetti (timer), foto-animation (mellemrum/dobbeltklik)
- ♿ Tilgængelighed: ARIA-labels, tastaturnavigation, reduced-motion support

### Tech Stack

- Pure HTML/CSS/JavaScript (ingen frameworks)
- Schema.org strukturerede data (JSON-LD) for forbedret søgemaskinesynlighed
- WebP-billeder for optimal performance
- [Canvas-Confetti](https://github.com/catdad/canvas-confetti) til visuelle effekter
- [APIFlash](https://apiflash.com/) til screenshot-generering
- GitHub Actions til automatisering

### Struktur

```
├── .github/
│   └── workflows/
│       └── update-sitemap.yml   # GitHub Action til sitemap-opdateringer
├── .gitignore                   # Git ignore-regler (inkl. .webhook-secret, .apiflash-key)
├── .htaccess                    # Server-konfiguration (GZIP, caching, security)
├── deploy.php                   # Webhook-handler (læser secret fra fil)
├── DEPLOY-SETUP.md              # Deployment setup-instruktioner
├── index.html                   # Hovedside
├── robots.txt                   # Crawler-kontrol
├── sitemap.xml                  # Sitemap
├── sitemap-images.xml           # Google Image Sitemap
├── llms.txt                     # LLM-optimeret profil (AI-discovery)
├── llms.html                    # LLM-profil som HTML (workaround for bot-blokering)
├── llms.md                      # LLM-profil som Markdown
├── favicon.ico                  # Multi-resolution favicon
├── README.md                    # Denne fil
├── css/
│   └── styles.css               # Hoved-stylesheet (reset, variabler, tema, komponenter)
├── js/
│   ├── theme.js                 # Dark mode med systempræference-fallback
│   ├── language.js              # Flersproget content-skift
│   ├── overlay.js               # Modal (Kolofon) med focus-trap
│   ├── easter-egg.js            # Heartbeat-animation + konfetti
│   ├── link-preview.js          # Hover-previews for tagline-links
│   └── confetti.min.js          # Canvas-Confetti library (lazy-loaded)
└── images/
    ├── favicons/                # Favicon-varianter (180x180, 192x192, 512x512)
    ├── hover/                   # Link-preview screenshots
    │   ├── blog-preview.webp           # Blog-preview (DE)
    │   ├── blog-preview-en.webp        # Blog-preview (EN)
    │   ├── soundcloud-preview.webp     # SoundCloud-preview
    │   ├── update-previews.php         # Script til opdatering af screenshots
    │   └── update-log.txt              # Log-fil for screenshot-opdateringer
    ├── icons.svg                # SVG-icon-sprite
    ├── og-image.webp            # Open Graph-billede til sociale medier
    └── oliver-eichhof.webp      # Profilbillede
```

### Automatiseringer

#### Sitemap-dato (GitHub Actions)
Ved hvert push til `main` opdateres `<lastmod>`-datoen i sitemappen automatisk via en GitHub Action. Actionen ignorerer ændringer i README og `.github/`-filer.

#### Link-preview screenshots
Scriptet `images/hover/update-previews.php` genererer automatisk screenshots af linkede websites (blog, SoundCloud) til hover-previews. Bruger [APIFlash](https://apiflash.com/) API til high-quality WebP-screenshots (1280x720, 80% kvalitet).

**Sikkerhedsnotat**: API-nøglen gemmes i `.apiflash-key` (ikke i repository). Opret denne fil på serveren med din egen APIFlash API-nøgle.

### Lokal udvikling

Til lokal test med PHP:
```bash
php -S localhost:8000
```

Eller med Python:
```bash
python -m http.server 8000
```

### Deployment

#### Automatisk deployment via GitHub Webhook ✅

Ved hvert push til `main` deployes hjemmesiden automatisk til serveren:

1. **GitHub** sender push-notifikation til `deploy.php` på serveren
2. **Server** validerer webhook-signatur og udfører `git pull`
3. **Logs** gemmes i `.deploy-log.txt`

##### Setup-instruktioner

**Detaljerede instruktioner i [`DEPLOY-SETUP.md`](DEPLOY-SETUP.md)**

Hurtig oversigt:

**På serveren:**
```bash
cd /sti/til/webroot
git clone https://github.com/ollrich/eichhof.me.git .

# Generér og gem webhook-secret
openssl rand -hex 32 > .webhook-secret
chmod 600 .webhook-secret
```

**I GitHub:**
1. Repository Settings → Webhooks → Add webhook
2. **Payload URL:** `https://eichhof.me/deploy.php`
3. **Content type:** `application/json`
4. **Secret:** Indhold fra `.webhook-secret`-fil
5. **Events:** Kun "Just the push event"

⚠️ **Sikkerhedsnotat:** Webhook-secreten gemmes af sikkerhedsgrunde i `.webhook-secret` (ikke i repository).

##### Manuelt deployment

Alternativt kan der deployes manuelt:
```bash
ssh dinserver
cd /sti/til/webroot
git pull
```

---

Made with ♥ in Hamburg • Built with AI assistance
