/**
 * Theme Management Module
 * =======================
 * Tri-state theme: no class = follow system (via CSS @media),
 * .dark-mode = user opted into dark, .light-mode = user opted into light.
 *
 * Priority: localStorage override > system preference (handled by CSS).
 */
(function() {
    'use strict';

    function getEffectiveTheme() {
        if (document.documentElement.classList.contains('dark-mode')) return 'dark';
        if (document.documentElement.classList.contains('light-mode')) return 'light';
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Muss den <meta name="theme-color">-Werten in den <head>s entsprechen
    // (index.php, about/index.php, 404.php).
    const THEME_COLORS = { light: '#64408a', dark: '#0d0d14' };

    /**
     * Browser-UI-Farbe (mobile Adressleiste) an ein explizit gewähltes
     * Theme angleichen. Die beiden meta-Tags hängen per media-Attribut an
     * prefers-color-scheme — ein manueller Toggle ändert das Systemschema
     * aber nicht. Daher bekommen bei expliziter Wahl beide Tags dieselbe
     * Farbe; ohne explizite Wahl (System-Modus) bleiben die Defaults aktiv.
     */
    function syncThemeColor() {
        const explicit = document.documentElement.classList.contains('dark-mode') ? 'dark'
                       : document.documentElement.classList.contains('light-mode') ? 'light'
                       : null;
        if (!explicit) return;
        document.querySelectorAll('meta[name="theme-color"]').forEach(function(meta) {
            meta.setAttribute('content', THEME_COLORS[explicit]);
        });
    }

    function applyTheme(theme) {
        document.documentElement.classList.remove('dark-mode', 'light-mode');
        if (theme === 'dark') document.documentElement.classList.add('dark-mode');
        else if (theme === 'light') document.documentElement.classList.add('light-mode');
    }

    /**
     * localStorage-Zugriff kapseln: In Browsern mit blockierten Site-Daten
     * (Safari mit deaktiviertem Speicher, Firefox mit blockierten Cookies,
     * restriktive Enterprise-Policies) wirft schon der Zugriff auf
     * window.localStorage eine SecurityError. Ungekapselt hätte das die
     * gesamte IIFE abgebrochen — der Theme-Button wäre tot und
     * window.ThemeManager nie definiert gewesen. So bleibt das Umschalten
     * innerhalb der Sitzung funktionsfähig, nur das Merken entfällt.
     */
    function readStored() {
        try {
            return localStorage.getItem('theme');
        } catch (e) {
            return null;
        }
    }

    function writeStored(value) {
        try {
            localStorage.setItem('theme', value);
        } catch (e) {
            /* Speichern nicht möglich — Theme gilt trotzdem für diese Seite. */
        }
    }

    function initTheme() {
        const savedTheme = readStored();
        if (savedTheme === 'dark' || savedTheme === 'light') {
            applyTheme(savedTheme);
        }
        syncThemeColor();
    }

    function toggleTheme() {
        const next = getEffectiveTheme() === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        writeStored(next);
        syncThemeColor();
    }

    function setupToggleButton(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                toggleTheme();
                this.blur();
            });
        }
    }

    initTheme();

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setupToggleButton('theme-toggle');
        });
    } else {
        setupToggleButton('theme-toggle');
    }

    window.ThemeManager = {
        toggle: toggleTheme,
        isDark: function() {
            return getEffectiveTheme() === 'dark';
        }
    };
})();
