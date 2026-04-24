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
 * 2. Es öffnet serverseitig angeforderte Overlays (data-overlay-Attribut am
 *    <body>) und setzt die Social-Row-Reihenfolge (Mastodon-first für DE).
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

    // Minimaler Fallback, falls das inline-JSON fehlt (z. B. auf /ueber)
    // oder korrupt ist. Deckt nur, was JS wirklich braucht.
    const FALLBACK = {
        de: { emailPrefix: 'hallo' },
        en: { emailPrefix: 'hello' },
        da: { emailPrefix: 'hej' }
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
    // Wenn das inline-JSON fehlt (auf Seiten ohne Kontaktformular), liefert
    // der FALLBACK wenigstens emailPrefix. Alles andere geben wir als Key
    // zurück — Konsumenten fragen solche Keys dort eh nicht ab.
    const translations  = serverI18n || FALLBACK[currentLang] || FALLBACK.de;
    const emailPrefix   = translations.emailPrefix || 'hallo';

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
     * Social-Row-Reihenfolge: Für DE steht Mastodon links, sonst Bluesky.
     * Rein kosmetisch — kleine lokale Präferenz, die nicht im Markup
     * dupliziert werden muss.
     */
    function applySocialRowOrder() {
        const socialRow = document.getElementById('social-row');
        if (!socialRow) return;
        socialRow.classList.toggle('mastodon-first', currentLang === 'de');
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

    /**
     * Öffnet vom Server angefordertes Overlay (/impressum, /kontakt, /…).
     * Der kleine Timeout wartet, bis overlay.js / contact.js gebunden haben.
     */
    function handleServerOverlay() {
        const openOverlay = document.body.dataset.overlay;
        if (!openOverlay) return;
        setTimeout(function() {
            if (openOverlay === 'impressum') {
                const overlay = document.getElementById('overlay');
                if (overlay) overlay.classList.add('active');
            } else if (openOverlay === 'privacy') {
                const privacyOverlay = document.getElementById('privacy-overlay');
                if (privacyOverlay) privacyOverlay.classList.add('active');
            } else if (openOverlay === 'contact') {
                const contactOverlay = document.getElementById('contact-overlay');
                if (contactOverlay) contactOverlay.classList.add('active');
            }
        }, 100);
    }

    function init() {
        applySocialRowOrder();
        fillEmailLinks();
        handleServerOverlay();
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
