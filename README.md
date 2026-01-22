# eichhof.me

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

## Features

- 🌐 Mehrsprachig (DE, EN, DA) mit automatischer Spracherkennung
- 🎨 Dark Mode
- 📱 Responsive Design
- 🔒 DSGVO-konform (keine Cookies, kein Tracking)
- ⚡ Optimiert für Performance (lokale Assets, GZIP, Caching)

## Struktur

```
├── index.html          # Hauptseite
├── robots.txt          # Crawler-Steuerung
├── sitemap.xml         # Sitemap mit hreflang
├── .htaccess           # Server-Konfiguration
├── favicon.ico         # Multi-Resolution Favicon
└── images/
    ├── favicons/       # Favicon-Varianten
    ├── hover/          # Link-Previews
    └── ...
```

## Automatisierungen

### Sitemap-Datum
Bei jedem Push auf `main` wird das `<lastmod>`-Datum in der Sitemap automatisch aktualisiert.

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
