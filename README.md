# eichhof.me

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

## Features

- 🌐 Mehrsprachig (DE, EN, DA) mit automatischer Spracherkennung
- 🎨 Dark Mode mit System-Präferenz-Erkennung
- 📱 Responsive Design
- 🔒 DSGVO-konform (keine Cookies, kein Tracking)
- ⚡ Optimiert für Performance (lokale Assets, GZIP, Caching)
- 🖼️ Hover-Previews für externe Links
- 🔍 SEO-optimiert mit Sitemap und hreflang

## Tech Stack

- Pure HTML/CSS/JavaScript (keine Frameworks)
- WebP-Bilder für optimale Performance
- APIFlash für Screenshot-Generierung
- GitHub Actions für Automatisierung

## Struktur

```
├── .github/
│   └── workflows/
│       └── update-sitemap.yml   # GitHub Action für Sitemap-Updates
├── .gitignore                   # Git-Ignore-Regeln
├── .htaccess                    # Server-Konfiguration (GZIP, Caching, Security)
├── index.html                   # Hauptseite
├── robots.txt                   # Crawler-Steuerung
├── sitemap.xml                  # Sitemap mit hreflang
├── favicon.ico                  # Multi-Resolution Favicon
├── README.md                    # Diese Datei
└── images/
    ├── favicons/                # Favicon-Varianten (16x16 bis 192x192)
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
Das Script `images/hover/update-previews.php` generiert automatisch Screenshots von verlinkten Websites (Blog, SoundCloud) für die Hover-Previews. Nutzt die APIFlash API für hochwertige WebP-Screenshots (1280x720, 80% Qualität).

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
2. **Server** führt `git pull` aus und aktualisiert die Dateien
3. **Logs** werden in `.deploy-log.txt` gespeichert

#### Setup-Anleitung

**Auf dem Server:**
```bash
# In das Web-Root-Verzeichnis wechseln
cd /pfad/zum/webroot

# Repository clonen
git clone git@github.com:ollrich/eichhof.me.git .

# Secret-Token generieren und in deploy.php eintragen
# Zeile 10: $secret = 'DEIN_GEHEIMER_TOKEN';
```

**In GitHub:**
1. Gehe zu Repository Settings → Webhooks → Add webhook
2. **Payload URL:** `https://eichhof.me/deploy.php`
3. **Content type:** `application/json`
4. **Secret:** Das gleiche Token wie in `deploy.php`
5. **Events:** Nur "Just the push event"

#### Manuelles Deployment

Alternativ kann auch manuell deployed werden:
```bash
ssh deinserver
cd /pfad/zum/webroot
git pull
```

---

Made with ♥ in Hamburg
