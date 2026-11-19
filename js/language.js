/**
 * Client-Side Language Support
 * ============================
 * Seit die Sprachstrings serverseitig aus includes/config/i18n.php gerendert
 * werden, macht dieses Modul nur noch zwei Dinge:
 *
 * 1. Es liest das inline-JSON aus <script id="i18n-data" type="application/json">
 *    ein (nur auf der Hauptseite vorhanden), damit JS-Konsumenten (contact.js,
 *    overlay.js, link-preview.js) Strings abfragen können — ohne doppelte
 *    Übersetzungs-Tabelle, die auseinanderlaufen kann.
 *
 * 2. Es befüllt die E-Mail-Links mit der zusammengesetzten Adresse.
 *
 * Serverseitig angeforderte Overlays (data-overlay am <body>) öffnen
 * overlay.js und contact.js selbst — über ihre echten Öffnen-Routinen, damit
 * Fokus, Escape, Schließen, CSRF-Token und Zeitstempel initialisiert sind.
 *
 * Kein URL-Aufräumen mehr: /de/, /en/, /da/ sind symmetrisch und bereits
 * kanonisch. Bare-Root "/" ist reiner Router in index.php, taucht nie als
 * Ziel eines Sprachwähler-Klicks auf.
 *
 * Exportiert window.LanguageManager mit getCurrentLang(), getEmailPrefix(),
 * getTranslation(key), openEmail() — die API bleibt stabil, damit die
 * bestehenden Konsumenten unverändert weiterlaufen.
 */
(function() {
    'use strict';

    // E-Mail-Domain bleibt obfuskiert im JS-Code, damit sie im rohen HTML
    // keinem Scraper direkt ins Auge springt.
    const EMAIL_CONFIG = {
        domain: ['eichhof', 'me']
    };

    /**
     * Parsen des serverseitigen i18n-JSON (nur auf Seiten mit language.js +
     * Kontakformular vorhanden). Liefert das $m-Dict, wie PHP es hinterlegt.
     */
    function readServerI18n() {
        const el = document.getElementById('i18n-data');
        if (!el) return null;
        try {
            return JSON.parse(el.textContent);
        } catch (e) {
            return null;
        }
    }

    /**
     * Aktuelle Sprache vom <body data-lang="…"> (serverseitig gesetzt).
     */
    function readServerLang() {
        const lang = document.body && document.body.dataset.lang;
        return (lang && ['de', 'en', 'da'].includes(lang)) ? lang : 'de';
    }

    const currentLang   = readServerLang();
    const serverI18n    = readServerI18n();
    // Ohne Inline-JSON (Grounding Page) gibt getTranslation() den Key zurück —
    // dort fragt niemand Übersetzungen ab.
    const translations  = serverI18n || {};
    // E-Mail-Präfix kommt aus i18n.php (data-email-prefix am <body>, auf beiden
    // Seiten). Vorher stand es zusätzlich hier und in grounding-email.js.
    const emailPrefix   = (document.body && document.body.dataset.emailPrefix) || 'hallo';

    /**
     * Baut die obfuskierte E-Mail-Adresse aus Prefix + Domain-Parts.
     */
    function buildEmail(prefix) {
        return prefix + '@' + EMAIL_CONFIG.domain[0] + '.' + EMAIL_CONFIG.domain[1];
    }

    function openEmail() {
        window.location.href = 'mailto:' + buildEmail(emailPrefix);
    }

    /**
     * Befüllt alle E-Mail-Links (Impressum-/Privacy-Overlay, Kontakt-Fallback)
     * mit der zusammengesetzten Adresse. Server rendert sie bewusst leer —
     * so landet die Adresse nicht im rohen HTML für Scraper.
     */
    function fillEmailLinks() {
        const email  = buildEmail(emailPrefix);
        const mailto = 'mailto:' + email;
        // Overlay-E-Mails (Impressum + Privacy).
        document.querySelectorAll('.overlay-email-link').forEach(function(el) {
            el.textContent = email;
            el.href = mailto;
        });
        // Kontakt-Fallback-Link (Kontaktformular-Popup).
        const fallback = document.getElementById('contact-fallback-link');
        if (fallback) {
            fallback.textContent = email;
            fallback.href = mailto;
        }
    }

    function init() {
        fillEmailLinks();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Externes API — stabil gehalten für contact.js, overlay.js, link-preview.js.
    window.LanguageManager = {
        getCurrentLang:  function()     { return currentLang; },
        getEmailPrefix:  function()     { return emailPrefix; },
        getTranslation:  function(key)  { return translations[key] !== undefined ? translations[key] : key; },
        openEmail:       openEmail
    };
})();
