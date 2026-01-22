# eichhof.me

[🇬🇧 English](#english) | [🇩🇪 Deutsch](#deutsch)

---

## English

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
- 🔍 SEO optimized with schema.org structured data (Person, WebSite, WebPage), sitemap, and hreflang
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
├── .gitignore                   # Git ignore rules (includes .webhook-secret)
├── .htaccess                    # Server config (GZIP, caching, security)
├── deploy.php                   # Webhook handler (reads secret from file)
├── DEPLOY-SETUP.md              # Deployment setup instructions
├── index.html                   # Main page (optimized CSS/JS)
├── robots.txt                   # Crawler control
├── sitemap.xml                  # Sitemap with hreflang
├── favicon.ico                  # Multi-resolution favicon
├── README.md                    # This file
├── js/
│   └── confetti.min.js          # Canvas-Confetti library (lazy-loaded)
└── images/
    ├── favicons/                # Favicon variants (16x16 to 512x512)
    ├── hover/                   # Link preview screenshots
    │   ├── blog-preview.webp           # Blog preview (DE)
    │   ├── blog-preview-en.webp        # Blog preview (EN)
    │   ├── soundcloud-preview.webp     # SoundCloud preview
    │   ├── update-previews.php         # Screenshot update script
    │   └── update-log.txt              # Screenshot update log
    ├── og-image.png             # Open Graph image for social media
    ├── oliver-eichhof.jpg       # Profile photo (original)
    └── oliver-eichhof.webp      # Profile photo (optimized)
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

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

Dieses Projekt erkundet moderne Webentwicklungs-Workflows mit KI-Unterstützung und umfasst automatisiertes Deployment, mehrsprachige Unterstützung und datenschutzfreundliches Design.

### Über dieses Projekt

Dies ist eine persönliche Website, die als Exploration moderner Webentwicklungspraktiken entstanden ist. Der Code ist Open Source zum Lernen und zur Inspiration:

- **Nicht produktionsreif für direkte Nutzung**: API-Keys und Konfiguration sind bewusst im Repository sichtbar aus Transparenz- und Bildungsgründen
- **Als Inspiration nutzen**: Gerne Implementierungsmuster studieren, spezifische Features kopieren oder den Ansatz für eigene Projekte adaptieren
- **Für Produktiveinsatz**: Alle Secrets auslagern (siehe Setup-Anleitung), Sicherheitspraktiken anpassen und Code für die eigenen Anforderungen prüfen

## Features

- 🌐 Mehrsprachig (DE, EN, DA) mit automatischer Spracherkennung
- 🎨 Dark Mode mit System-Präferenz-Erkennung und CSS Custom Properties
- 📱 Responsive Design mit mobil-optimiertem Layout
- 🔒 Privacy-First (keine Cookies, kein Tracking, keine Analytik)
- ⚡ Performance-optimiert (CSS-Variablen, Vendor-Präfixe, optimiertes JS)
- 🖼️ Hover-Previews für externe Links (nur Desktop)
- 🔍 SEO-optimiert mit schema.org strukturierten Daten (Person, WebSite, WebPage), Sitemap und hreflang
- 🎊 Easter Eggs: Konfetti (Timer), Foto-Animation (Leertaste/Doppelklick)
- ♿ Barrierefreiheit: ARIA-Labels, Tastaturnavigation, Reduced-Motion-Support

## Tech Stack

- Pure HTML/CSS/JavaScript (keine Frameworks)
- Schema.org strukturierte Daten (JSON-LD) für bessere Suchmaschinen-Sichtbarkeit
- WebP-Bilder für optimale Performance
- [Canvas-Confetti](https://github.com/catdad/canvas-confetti) für visuelle Effekte
- [APIFlash](https://apiflash.com/) für Screenshot-Generierung
- GitHub Actions für Automatisierung

## Struktur

```
├── .github/
│   └── workflows/
│       └── update-sitemap.yml   # GitHub Action für Sitemap-Updates
├── .gitignore                   # Git-Ignore-Regeln (inkl. .webhook-secret)
├── .htaccess                    # Server-Konfiguration (GZIP, Caching, Security)
├── deploy.php                   # Webhook-Handler (liest Secret aus Datei)
├── DEPLOY-SETUP.md              # Deployment-Setup-Anleitung
├── index.html                   # Hauptseite (optimiertes CSS/JS)
├── robots.txt                   # Crawler-Steuerung
├── sitemap.xml                  # Sitemap mit hreflang
├── favicon.ico                  # Multi-Resolution Favicon
├── README.md                    # Diese Datei
├── js/
│   └── confetti.min.js          # Canvas-Confetti Library (lazy-loaded)
└── images/
    ├── favicons/                # Favicon-Varianten (16x16 bis 512x512)
    ├── hover/                   # Link-Preview-Screenshots
    │   ├── blog-preview.webp           # Blog-Preview (DE)
    │   ├── blog-preview-en.webp        # Blog-Preview (EN)
    │   ├── soundcloud-preview.webp     # SoundCloud-Preview
    │   ├── update-previews.php         # Script zum Aktualisieren der Screenshots
    │   └── update-log.txt              # Log-Datei der Screenshot-Updates
    ├── og-image.png             # Open Graph Image für Social Media
    ├── oliver-eichhof.jpg       # Profilbild (Original)
    └── oliver-eichhof.webp      # Profilbild (optimiert)
```

## Automatisierungen

### Sitemap-Datum (GitHub Actions)
Bei jedem Push auf `main` wird das `<lastmod>`-Datum in der Sitemap automatisch über eine GitHub Action aktualisiert. Die Action ignoriert dabei Änderungen an der README und `.github/`-Dateien.

### Link-Preview Screenshots
Das Script `images/hover/update-previews.php` generiert automatisch Screenshots von verlinkten Websites (Blog, SoundCloud) für die Hover-Previews. Nutzt die [APIFlash](https://apiflash.com/) API für hochwertige WebP-Screenshots (1280x720, 80% Qualität).

**Sicherheitshinweis**: Der API-Key wird in `.apiflash-key` (nicht im Repository) gespeichert. Diese Datei auf dem Server mit dem eigenen APIFlash-API-Key erstellen.

## Lokale Entwicklung

Für lokales Testen mit PHP:
```bash
php -S localhost:8000
```

Oder mit Python:
```bash
python -m http.server 8000
```

## Deployment

### Automatisches Deployment via GitHub Webhook ✅

Bei jedem Push auf `main` wird die Website automatisch auf den Server deployed:

1. **GitHub** sendet Push-Notification an `deploy.php` auf dem Server
2. **Server** validiert Webhook-Signatur und führt `git pull` aus
3. **Logs** werden in `.deploy-log.txt` gespeichert

#### Setup-Anleitung

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

#### Manuelles Deployment

Alternativ kann auch manuell deployed werden:
```bash
ssh deinserver
cd /pfad/zum/webroot
git pull
```

---

Made with ♥ in Hamburg • Built with AI assistance
