/**
 * Theme Management Module
 * =======================
 * Handles dark mode toggle with localStorage persistence
 * and system preference detection.
 *
 * Priority: localStorage > system preference > default (light)
 */
(function() {
    'use strict';

    /**
     * Initialize theme based on saved preference or system setting
     * Called immediately to prevent flash of wrong theme
     */
    function initTheme() {
        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Priority: saved preference > system preference
        if (savedTheme === 'dark' || (savedTheme === null && prefersDark)) {
            document.documentElement.classList.add('dark-mode');
        }
    }

    /**
     * Toggle between light and dark mode
     * Saves preference to localStorage
     */
    function toggleTheme() {
        document.documentElement.classList.toggle('dark-mode');
        const isDark = document.documentElement.classList.contains('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    /**
     * Handle system theme changes (when user hasn't set explicit preference)
     */
    function handleSystemThemeChange(e) {
        // Only react if user hasn't set explicit preference
        if (localStorage.getItem('theme') === null) {
            if (e.matches) {
                document.documentElement.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
            }
        }
    }

    /**
     * Set up theme toggle button event listener
     * @param {string} buttonId - ID of the toggle button element
     */
    function setupToggleButton(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.addEventListener('click', function() {
                toggleTheme();
                this.blur(); // Remove focus after click
            });
        }
    }

    // Initialize theme immediately (before DOM ready)
    initTheme();

    // Set up event listeners when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setupToggleButton('theme-toggle');
        });
    } else {
        // DOM already loaded
        setupToggleButton('theme-toggle');
    }

    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', handleSystemThemeChange);

    // Export for potential external use
    window.ThemeManager = {
        toggle: toggleTheme,
        isDark: function() {
            return document.documentElement.classList.contains('dark-mode');
        }
    };
})();
