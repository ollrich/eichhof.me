/**
 * Language Detection and Content Management Module
 * =================================================
 * Handles multilingual content switching based on:
 * 1. Server-detected language (from URL path like /en/ or /da/)
 * 2. URL parameter (?lang=de|en|da)
 * 3. Browser language preference
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
            text4: "Diese Website verwendet keine Cookies, keine Logfiles und keine Tracking-Tools. Lediglich deine Farbschema-Präferenz wird lokal in deinem Browser gespeichert.",
            text5: "Bei Nutzung des Kontaktformulars werden dein Name, deine E-Mail-Adresse und deine Nachricht per E-Mail übermittelt. Zur Spam-Abwehr wird deine IP-Adresse temporär verarbeitet, aber nicht gespeichert.",
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
            footerEntity: 'Oliver Eichhof, Kommunikationsspezialist aus Hamburg',
            githubTooltip: "Quellcode auf GitHub",
            githubAriaLabel: "Quellcode auf GitHub",
            // Kontaktformular
            contactTitle: "Kontakt",
            contactName: "Dein Name",
            contactEmail: "Deine E-Mail-Adresse",
            contactMessage: "Deine Nachricht",
            contactSubmit: "Nachricht senden",
            contactSending: "Wird gesendet...",
            contactSuccess: "Vielen Dank! Deine Nachricht wurde gesendet.",
            contactErrorGeneral: "Leider ist ein Fehler aufgetreten. Bitte versuche es später erneut.",
            contactErrorName: "Bitte gib deinen Namen ein (mind. 2 Zeichen).",
            contactErrorEmail: "Bitte gib eine gültige E-Mail-Adresse ein.",
            contactErrorMessage: "Bitte gib eine Nachricht ein (mind. 10 Zeichen).",
            contactErrorRateLimit: "Zu viele Anfragen. Bitte warte einige Minuten.",
            contactPrivacy: "Deine Daten werden nur zur Beantwortung verwendet. Zur Spam-Abwehr wird deine IP temporär verarbeitet, aber nicht gespeichert.",
            contactFallback: "Oder direkt per E-Mail:",
            // About overlay
            aboutTitle: "Oliver Eichhof",
            aboutSummary: "Oliver Eichhof ist ein Kommunikationsspezialist aus Hamburg. Er arbeitet als Leiter Marketing bei REGIOCAST und verfügt über mehr als 15 Jahre Erfahrung in digitaler Markenführung, Kampagnenentwicklung und B2B-Kommunikation.",
            aboutFactsTitle: "Steckbrief",
            aboutDtRole: "Arbeitgeber",
            aboutDdRole: '<a href="https://www.regiocast.de/" target="_blank" rel="noopener noreferrer">REGIOCAST GmbH & Co. KG</a>',
            aboutDtLocation: "Standort",
            aboutDdLocation: "Hamburg",
            aboutDtBorn: "Geboren",
            aboutDdBorn: "1979 in Bremerhaven",
            aboutDtLanguages: "Sprachen",
            aboutDdLanguages: "Deutsch (Muttersprache), Englisch (fließend), Dänisch (Grundkenntnisse)",
            aboutCareerTitle: "Beruflicher Werdegang",
            aboutEducationTitle: "Ausbildung",
            aboutEdu1: "Studium Digitale Medien",
            aboutEdu2: "Fachhochschulreife",
            aboutEdu3: "Informatikkaufmann",
            aboutEdu4: "Einzelhandelskaufmann",
            aboutSkillsTitle: "Kernkompetenzen",
            aboutSkills: "Markenführung, Employer Branding, Kommunikationsstrategie, digitale Kampagnenentwicklung, Journey Design, KPI-Frameworks, GEO/SEO/SEA, Marketing Automation, KI-gestützte Workflows, Stakeholder Management, Content-Strategie, B2B/B2C-Kommunikation.",
            aboutProjectsTitle: "Projekte",
            aboutProjectBlog: "— Persönlicher Blog",
            aboutProjectCode: "— Open-Source-Projekte",
            aboutProfilesTitle: "Präsenzen",
            aboutMentionsTitle: "Erwähnungen",
            aboutTriggerLabel: "Über mich"
        },
        en: {
            title: "Legal Notice",
            link: "Legal Notice & Data Processing",
            text1: "This website is operated by:",
            text2: "Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Germany",
            text3: "Contact:",
            text3b: "Responsible for content according to § 18 para. 2 German Interstate Media Treaty (MStV).",
            subtitle: "Data Processing",
            text4: "This website uses no cookies, no log files, and no tracking tools. Only your color scheme preference is stored locally in your browser.",
            text5: "When using the contact form, your name, email address, and message are transmitted via email. Your IP address is temporarily processed for spam protection but not stored.",
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
            footerEntity: 'Oliver Eichhof, Communication Specialist from Hamburg',
            githubTooltip: "View source on GitHub",
            githubAriaLabel: "View source on GitHub",
            // Contact form
            contactTitle: "Contact",
            contactName: "Your name",
            contactEmail: "Your email address",
            contactMessage: "Your message",
            contactSubmit: "Send message",
            contactSending: "Sending...",
            contactSuccess: "Thank you! Your message has been sent.",
            contactErrorGeneral: "An error occurred. Please try again later.",
            contactErrorName: "Please enter your name (at least 2 characters).",
            contactErrorEmail: "Please enter a valid email address.",
            contactErrorMessage: "Please enter a message (at least 10 characters).",
            contactErrorRateLimit: "Too many requests. Please wait a few minutes.",
            contactPrivacy: "Your data will only be used to respond. Your IP is temporarily processed for spam protection but not stored.",
            contactFallback: "Or email directly:",
            // About overlay
            aboutTitle: "Oliver Eichhof",
            aboutSummary: "Oliver Eichhof is a communication specialist from Hamburg, Germany. He works as Head of Marketing at REGIOCAST and has over 15 years of experience in digital brand management, campaign development and B2B communication.",
            aboutFactsTitle: "Key Facts",
            aboutDtRole: "Employer",
            aboutDdRole: '<a href="https://www.regiocast.de/" target="_blank" rel="noopener noreferrer">REGIOCAST GmbH & Co. KG</a>',
            aboutDtLocation: "Location",
            aboutDdLocation: "Hamburg, Germany",
            aboutDtBorn: "Born",
            aboutDdBorn: "1979 in Bremerhaven, Germany",
            aboutDtLanguages: "Languages",
            aboutDdLanguages: "German (native), English (fluent), Danish (beginner)",
            aboutCareerTitle: "Career",
            aboutEducationTitle: "Education",
            aboutEdu1: "Digital Media Studies",
            aboutEdu2: "University Entrance Qualification",
            aboutEdu3: "IT Specialist",
            aboutEdu4: "Retail Sales Specialist",
            aboutSkillsTitle: "Core Competencies",
            aboutSkills: "Brand management, employer branding, communication strategy, digital campaign development, journey design, KPI frameworks, GEO/SEO/SEA, marketing automation, AI-powered workflows, stakeholder management, content strategy, B2B/B2C communication.",
            aboutProjectsTitle: "Projects",
            aboutProjectBlog: "— personal blog",
            aboutProjectCode: "— open source projects",
            aboutProfilesTitle: "Profiles",
            aboutMentionsTitle: "Mentions",
            aboutTriggerLabel: "About me"
        },
        da: {
            title: "Kolofon",
            link: "Kolofon & Databehandling",
            text1: "Denne hjemmeside drives af:",
            text2: "Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Tyskland",
            text3: "Kontakt:",
            text3b: "Ansvarlig for indhold i henhold til § 18 stk. 2 tysk statslig medieaftale (MStV).",
            subtitle: "Databehandling",
            text4: "Denne hjemmeside bruger ingen cookies, ingen logfiler og ingen sporingsværktøjer. Kun din farvevalg-præference gemmes lokalt i din browser.",
            text5: "Ved brug af kontaktformularen sendes dit navn, din e-mailadresse og din besked via e-mail. Din IP-adresse behandles midlertidigt til spam-beskyttelse, men gemmes ikke.",
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
            footerEntity: 'Oliver Eichhof, Kommunikationsspecialist fra Hamborg',
            githubTooltip: "Se kildekoden på GitHub",
            githubAriaLabel: "Se kildekoden på GitHub",
            // Kontaktformular
            contactTitle: "Kontakt",
            contactName: "Dit navn",
            contactEmail: "Din e-mailadresse",
            contactMessage: "Din besked",
            contactSubmit: "Send besked",
            contactSending: "Sender...",
            contactSuccess: "Tak! Din besked er blevet sendt.",
            contactErrorGeneral: "Der opstod en fejl. Prøv venligst igen senere.",
            contactErrorName: "Indtast venligst dit navn (mindst 2 tegn).",
            contactErrorEmail: "Indtast venligst en gyldig e-mailadresse.",
            contactErrorMessage: "Indtast venligst en besked (mindst 10 tegn).",
            contactErrorRateLimit: "For mange anmodninger. Vent venligst et par minutter.",
            contactPrivacy: "Dine data bruges kun til at besvare. Din IP behandles midlertidigt til spam-beskyttelse, men gemmes ikke.",
            contactFallback: "Eller send e-mail direkte:",
            // About overlay
            aboutTitle: "Oliver Eichhof",
            aboutSummary: "Oliver Eichhof er en kommunikationsspecialist fra Hamborg, Tyskland. Han arbejder som marketingchef hos REGIOCAST og har over 15 års erfaring inden for digital brandledelse, kampagneudvikling og B2B-kommunikation.",
            aboutFactsTitle: "Nøglefakta",
            aboutDtRole: "Arbejdsgiver",
            aboutDdRole: '<a href="https://www.regiocast.de/" target="_blank" rel="noopener noreferrer">REGIOCAST GmbH & Co. KG</a>',
            aboutDtLocation: "Placering",
            aboutDdLocation: "Hamborg, Tyskland",
            aboutDtBorn: "Født",
            aboutDdBorn: "1979 i Bremerhaven, Tyskland",
            aboutDtLanguages: "Sprog",
            aboutDdLanguages: "Tysk (modersmål), Engelsk (flydende), Dansk (begynder)",
            aboutCareerTitle: "Karriere",
            aboutEducationTitle: "Uddannelse",
            aboutEdu1: "Studium i digitale medier",
            aboutEdu2: "Højere forberedelseseksamen",
            aboutEdu3: "IT-specialist",
            aboutEdu4: "Detailhandelsspecialist",
            aboutSkillsTitle: "Kernekompetencer",
            aboutSkills: "Brandledelse, employer branding, kommunikationsstrategi, digital kampagneudvikling, journey design, KPI-frameworks, GEO/SEO/SEA, marketing automation, AI-drevne workflows, stakeholder management, content-strategi, B2B/B2C-kommunikation.",
            aboutProjectsTitle: "Projekter",
            aboutProjectBlog: "— personlig blog",
            aboutProjectCode: "— open source-projekter",
            aboutProfilesTitle: "Profiler",
            aboutMentionsTitle: "Omtaler",
            aboutTriggerLabel: "Om mig"
        }
    };

    // Current state
    let currentLang = 'de';
    let currentEmailPrefix = 'hallo';

    /**
     * Detect language from server, URL parameter, or browser settings
     * Priority: Server-set lang > URL param > Browser language > Default (German)
     * @returns {string} Language code (de, en, or da)
     */
    function detectLanguage() {
        // Check if server already detected language (from /en/ or /da/ path)
        const serverLang = document.body.dataset.lang;
        if (serverLang && ['de', 'en', 'da'].includes(serverLang)) {
            return serverLang;
        }

        // Check URL parameter (legacy support for ?lang=xx)
        const urlParams = new URLSearchParams(window.location.search);
        const urlLang = urlParams.get('lang');
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
        updateElement('footer-entity-desktop', content.footerEntity);
        updateElement('footer-entity-mobile', content.footerEntity);
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

        // Update contact form content
        updateElement('contact-title', content.contactTitle);
        updateAttr('contact-name', 'placeholder', content.contactName);
        updateAttr('contact-email', 'placeholder', content.contactEmail);
        updateAttr('contact-message', 'placeholder', content.contactMessage);
        updateElement('contact-submit-text', content.contactSubmit);
        updateElement('contact-privacy', content.contactPrivacy);
        updateElement('contact-fallback-text', content.contactFallback);
        updateAttr('close-contact-btn', 'aria-label', content.closeOverlay);

        // Update contact email fallback link
        const contactFallbackEmail = buildEmail(content.emailPrefix);
        const contactEmailLink = document.getElementById('contact-fallback-link');
        if (contactEmailLink) {
            contactEmailLink.textContent = contactFallbackEmail;
            contactEmailLink.href = 'mailto:' + contactFallbackEmail;
        }

        // Update about overlay content
        updateElement('about-title', content.aboutTitle);
        updateElement('about-summary', content.aboutSummary);
        updateElement('about-facts-title', content.aboutFactsTitle);
        updateElement('about-dt-role', content.aboutDtRole);
        updateElement('about-dd-role', content.aboutDdRole, true);
        updateElement('about-dt-location', content.aboutDtLocation);
        updateElement('about-dd-location', content.aboutDdLocation);
        updateElement('about-dt-born', content.aboutDtBorn);
        updateElement('about-dd-born', content.aboutDdBorn);
        updateElement('about-dt-languages', content.aboutDtLanguages);
        updateElement('about-dd-languages', content.aboutDdLanguages);
        updateElement('about-career-title', content.aboutCareerTitle);
        updateElement('about-education-title', content.aboutEducationTitle);
        updateElement('about-edu-1-title', content.aboutEdu1);
        updateElement('about-edu-2-title', content.aboutEdu2);
        updateElement('about-edu-3-title', content.aboutEdu3);
        updateElement('about-edu-4-title', content.aboutEdu4);
        updateElement('about-skills-title', content.aboutSkillsTitle);
        updateElement('about-skills', content.aboutSkills);
        updateElement('about-projects-title', content.aboutProjectsTitle);
        updateElement('about-project-blog', content.aboutProjectBlog);
        updateElement('about-project-code', content.aboutProjectCode);
        updateElement('about-profiles-title', content.aboutProfilesTitle);
        updateElement('about-mentions-title', content.aboutMentionsTitle);
        updateAttr('about-trigger-card', 'aria-label', content.aboutTriggerLabel);
        updateAttr('close-about-btn', 'aria-label', content.closeOverlay);
    }

    /**
     * Open overlay if server requested it (from /impressum, /kontakt etc.)
     */
    function handleServerOverlay() {
        const openOverlay = document.body.dataset.overlay;
        if (!openOverlay) return;

        // Small delay to ensure overlay.js has initialized
        setTimeout(function() {
            if (openOverlay === 'impressum') {
                const overlay = document.getElementById('overlay');
                if (overlay) overlay.classList.add('active');
            } else if (openOverlay === 'contact') {
                const contactOverlay = document.getElementById('contact-overlay');
                if (contactOverlay) contactOverlay.classList.add('active');
            } else if (openOverlay === 'about') {
                const aboutOverlay = document.getElementById('about-overlay');
                if (aboutOverlay) aboutOverlay.classList.add('active');
            }
        }, 100);
    }

    /**
     * Initialize language module
     */
    function init() {
        applyLanguage();
        handleServerOverlay();

        // Note: Email link click handler is now in contact.js
        // which opens the contact form popup instead of mailto
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
