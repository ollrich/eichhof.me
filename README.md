# eichhof.me

**[English](#english)** | **[Deutsch](#deutsch)** | **[Dansk](#dansk)**

---

<a name="english"></a>
## English

Personal website of Oliver Eichhof – Communication Specialist from Hamburg.

Built with AI assistance as an exploration of modern web development practices. The code is open source for learning and inspiration.

### Highlights

- 🌐 Multilingual (DE/EN/DA) with clean URLs (/en/, /dk/) and automatic browser language detection
- 🎨 Dark mode with system preference support
- 🔒 Privacy-first: no cookies, no tracking, no analytics
- 📬 Contact form with spam protection (honeypot, rate limiting, time-based checks)
- 🔍 SEO optimized with schema.org structured data (Person) and JSON-LD
- 🎊 Easter eggs (try pressing spacebar or double-clicking the photo)
- ♿ Accessible: keyboard navigation, ARIA labels, reduced motion support

### Tech

Pure HTML/CSS/JavaScript – no frameworks. Uses [Canvas-Confetti](https://github.com/catdad/canvas-confetti) for visual effects and [APIFlash](https://apiflash.com/) for generating link preview screenshots.

### Automation

Every push to `main` automatically updates the sitemap's `<lastmod>` date via GitHub Actions.

### Structure

```
eichhof.me/
├── index.php               # Main entry (multilingual routing, dynamic meta tags)
├── .htaccess               # URL rewrites (/en/, /dk/, /impressum, etc.)
├── robots.txt              # Crawler rules
├── sitemap.xml             # Multilingual sitemap with hreflang
├── sitemap-images.xml      # Image sitemap
├── css/
│   └── styles.css          # All styles (variables, themes, components)
├── js/
│   ├── theme.js            # Dark mode toggle
│   ├── language.js         # Multilingual content switching
│   ├── overlay.js          # Legal notice modal
│   ├── contact.js          # Contact form modal + AJAX
│   ├── easter-egg.js       # Animations + confetti
│   ├── link-preview.js     # Hover previews
│   └── confetti.min.js     # Canvas-Confetti (lazy-loaded)
├── contact.php             # Contact form backend (rate limiting, CSRF, honeypot)
├── images/
│   ├── oliver-eichhof.webp # Profile photo
│   ├── og-image.png        # Open Graph image for social sharing
│   ├── favicons/           # Favicon variants (180, 192, 512)
│   ├── hover/              # Link preview screenshots
│   │   ├── update-previews.php  # Screenshot generation script
│   │   ├── *.webp          # Preview images (server-only, gitignored)
│   │   └── .apiflash-key   # APIFlash API key (server-only, gitignored)
│   └── icons.svg           # SVG sprite
│
│   # Server-only (not in repo, gitignored)
├── .contact-config.json    # Email config (recipient, from address)
├── .contact-ratelimit.json # Rate limiting data (auto-generated)
└── .webhook-secret         # GitHub webhook secret
```

---

<a name="deutsch"></a>
## Deutsch

Persönliche Website von Oliver Eichhof – Kommunikationsspezialist aus Hamburg.

Mit KI-Unterstützung gebaut als Exploration moderner Webentwicklung. Der Code ist Open Source zum Lernen und als Inspiration.

### Highlights

- 🌐 Mehrsprachig (DE/EN/DA) mit Clean URLs (/en/, /dk/) und automatischer Browser-Spracherkennung
- 🎨 Dark Mode mit System-Präferenz-Unterstützung
- 🔒 Privacy-First: keine Cookies, kein Tracking, keine Analytik
- 📬 Kontaktformular mit Spam-Schutz (Honeypot, Rate Limiting, Zeitprüfung)
- 🔍 SEO-optimiert mit schema.org strukturierten Daten (Person) und JSON-LD
- 🎊 Easter Eggs (Leertaste drücken oder Foto doppelklicken)
- ♿ Barrierefrei: Tastaturnavigation, ARIA-Labels, Reduced-Motion-Support

### Technik

Pures HTML/CSS/JavaScript – keine Frameworks. Nutzt [Canvas-Confetti](https://github.com/catdad/canvas-confetti) für visuelle Effekte und [APIFlash](https://apiflash.com/) für Link-Preview-Screenshots.

### Automatisierung

Bei jedem Push auf `main` wird das `<lastmod>`-Datum der Sitemap automatisch via GitHub Actions aktualisiert.

---

<a name="dansk"></a>
## Dansk

Personlig hjemmeside for Oliver Eichhof – Kommunikationsspecialist fra Hamborg.

Bygget med AI-assistance som en udforskning af moderne webudvikling. Koden er open source til læring og inspiration.

### Highlights

- 🌐 Flersproget (DE/EN/DA) med clean URLs (/en/, /dk/) og automatisk browser-sprogdetektering
- 🎨 Dark mode med systempræference-support
- 🔒 Privacy-first: ingen cookies, ingen tracking, ingen analytics
- 📬 Kontaktformular med spam-beskyttelse (honeypot, rate limiting, tidscheck)
- 🔍 SEO-optimeret med schema.org strukturerede data (Person) og JSON-LD
- 🎊 Easter eggs (tryk mellemrum eller dobbeltklik på billedet)
- ♿ Tilgængelig: tastaturnavigation, ARIA-labels, reduced-motion support

### Teknik

Ren HTML/CSS/JavaScript – ingen frameworks. Bruger [Canvas-Confetti](https://github.com/catdad/canvas-confetti) til visuelle effekter og [APIFlash](https://apiflash.com/) til link-preview screenshots.

### Automatisering

Ved hvert push til `main` opdateres sitemap'ens `<lastmod>`-dato automatisk via GitHub Actions.

---

Made with ♥ and AI in Hamburg
