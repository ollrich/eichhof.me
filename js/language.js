/**
 * Language Detection and Content Management Module
 * =================================================
 * Handles multilingual content switching based on browser language
 * or explicit URL parameter (?lang=de|en|da)
 */
(function() {
    'use strict';

    /**
     * Email configuration (obfuscated to prevent scraping)
     */
    const EMAIL_CONFIG = {
        domain: ['eichhof', 'me']
    };

    /**
     * Tagline content for each supported language
     */
    const TAGLINES = {
        de: 'Ich arbeite in der Medienbranche und rede im Job gern über gute Kommunikation und was Zielgruppen brauchen. Ab und zu <a href="https://www.schongeil.de/" target="_blank" rel="noopener noreferrer">blogge</a> ich und <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">lege</a> Platten auf.',
        en: 'I work in media and like talking about good communication and what audiences need. Every now and then I <a href="https://www.schongeil.de/en/" target="_blank" rel="noopener noreferrer">blog</a> and <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">spin records</a>.',
        da: 'Jeg arbejder i mediebranchen og taler gerne om god kommunikation og hvad målgrupper har brug for. Af og til <a href="https://www.schongeil.de/en/" target="_blank" rel="noopener noreferrer">blogger</a> jeg og <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">spiller plader</a>.'
    };

    /**
     * Complete translations for all UI elements
     */
    const TRANSLATIONS = {
        de: {
            title: "Impressum",
            link: "Impressum & Datenverarbeitung",
            text1: "Diese Website wird betrieben von:",
            text2: "Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg",
            text3: "Kontakt:",
            text3b: "Verantwortlich für den Inhalt nach § 18 Abs. 2 MStV.",
            subtitle: "Datenverarbeitung",
            text4: "Diese Website verarbeitet keine personenbezogenen Daten.",
            text5: "Es werden keine Cookies gesetzt, keine Logfiles gespeichert und keine Tracking-Tools verwendet. Lediglich Ihre Farbschema-Präferenz wird lokal in Ihrem Browser gespeichert.",
            text6: "Links zu externen Plattformen (LinkedIn, Instagram, Bluesky, Mastodon, GitHub, SoundCloud) unterliegen deren eigenen Datenschutzbestimmungen.",
            email: "E-Mail",
            emailPrefix: "hallo",
            emailAriaLabel: "E-Mail senden",
            hint: "drücke leertaste",
            themeDark: "Licht aus",
            themeLight: "Licht an",
            themeToggleLabel: "Farbschema wechseln",
            closeOverlay: "Schließen",
            closePreview: "Vorschau schließen",
            footerDesktop: 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI in Hamburg erstellt',
            footerMobile: 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI realisiert',
            githubTooltip: "Quellcode auf GitHub",
            githubAriaLabel: "Quellcode auf GitHub"
        },
        en: {
            title: "Legal Notice",
            link: "Legal Notice & Data Processing",
            text1: "This website is operated by:",
            text2: "Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Germany",
            text3: "Contact:",
            text3b: "Responsible for content according to § 18 para. 2 German Interstate Media Treaty (MStV).",
            subtitle: "Data Processing",
            text4: "This website does not process any personal data.",
            text5: "No cookies are set, no log files are stored, and no tracking tools are used. Only your color scheme preference is stored locally in your browser.",
            text6: "Links to external platforms (LinkedIn, Instagram, Bluesky, Mastodon, GitHub, SoundCloud) are subject to their own privacy policies.",
            email: "Email",
            emailPrefix: "hello",
            emailAriaLabel: "Send email",
            hint: "press space",
            themeDark: "Lights off",
            themeLight: "Lights on",
            themeToggleLabel: "Toggle color scheme",
            closeOverlay: "Close",
            closePreview: "Close preview",
            footerDesktop: 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI in Hamburg',
            footerMobile: 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI',
            githubTooltip: "View source on GitHub",
            githubAriaLabel: "View source on GitHub"
        },
        da: {
            title: "Kolofon",
            link: "Kolofon & Databehandling",
            text1: "Denne hjemmeside drives af:",
            text2: "Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Tyskland",
            text3: "Kontakt:",
            text3b: "Ansvarlig for indhold i henhold til § 18 stk. 2 tysk statslig medieaftale (MStV).",
            subtitle: "Databehandling",
            text4: "Denne hjemmeside behandler ingen personoplysninger.",
            text5: "Der sættes ingen cookies, ingen logfiler gemmes, og ingen sporingsværktøjer anvendes. Kun din farvevalg-præference gemmes lokalt i din browser.",
            text6: "Links til eksterne platforme (LinkedIn, Instagram, Bluesky, Mastodon, GitHub, SoundCloud) er underlagt deres egne privatlivspolitikker.",
            email: "E-Mail",
            emailPrefix: "hej",
            emailAriaLabel: "Send e-mail",
            hint: "tryk mellemrum",
            themeDark: "Sluk lyset",
            themeLight: "Tænd lyset",
            themeToggleLabel: "Skift farveskema",
            closeOverlay: "Luk",
            closePreview: "Luk forhåndsvisning",
            footerDesktop: 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI i Hamburg',
            footerMobile: 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI',
            githubTooltip: "Se kildekoden på GitHub",
            githubAriaLabel: "Se kildekoden på GitHub"
        }
    };

    // Current state
    let currentLang = 'de';
    let currentEmailPrefix = 'hallo';

    /**
     * Detect language from URL parameter or browser settings
     * Priority: URL param > Browser language > Default (German)
     * @returns {string} Language code (de, en, or da)
     */
    function detectLanguage() {
        const urlParams = new URLSearchParams(window.location.search);
        const urlLang = urlParams.get('lang');

        // Check URL parameter first (explicit user choice)
        if (urlLang && ['de', 'en', 'da'].includes(urlLang)) {
            return urlLang;
        }

        // Fall back to browser language detection
        const userLang = (navigator.language || navigator.userLanguage).toLowerCase().split('-')[0];
        if (userLang === 'en') return 'en';
        if (userLang === 'da') return 'da';

        return 'de'; // Default
    }

    /**
     * Build email address from obfuscated parts
     * @param {string} prefix - Email prefix (hallo, hello, hej)
     * @returns {string} Complete email address
     */
    function buildEmail(prefix) {
        return prefix + '@' + EMAIL_CONFIG.domain[0] + '.' + EMAIL_CONFIG.domain[1];
    }

    /**
     * Open email client with obfuscated address
     */
    function openEmail() {
        const email = buildEmail(currentEmailPrefix);
        window.location.href = 'mailto:' + email;
    }

    /**
     * Update all page content for the detected language
     */
    function applyLanguage() {
        const langCode = detectLanguage();
        currentLang = langCode;

        const content = TRANSLATIONS[langCode];
        currentEmailPrefix = content.emailPrefix;

        // Update HTML lang attribute for accessibility
        document.documentElement.lang = langCode;

        // Helper function to safely update element content
        const updateElement = (id, value, isHTML) => {
            const el = document.getElementById(id);
            if (el) {
                if (isHTML) {
                    el.innerHTML = value;
                } else {
                    el.textContent = value;
                }
            }
        };

        const updateAttr = (id, attr, value) => {
            const el = document.getElementById(id);
            if (el) el.setAttribute(attr, value);
        };

        // Update tagline
        const tagline = document.getElementById('tagline');
        if (tagline) tagline.innerHTML = TAGLINES[langCode];

        // Update overlay content
        updateElement('overlay-title', content.title);
        updateElement('overlay-subtitle', content.subtitle);
        updateElement('overlay-text-1', content.text1);
        updateElement('overlay-text-2', content.text2, true);
        updateElement('overlay-text-3', content.text3);
        updateElement('overlay-text-3b', content.text3b);
        updateElement('overlay-text-4', content.text4);
        updateElement('overlay-text-5', content.text5);
        updateElement('overlay-text-6', content.text6);

        // Update email in overlay
        const email = buildEmail(content.emailPrefix);
        const overlayEmailLink = document.getElementById('overlay-email-link');
        if (overlayEmailLink) {
            overlayEmailLink.textContent = email;
            overlayEmailLink.href = 'mailto:' + email;
        }

        // Update footer links
        updateElement('footer-link', content.link);
        updateElement('footer-link-mobile', content.link);
        updateElement('footer-text-desktop', content.footerDesktop, true);
        updateElement('footer-text-mobile', content.footerMobile, true);
        updateElement('github-tooltip', content.githubTooltip);
        updateElement('email-text', content.email);
        updateElement('footer-hint', content.hint);

        // Update tooltips
        updateElement('tooltip-dark', content.themeDark);
        updateElement('tooltip-light', content.themeLight);

        // Update aria labels
        updateAttr('theme-toggle', 'aria-label', content.themeToggleLabel);
        updateAttr('close-overlay-btn', 'aria-label', content.closeOverlay);
        updateAttr('preview-close', 'aria-label', content.closePreview);
        updateAttr('email-link', 'aria-label', content.emailAriaLabel);

        // Update social row order (Mastodon first for German visitors)
        const socialRow = document.getElementById('social-row');
        if (socialRow) {
            if (langCode === 'de') {
                socialRow.classList.add('mastodon-first');
            } else {
                socialRow.classList.remove('mastodon-first');
            }
        }
    }

    /**
     * Initialize language module
     */
    function init() {
        applyLanguage();

        // Set up email link handler
        const emailLink = document.getElementById('email-link');
        if (emailLink) {
            emailLink.addEventListener('click', function(e) {
                e.preventDefault();
                openEmail();
            });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.LanguageManager = {
        getCurrentLang: function() { return currentLang; },
        getEmailPrefix: function() { return currentEmailPrefix; },
        openEmail: openEmail
    };
})();
