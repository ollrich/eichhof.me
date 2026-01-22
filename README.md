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

Die Seite wird manuell oder per FTP auf den Webserver deployed.

---

Made with ♥ in Hamburg
