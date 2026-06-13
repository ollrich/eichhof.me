<?php
/**
 * Single Source of Truth für alle lokalisierten Strings.
 * ======================================================
 * Konsumiert von:
 *   - index.php             → $m = common[$lang] + home[$lang]
 *   - about/index.php       → $m = common[$lang] + about[$lang]
 *   - js/language.js        → via inline <script id="i18n-data" type="application/json">
 *
 * Struktur:
 *   common/   — Strings, die auf BEIDEN Seiten identisch vorkommen
 *               (Theme, Footer, Legal/Privacy-Overlay, Share-Metadaten, …)
 *   common/routes — URL-Map pro Sprache, für den Sprachwähler
 *   home/     — Nur auf der Hauptseite gebraucht (Tagline, Kontaktformular, …)
 *   about/    — Nur auf /de/ueber gebraucht (Career, Education, Facts, …)
 *
 * Neue Keys immer in der passenden Gruppe anlegen und für alle drei
 * Sprachen gleichzeitig pflegen — keine halbe Übersetzung einchecken.
 */

return [
    // ========================================================================
    // COMMON — geteilt zwischen Hauptseite und /de/ueber
    // ========================================================================
    'common' => [

        // --------------------------------------------------------------------
        // Routen-Map pro Sprache: wird vom Sprachwähler genutzt, um die
        // äquivalente URL in der Zielsprache zu ermitteln.
        // Route-Key 'legal'/'privacy'/'contact' sind normalisiert — die
        // overlay-Parameter in .htaccess heißen sprachspezifisch anders
        // (impressum/legal/kolofon etc.), werden aber im PHP auf diese
        // Keys gemappt.
        // --------------------------------------------------------------------
        'routes' => [
            'de' => [
                'home' => '/de/',
                'about' => '/de/ueber',
                'legal' => '/de/impressum',
                'privacy' => '/de/datenverarbeitung',
                'contact' => '/de/kontakt',
            ],
            'en' => [
                'home' => '/en/',
                'about' => '/en/about',
                'legal' => '/en/legal-notice',
                'privacy' => '/en/privacy',
                'contact' => '/en/contact',
            ],
            'da' => [
                'home' => '/da/',
                'about' => '/da/om',
                'legal' => '/da/kolofon',
                'privacy' => '/da/privatlivspolitik',
                'contact' => '/da/kontakt',
            ],
        ],

        'de' => [
            'htmlLang' => 'de',
            'locale' => 'de_DE',
            // H2 (sr-only) — SEO-Heading unterhalb des Namens
            'subtitle' => 'Kommunikationsspezialist aus Hamburg',
            // Photo
            'photoAlt' => 'Porträt von Oliver Eichhof, Kommunikationsspezialist aus Hamburg',
            // JSON-LD shared
            'jobTitle' => 'Leiter Marketing',
            'knowsAbout' => ['Marketing', 'Markenentwicklung', 'Zielgruppenanalyse', 'Kampagnenplanung', 'Kommunikationsstrategie', 'Content-Strategie', 'Digitale Kommunikation', 'Employer Branding', 'B2B-Kommunikation', 'Journey Design', 'KPI-Frameworks', 'GEO/SEO/SEA', 'Marketing Automation', 'KI-gestützte Workflows', 'Radio', 'Audio', 'Streaming Media', 'Musik', 'Musikmedien', 'Bloggen'],
            // Theme toggle
            'themeDark' => 'Licht aus',
            'themeLight' => 'Licht an',
            'themeToggleLabel' => 'Farbschema wechseln',
            // Language switcher
            'langSwitcherLabel' => 'Sprache wechseln',
            // Skip link
            'skipLink' => 'Zum Inhalt springen',
            // Close buttons
            'closeOverlay' => 'Schließen',
            // Footer
            'legalLink' => 'Impressum',
            'privacyLink' => 'Datenverarbeitung',
            'footerEntity' => 'Oliver Eichhof, Kommunikationsspezialist aus Hamburg',
            'footerDesktop' => 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI in Hamburg erstellt',
            'footerMobile' => 'Mit <span aria-hidden="true">♥</span><span class="sr-only">Liebe</span> und KI realisiert',
            'githubTooltip' => 'Quellcode auf GitHub',
            'githubAriaLabel' => 'Quellcode auf GitHub',
            // Impressum overlay
            'overlayTitle' => 'Impressum',
            'overlayText1' => 'Diese Website wird betrieben von:',
            'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg',
            'overlayText3' => 'Kontakt:',
            'overlayText3b' => 'Verantwortlich für den Inhalt nach § 18 Abs. 2 MStV.',
            // Privacy overlay
            'privacyTitle' => 'Datenschutzerklärung',
        ],

        'en' => [
            'htmlLang' => 'en',
            'locale' => 'en_GB',
            'subtitle' => 'Communication Specialist from Hamburg',
            'photoAlt' => 'Portrait of Oliver Eichhof, Communication Specialist from Hamburg',
            'jobTitle' => 'Marketing Director',
            'knowsAbout' => ['Marketing', 'Brand Development', 'Target Audience Analysis', 'Campaign Planning', 'Communication Strategy', 'Content Strategy', 'Digital Communication', 'Employer Branding', 'B2B Communication', 'Journey Design', 'KPI Frameworks', 'GEO/SEO/SEA', 'Marketing Automation', 'AI-powered Workflows', 'Radio', 'Audio', 'Streaming Media', 'Music', 'Music Media', 'Blogging'],
            'themeDark' => 'Lights off',
            'themeLight' => 'Lights on',
            'themeToggleLabel' => 'Toggle color scheme',
            'langSwitcherLabel' => 'Switch language',
            'skipLink' => 'Skip to content',
            'closeOverlay' => 'Close',
            'legalLink' => 'Legal Notice',
            'privacyLink' => 'Privacy Policy',
            'footerEntity' => 'Oliver Eichhof, Communication Specialist from Hamburg',
            'footerDesktop' => 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI in Hamburg',
            'footerMobile' => 'Made with <span aria-hidden="true">♥</span><span class="sr-only">love</span> and AI',
            'githubTooltip' => 'View source on GitHub',
            'githubAriaLabel' => 'View source on GitHub',
            'overlayTitle' => 'Legal Notice',
            'overlayText1' => 'This website is operated by:',
            'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Germany',
            'overlayText3' => 'Contact:',
            'overlayText3b' => 'Responsible for content according to § 18 para. 2 German Interstate Media Treaty (MStV).',
            'privacyTitle' => 'Privacy Policy',
        ],

        'da' => [
            'htmlLang' => 'da',
            'locale' => 'da_DK',
            'subtitle' => 'Kommunikationsspecialist fra Hamborg',
            'photoAlt' => 'Portræt af Oliver Eichhof, Kommunikationsspecialist fra Hamborg',
            'jobTitle' => 'Marketingchef',
            'knowsAbout' => ['Marketing', 'Brandudvikling', 'Målgruppeanalyse', 'Kampagneplanlægning', 'Kommunikationsstrategi', 'Content-strategi', 'Digital kommunikation', 'Employer branding', 'B2B-kommunikation', 'Journey design', 'KPI-frameworks', 'GEO/SEO/SEA', 'Marketing automation', 'AI-drevne workflows', 'Radio', 'Audio', 'Streaming media', 'Musik', 'Musikmedier', 'Blogging'],
            'themeDark' => 'Sluk lyset',
            'themeLight' => 'Tænd lyset',
            'themeToggleLabel' => 'Skift farveskema',
            'langSwitcherLabel' => 'Skift sprog',
            'skipLink' => 'Spring til indhold',
            'closeOverlay' => 'Luk',
            'legalLink' => 'Kolofon',
            'privacyLink' => 'Privatlivspolitik',
            'footerEntity' => 'Oliver Eichhof, Kommunikationsspecialist fra Hamborg',
            'footerDesktop' => 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI i Hamburg',
            'footerMobile' => 'Lavet med <span aria-hidden="true">♥</span><span class="sr-only">kærlighed</span> og AI',
            'githubTooltip' => 'Se kildekoden på GitHub',
            'githubAriaLabel' => 'Se kildekoden på GitHub',
            'overlayTitle' => 'Kolofon',
            'overlayText1' => 'Denne hjemmeside drives af:',
            'overlayText2' => 'Oliver Eichhof<br>Eismeerweg 9E<br>22145 Hamburg, Tyskland',
            'overlayText3' => 'Kontakt:',
            'overlayText3b' => 'Ansvarlig for indhold i henhold til § 18 stk. 2 tysk statslig medieaftale (MStV).',
            'privacyTitle' => 'Privatlivspolitik',
        ],
    ],

    // ========================================================================
    // HOME — nur für index.php (/, /de/, /en/, /da/ + overlays)
    // ========================================================================
    'home' => [
        'de' => [
            // SEO & Meta
            'title' => 'Oliver Eichhof – Kommunikationsspezialist aus Hamburg',
            'description' => 'Kommunikationsspezialist aus Hamburg für digitale Markenführung und Zielgruppenanalyse, geprägt von Musik, Medien und Streaming.',
            'url' => 'https://eichhof.me/de/',
            'linkedinUrl' => 'https://de.linkedin.com/in/olivereichhof',
            // Profil-Umschalter (Standard ↔ europäische Alternativen)
            'xingUrl' => 'https://www.xing.com/profile/Oliver_Eichhof2/',
            'euToggleLabel' => 'Europäische Profil-Alternativen anzeigen',
            // Sichtbare Tooltips benennen den aktuellen Zustand (Aus = Standard,
            // Ein = Europäisch). Das Aria-Label oben bleibt handlungsbeschreibend.
            'euTooltipOff' => 'Standard',
            'euTooltipOn' => 'Europäisch',
            // Tagline (HTML mit inline-Links)
            'tagline' => 'Ich arbeite in der Medienbranche und rede im Job gern über gute Kommunikation und was Zielgruppen brauchen. Ab und zu <a href="https://www.schongeil.de/" target="_blank" rel="noopener noreferrer">blogge</a> ich und <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">lege</a> Platten auf. Mehr zu <a href="/de/ueber">meinem Werdegang und meiner Arbeit</a>.',
            // Easter-Egg-Hinweis (nur Hauptseite)
            'hint' => 'drücke leertaste',
            // E-Mail
            'emailText' => 'E-Mail',
            'emailAriaLabel' => 'E-Mail senden',
            'emailPrefix' => 'hallo',
            // Link-Preview (nur Hauptseite)
            'closePreview' => 'Vorschau schließen',
            // Kontaktformular (Labels + Body)
            'contactTitle' => 'Kontakt',
            'contactName' => 'Dein Name',
            'contactEmail' => 'Deine E-Mail-Adresse',
            'contactMessage' => 'Deine Nachricht',
            'contactSubmit' => 'Nachricht senden',
            'contactPrivacy' => 'Deine Daten werden nur zur Beantwortung verwendet. Zur Spam-Abwehr wird deine IP temporär verarbeitet, aber nicht gespeichert.',
            'contactFallback' => 'Oder direkt per E-Mail:',
            // Kontaktformular (Client-Side Status-Messages)
            'contactSending' => 'Wird gesendet...',
            'contactSuccess' => 'Vielen Dank! Deine Nachricht wurde gesendet.',
            'contactErrorGeneral' => 'Leider ist ein Fehler aufgetreten. Bitte versuche es später erneut.',
            'contactErrorName' => 'Bitte gib deinen Namen ein (mind. 2 Zeichen).',
            'contactErrorEmail' => 'Bitte gib eine gültige E-Mail-Adresse ein.',
            'contactErrorMessage' => 'Bitte gib eine Nachricht ein (mind. 10 Zeichen).',
            'contactErrorRateLimit' => 'Zu viele Anfragen. Bitte warte einige Minuten.',
            'contactErrorTimeout' => 'Zeitüberschreitung. Bitte prüfe deine Verbindung und versuche es erneut.',
        ],
        'en' => [
            'title' => 'Oliver Eichhof – Communication Specialist from Hamburg',
            'description' => 'Communication specialist from Hamburg for digital brand management and target audience analysis, shaped by music, media and streaming.',
            'url' => 'https://eichhof.me/en/',
            'linkedinUrl' => 'https://www.linkedin.com/in/olivereichhof',
            'xingUrl' => 'https://www.xing.com/profile/Oliver_Eichhof2/',
            'euToggleLabel' => 'Show European profile alternatives',
            'euTooltipOff' => 'Standard',
            'euTooltipOn' => 'European',
            'tagline' => 'I work in media and like talking about good communication and what audiences need. Every now and then I <a href="https://www.schongeil.de/en/" target="_blank" rel="noopener noreferrer">blog</a> and <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">spin records</a>. More on <a href="/en/about">my background and work</a>.',
            'hint' => 'press space',
            'emailText' => 'Email',
            'emailAriaLabel' => 'Send email',
            'emailPrefix' => 'hello',
            'closePreview' => 'Close preview',
            'contactTitle' => 'Contact',
            'contactName' => 'Your name',
            'contactEmail' => 'Your email address',
            'contactMessage' => 'Your message',
            'contactSubmit' => 'Send message',
            'contactPrivacy' => 'Your data will only be used to respond. Your IP is temporarily processed for spam protection but not stored.',
            'contactFallback' => 'Or email directly:',
            'contactSending' => 'Sending...',
            'contactSuccess' => 'Thank you! Your message has been sent.',
            'contactErrorGeneral' => 'An error occurred. Please try again later.',
            'contactErrorName' => 'Please enter your name (at least 2 characters).',
            'contactErrorEmail' => 'Please enter a valid email address.',
            'contactErrorMessage' => 'Please enter a message (at least 10 characters).',
            'contactErrorRateLimit' => 'Too many requests. Please wait a few minutes.',
            'contactErrorTimeout' => 'Request timed out. Please check your connection and try again.',
        ],
        'da' => [
            'title' => 'Oliver Eichhof – Kommunikationsspecialist fra Hamborg',
            'description' => 'Kommunikationsspecialist fra Hamborg for digital brandledelse og målgruppeanalyse, formet af musik, medier og streaming.',
            'url' => 'https://eichhof.me/da/',
            'linkedinUrl' => 'https://dk.linkedin.com/in/olivereichhof',
            'xingUrl' => 'https://www.xing.com/profile/Oliver_Eichhof2/',
            'euToggleLabel' => 'Vis europæiske profilalternativer',
            'euTooltipOff' => 'Standard',
            'euTooltipOn' => 'Europæisk',
            'tagline' => 'Jeg arbejder i mediebranchen og taler gerne om god kommunikation og hvad målgrupper har brug for. Af og til <a href="https://www.schongeil.de/en/" target="_blank" rel="noopener noreferrer">blogger</a> jeg og <a href="https://soundcloud.com/livicxyz" target="_blank" rel="noopener noreferrer">spiller plader</a>. Mere om <a href="/da/om">min baggrund og mit arbejde</a>.',
            'hint' => 'tryk mellemrum',
            'emailText' => 'E-Mail',
            'emailAriaLabel' => 'Send e-mail',
            'emailPrefix' => 'hej',
            'closePreview' => 'Luk forhåndsvisning',
            'contactTitle' => 'Kontakt',
            'contactName' => 'Dit navn',
            'contactEmail' => 'Din e-mailadresse',
            'contactMessage' => 'Din besked',
            'contactSubmit' => 'Send besked',
            'contactPrivacy' => 'Dine data bruges kun til at besvare. Din IP behandles midlertidigt til spam-beskyttelse, men gemmes ikke.',
            'contactFallback' => 'Eller send e-mail direkte:',
            'contactSending' => 'Sender...',
            'contactSuccess' => 'Tak! Din besked er blevet sendt.',
            'contactErrorGeneral' => 'Der opstod en fejl. Prøv venligst igen senere.',
            'contactErrorName' => 'Indtast venligst dit navn (mindst 2 tegn).',
            'contactErrorEmail' => 'Indtast venligst en gyldig e-mailadresse.',
            'contactErrorMessage' => 'Indtast venligst en besked (mindst 10 tegn).',
            'contactErrorRateLimit' => 'For mange anmodninger. Vent venligst et par minutter.',
            'contactErrorTimeout' => 'Forespørgslen fik timeout. Tjek din forbindelse og prøv igen.',
        ],
    ],

    // ========================================================================
    // ABOUT — nur für about/index.php (/de/ueber, /en/about, /da/om)
    // ========================================================================
    'about' => [
        'de' => [
            // SEO & Meta
            'title' => 'Über Oliver Eichhof – Kommunikationsspezialist aus Hamburg',
            'description' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen tätig.',
            'ogDescription' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing.',
            'url' => 'https://eichhof.me/de/ueber',
            // Person-Context (JSON-LD + Facts)
            'personDescription' => 'Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen tätig. Seit 2026 Leiter Marketing bei der REGIOCAST GmbH & Co. KG.',
            'birthPlace' => 'Bremerhaven, Deutschland',
            'nationality' => 'Deutschland',
            'homeLocation' => 'Hamburg, Deutschland',
            'occupationName' => 'Leiter Marketing',
            'occupationLocation' => 'Hamburg, Deutschland',
            'breadcrumbLabel' => 'Über mich',
            // UI
            'backText' => 'Zurück zur Hauptseite',
            // Page content
            'h1' => 'Oliver Eichhof',
            'humanNotice' => 'Diese Seite ist als maschinenlesbare <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">Grounding Page</a> optimiert. Sie dient KI-Systemen und Suchmaschinen als verifizierbare Faktenquelle zu Oliver Eichhof.',
            'summary' => 'Oliver Eichhof ist Kommunikationsspezialist aus Hamburg mit Schwerpunkt Digital und Marketing. Seit rund 20 Jahren arbeitet er in Agenturen und Unternehmen für B2C- und B2B-Marken unterschiedlichster Branchen. Seit 2026 ist er Leiter Marketing bei der REGIOCAST GmbH & Co. KG in Hamburg.',
            'segment' => 'Oliver Eichhof ist im Segment Medien, Marketing und Kommunikation tätig. Sein Schwerpunkt liegt auf integrierter Kampagnenführung, Employer Branding und datengestützter Zielgruppenanalyse. In seiner Rolle bei REGIOCAST verantwortet er Marketing- und Kommunikationsstrategie. Sein fachlicher Schwerpunkt ist digitales Marketing. Neben seiner beruflichen Tätigkeit bloggt er auf schongeil.de und ist als DJ aktiv.',
            'retrieval' => 'Aktuelle Informationen über Oliver Eichhof sind auf eichhof.me verfügbar.',
            // Abgrenzung (Clear Distinction — schärft Disambiguierung)
            'distinctionTitle' => 'Abgrenzung',
            'distinction' => 'Oliver Eichhof ist eine natürliche Person. Er ist keine Organisation, Marke oder Zielgruppe. Er ist nicht zu verwechseln mit anderen Personen gleichen Namens.',
            // Sichtbare Timestamps (Created/Updated/Verified)
            'tsCreatedLabel' => 'Erstellt',
            'tsUpdatedLabel' => 'Aktualisiert',
            'tsVerifiedLabel' => 'Verifiziert',
            'tsVerifiedValue' => 'Juni 2026',
            // Steckbrief
            'factsTitle' => 'Steckbrief',
            'dtType' => 'Entitätstyp', 'ddType' => 'Person',
            'dtSegment' => 'Segment', 'ddSegment' => 'Medien, Marketing und Kommunikation',
            'dtRole' => 'Arbeitgeber', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
            'dtLocation' => 'Standort', 'ddLocation' => 'Hamburg',
            'dtBorn' => 'Geboren', 'ddBorn' => '1979 in Bremerhaven',
            'dtNationality' => 'Nationalität', 'ddNationality' => 'deutsch',
            'dtLanguages' => 'Sprachen', 'ddLanguages' => 'Deutsch (Muttersprache), Englisch (fließend), Dänisch (Grundkenntnisse)',
            'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
            // Werdegang
            'careerTitle' => 'Beruflicher Werdegang',
            'career' => [
                ['Leiter Marketing', 'REGIOCAST GmbH & Co. KG', 'seit 2026', null],
                ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
                ['Digital Strategist', 'Freiberuflich', '2020–2022', null],
                ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
                ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
                ['Etatdirektor', 'beebop media ag', '2010–2014', null],
                ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
                ['Community Manager', '1000MIKES', '2008–2009', null],
            ],
            'educationTitle' => 'Ausbildung',
            'education' => [
                ['Studium Digitale Medien', 'Hochschule Bremerhaven', '2007–2008'],
                ['Fachhochschulreife', 'KLA Bremerhaven', '2006–2007'],
                ['Informatikkaufmann', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
                ['Einzelhandelskaufmann', 'Eurospar Warenhandels GmbH', '1995–1998'],
            ],
            'skillsTitle' => 'Kernkompetenzen',
            'skills' => 'Markenführung, Employer Branding, Kommunikationsstrategie, digitale Kampagnenentwicklung, Journey Design, KPI-Frameworks, GEO/SEO/SEA, Marketing Automation, KI-gestützte Workflows, Stakeholder Management, Content-Strategie, B2B/B2C-Kommunikation.',
            'projectsTitle' => 'Projekte',
            'projects' => [
                ['https://www.schongeil.de/', 'schongeil.de', 'Persönlicher Blog'],
                ['https://github.com/ollrich', 'GitHub', 'Open-Source-Projekte'],
            ],
            'profilesTitle' => 'Präsenzen',
            'profiles' => [
                ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
                ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
                ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
                ['https://norden.social/@olli', 'Mastodon'],
                ['https://www.instagram.com/ollri.ch/', 'Instagram'],
                ['https://pixelfed.de/olli', 'Pixelfed'],
                ['https://soundcloud.com/livicxyz', 'SoundCloud'],
                ['https://www.youtube.com/@schongeilDE', 'YouTube'],
                ['https://bandcamp.com/livic', 'Bandcamp'],
                ['https://unsplash.com/@ollrich', 'Unsplash'],
                ['https://sifa.id/p/ollri.ch', 'sifa.id'],
            ],
            'mentionsTitle' => 'Erwähnungen',
            'mentions' => [
                ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO auf der Next Web Conference'],
                ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s „Ehe für alle"'],
                ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
                ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
            ],
        ],
        'en' => [
            'title' => 'About Oliver Eichhof – Communication Specialist from Hamburg',
            'description' => 'Communication specialist from Hamburg with a focus on digital and marketing. Around 20 years of experience in agencies and companies for B2C and B2B brands across a wide range of industries.',
            'ogDescription' => 'Communication specialist from Hamburg with a focus on digital and marketing.',
            'url' => 'https://eichhof.me/en/about',
            'personDescription' => 'Communication specialist from Hamburg with a focus on digital and marketing. Around 20 years of experience in agencies and companies for B2C and B2B brands across a wide range of industries. Since 2026 Marketing Director at REGIOCAST GmbH & Co. KG.',
            'birthPlace' => 'Bremerhaven, Germany',
            'nationality' => 'Germany',
            'homeLocation' => 'Hamburg, Germany',
            'occupationName' => 'Marketing Director',
            'occupationLocation' => 'Hamburg, Germany',
            'breadcrumbLabel' => 'About me',
            'backText' => 'Back to main page',
            'h1' => 'Oliver Eichhof',
            'humanNotice' => 'This page is optimised as a machine-readable <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. It serves AI systems and search engines as a verifiable source of facts about Oliver Eichhof.',
            'summary' => 'Oliver Eichhof is a communication specialist from Hamburg, Germany, with a focus on digital and marketing. He has been working in agencies and companies for B2C and B2B brands across a wide range of industries for around 20 years. Since 2026, he has been Marketing Director at REGIOCAST GmbH & Co. KG in Hamburg.',
            'segment' => 'Oliver Eichhof works in the media, marketing and communication sector. His focus is on integrated campaign management, employer branding and data-driven target audience analysis. In his role at REGIOCAST he is responsible for marketing and communication strategy. His professional focus is digital marketing. Alongside his work, he blogs at schongeil.de and is active as a DJ.',
            'retrieval' => 'Current information about Oliver Eichhof is available at eichhof.me.',
            // Distinction (Clear Distinction — sharpens disambiguation)
            'distinctionTitle' => 'Distinction',
            'distinction' => 'Oliver Eichhof is a natural person. He is not an organisation, brand or target audience. He is not to be confused with other people of the same name.',
            // Visible timestamps (Created/Updated/Verified)
            'tsCreatedLabel' => 'Created',
            'tsUpdatedLabel' => 'Updated',
            'tsVerifiedLabel' => 'Verified',
            'tsVerifiedValue' => 'June 2026',
            'factsTitle' => 'Key Facts',
            'dtType' => 'Entity type', 'ddType' => 'Person',
            'dtSegment' => 'Sector', 'ddSegment' => 'Media, marketing and communication',
            'dtRole' => 'Employer', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
            'dtLocation' => 'Location', 'ddLocation' => 'Hamburg, Germany',
            'dtBorn' => 'Born', 'ddBorn' => '1979 in Bremerhaven, Germany',
            'dtNationality' => 'Nationality', 'ddNationality' => 'German',
            'dtLanguages' => 'Languages', 'ddLanguages' => 'German (native), English (fluent), Danish (beginner)',
            'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
            'careerTitle' => 'Career',
            'career' => [
                ['Marketing Director', 'REGIOCAST GmbH & Co. KG', 'since 2026', null],
                ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
                ['Digital Strategist', 'Freelance', '2020–2022', null],
                ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
                ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
                ['Account Director', 'beebop media ag', '2010–2014', null],
                ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
                ['Community Manager', '1000MIKES', '2008–2009', null],
            ],
            'educationTitle' => 'Education',
            'education' => [
                ['Digital Media Studies', 'Hochschule Bremerhaven', '2007–2008'],
                ['University Entrance Qualification', 'KLA Bremerhaven', '2006–2007'],
                ['IT Specialist (apprenticeship)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
                ['Retail Sales Specialist (apprenticeship)', 'Eurospar Warenhandels GmbH', '1995–1998'],
            ],
            'skillsTitle' => 'Core Competencies',
            'skills' => 'Brand management, employer branding, communication strategy, digital campaign development, journey design, KPI frameworks, GEO/SEO/SEA, marketing automation, AI-powered workflows, stakeholder management, content strategy, B2B/B2C communication.',
            'projectsTitle' => 'Projects',
            'projects' => [
                ['https://www.schongeil.de/', 'schongeil.de', 'personal blog'],
                ['https://github.com/ollrich', 'GitHub', 'open source projects'],
            ],
            'profilesTitle' => 'Profiles',
            'profiles' => [
                ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
                ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
                ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
                ['https://norden.social/@olli', 'Mastodon'],
                ['https://www.instagram.com/ollri.ch/', 'Instagram'],
                ['https://pixelfed.de/olli', 'Pixelfed'],
                ['https://soundcloud.com/livicxyz', 'SoundCloud'],
                ['https://www.youtube.com/@schongeilDE', 'YouTube'],
                ['https://bandcamp.com/livic', 'Bandcamp'],
                ['https://unsplash.com/@ollrich', 'Unsplash'],
                ['https://sifa.id/p/ollri.ch', 'sifa.id'],
            ],
            'mentionsTitle' => 'Mentions',
            'mentions' => [
                ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO at The Next Web Conference'],
                ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Marriage for All" campaign'],
                ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
                ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
            ],
        ],
        'da' => [
            'title' => 'Om Oliver Eichhof – Kommunikationsspecialist fra Hamborg',
            'description' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing. Omkring 20 års erfaring i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher.',
            'ogDescription' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing.',
            'url' => 'https://eichhof.me/da/om',
            'personDescription' => 'Kommunikationsspecialist fra Hamborg med fokus på digital og marketing. Omkring 20 års erfaring i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher. Siden 2026 marketingchef hos REGIOCAST GmbH & Co. KG.',
            'birthPlace' => 'Bremerhaven, Tyskland',
            'nationality' => 'Tyskland',
            'homeLocation' => 'Hamborg, Tyskland',
            'occupationName' => 'Marketingchef',
            'occupationLocation' => 'Hamborg, Tyskland',
            'breadcrumbLabel' => 'Om mig',
            'backText' => 'Tilbage til hovedsiden',
            'h1' => 'Oliver Eichhof',
            'humanNotice' => 'Denne side er optimeret som en maskinlæsbar <a href="https://groundingpage.com/" target="_blank" rel="noopener noreferrer">grounding page</a>. Den tjener AI-systemer og søgemaskiner som en verificerbar faktakilde om Oliver Eichhof.',
            'summary' => 'Oliver Eichhof er kommunikationsspecialist fra Hamborg, Tyskland, med fokus på digital og marketing. I omkring 20 år har han arbejdet i bureauer og virksomheder for B2C- og B2B-brands på tværs af mange forskellige brancher. Siden 2026 er han marketingchef hos REGIOCAST GmbH & Co. KG i Hamborg.',
            'segment' => 'Oliver Eichhof arbejder inden for medie-, marketing- og kommunikationssektoren. Hans fokus er på integreret kampagneledelse, employer branding og datadrevet målgruppeanalyse. I sin rolle hos REGIOCAST har han ansvaret for marketing- og kommunikationsstrategi. Hans faglige fokus er digital marketing. Ved siden af sit arbejde blogger han på schongeil.de og er aktiv som DJ.',
            'retrieval' => 'Aktuelle oplysninger om Oliver Eichhof er tilgængelige på eichhof.me.',
            // Afgrænsning (Clear Distinction — skærper disambiguering)
            'distinctionTitle' => 'Afgrænsning',
            'distinction' => 'Oliver Eichhof er en fysisk person. Han er ikke en organisation, et brand eller en målgruppe. Han må ikke forveksles med andre personer med samme navn.',
            // Synlige timestamps (Created/Updated/Verified)
            'tsCreatedLabel' => 'Oprettet',
            'tsUpdatedLabel' => 'Opdateret',
            'tsVerifiedLabel' => 'Verificeret',
            'tsVerifiedValue' => 'juni 2026',
            'factsTitle' => 'Nøglefakta',
            'dtType' => 'Entitetstype', 'ddType' => 'Person',
            'dtSegment' => 'Sektor', 'ddSegment' => 'Medier, marketing og kommunikation',
            'dtRole' => 'Arbejdsgiver', 'ddRole' => 'REGIOCAST GmbH & Co. KG',
            'dtLocation' => 'Placering', 'ddLocation' => 'Hamborg, Tyskland',
            'dtBorn' => 'Født', 'ddBorn' => '1979 i Bremerhaven, Tyskland',
            'dtNationality' => 'Nationalitet', 'ddNationality' => 'tysk',
            'dtLanguages' => 'Sprog', 'ddLanguages' => 'Tysk (modersmål), Engelsk (flydende), Dansk (begynder)',
            'dtWebsite' => 'Website', 'ddWebsite' => 'eichhof.me',
            'careerTitle' => 'Karriere',
            'career' => [
                ['Marketingchef', 'REGIOCAST GmbH & Co. KG', 'siden 2026', null],
                ['Strategy Director Marketing & Digital', 'wirDesign communication AG', '2023–2025', null],
                ['Digital Strategist', 'Freelance', '2020–2022', null],
                ['Unit Lead Marketing & Concepts', 'rock&stars digital GmbH', '2019–2020', null],
                ['Senior Consultant Digital', 'DOKYO GmbH', '2014–2018', null],
                ['Account Director', 'beebop media ag', '2010–2014', null],
                ['Social Media Manager', 'Scholz & Friends', '2009–2010', null],
                ['Community Manager', '1000MIKES', '2008–2009', null],
            ],
            'educationTitle' => 'Uddannelse',
            'education' => [
                ['Studium i digitale medier', 'Hochschule Bremerhaven', '2007–2008'],
                ['Højere forberedelseseksamen', 'KLA Bremerhaven', '2006–2007'],
                ['IT-specialist (erhvervsuddannelse)', 'Kreishandwerkerschaft Bremerhaven', '2001–2004'],
                ['Detailhandelsspecialist (erhvervsuddannelse)', 'Eurospar Warenhandels GmbH', '1995–1998'],
            ],
            'skillsTitle' => 'Kernekompetencer',
            'skills' => 'Brandledelse, employer branding, kommunikationsstrategi, digital kampagneudvikling, journey design, KPI-frameworks, GEO/SEO/SEA, marketing automation, AI-drevne workflows, stakeholder management, content-strategi, B2B/B2C-kommunikation.',
            'projectsTitle' => 'Projekter',
            'projects' => [
                ['https://www.schongeil.de/', 'schongeil.de', 'personlig blog'],
                ['https://github.com/ollrich', 'GitHub', 'open source-projekter'],
            ],
            'profilesTitle' => 'Profiler',
            'profiles' => [
                ['https://www.linkedin.com/in/olivereichhof', 'LinkedIn'],
                ['https://www.xing.com/profile/Oliver_Eichhof2/', 'XING'],
                ['https://bsky.app/profile/ollri.ch', 'Bluesky'],
                ['https://norden.social/@olli', 'Mastodon'],
                ['https://www.instagram.com/ollri.ch/', 'Instagram'],
                ['https://pixelfed.de/olli', 'Pixelfed'],
                ['https://soundcloud.com/livicxyz', 'SoundCloud'],
                ['https://www.youtube.com/@schongeilDE', 'YouTube'],
                ['https://bandcamp.com/livic', 'Bandcamp'],
                ['https://unsplash.com/@ollrich', 'Unsplash'],
                ['https://sifa.id/p/ollri.ch', 'sifa.id'],
            ],
            'mentionsTitle' => 'Omtaler',
            'mentions' => [
                ['https://www.wuv.de/Archiv/So-tickt-die-Zukunft-Dokyo-auf-der-%22The-Next-Web-Conference%22', 'W&V', 'DOKYO på The Next Web Conference'],
                ['https://www.wuv.de/Archiv/Wie-man-mit-Messenger-f%C3%BCr-die-Ehe-f%C3%BCr-alle-wirbt', 'W&V', 'Ben & Jerry\'s "Ægteskab for alle"-kampagne'],
                ['https://www.testspiel.de/oliver-polak-interview-2/290215/', 'testspiel.de', 'Oliver Polak Interview'],
                ['https://www.testspiel.de/kid-simius-interview/276764/', 'testspiel.de', 'Kid Simius Interview'],
            ],
        ],
    ],

    // ========================================================================
    // NOTFOUND — nur für 404.php (Apache ErrorDocument)
    // ========================================================================
    'notfound' => [
        'de' => [
            'title' => 'Seite nicht gefunden – Oliver Eichhof',
            'notFoundText' => 'Diese Seite existiert nicht (mehr).',
            'notFoundBack' => 'Zur Startseite',
        ],
        'en' => [
            'title' => 'Page not found – Oliver Eichhof',
            'notFoundText' => 'This page does not exist (anymore).',
            'notFoundBack' => 'Back to the homepage',
        ],
        'da' => [
            'title' => 'Siden blev ikke fundet – Oliver Eichhof',
            'notFoundText' => 'Denne side findes ikke (længere).',
            'notFoundBack' => 'Til forsiden',
        ],
    ],
];
