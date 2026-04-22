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

    function applyTheme(theme) {
        document.documentElement.classList.remove('dark-mode', 'light-mode');
        if (theme === 'dark') document.documentElement.classList.add('dark-mode');
        else if (theme === 'light') document.documentElement.classList.add('light-mode');
    }

    function initTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark' || savedTheme === 'light') {
            applyTheme(savedTheme);
        }
    }

    function toggleTheme() {
        const next = getEffectiveTheme() === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        localStorage.setItem('theme', next);
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
