/**
 * About Overlay Module
 * ====================
 * Handles the about/grounding page overlay with proper accessibility
 * features including focus trap and URL history management.
 */
(function() {
    'use strict';

    let overlay = null;
    let overlayContent = null;
    let closeButton = null;
    let previousActiveElement = null;
    let focusableElements = [];

    /**
     * Get the about URL based on current language
     * @returns {string} URL path for about page
     */
    function getAboutUrl() {
        var lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';
        if (lang === 'en') return '/en/about';
        if (lang === 'da') return '/dk/om';
        return '/ueber';
    }

    /**
     * Get the base URL for current language
     * @returns {string} Base URL path
     */
    function getBaseUrl() {
        var lang = window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';
        if (lang === 'en') return '/en/';
        if (lang === 'da') return '/dk/';
        return '/';
    }

    /**
     * Get all focusable elements within the overlay
     * @returns {Array} Array of focusable DOM elements
     */
    function getFocusableElements() {
        if (!overlayContent) return [];

        var selector = [
            'button',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(', ');

        return Array.from(overlayContent.querySelectorAll(selector))
            .filter(function(el) { return !el.hasAttribute('disabled') && el.offsetParent !== null; });
    }

    /**
     * Handle Tab key for focus trapping
     * @param {KeyboardEvent} e - Keyboard event
     */
    function handleTabKey(e) {
        if (!overlay || !overlay.classList.contains('active')) return;

        focusableElements = getFocusableElements();
        if (focusableElements.length === 0) return;

        var firstElement = focusableElements[0];
        var lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            if (document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    /**
     * Handle keyboard events for the overlay
     * @param {KeyboardEvent} e - Keyboard event
     */
    function handleKeydown(e) {
        if (!overlay || !overlay.classList.contains('active')) return;

        if (e.key === 'Escape') {
            e.preventDefault();
            closeAbout();
        } else if (e.key === 'Tab') {
            handleTabKey(e);
        }
    }

    /**
     * Open the about overlay
     * @param {boolean} skipHistory - If true, don't push to history (used for popstate)
     */
    function openAbout(skipHistory) {
        if (!overlay) return;

        // Store current focus to restore later
        previousActiveElement = document.activeElement;

        // Update URL (unless opening from popstate or server-side)
        if (!skipHistory && document.body.dataset.overlay !== 'about') {
            history.pushState({ overlay: 'about' }, '', getAboutUrl());
        }

        // Show overlay
        overlay.classList.add('active');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Focus the overlay content
        setTimeout(function() {
            focusableElements = getFocusableElements();
            if (overlayContent) {
                overlayContent.setAttribute('tabindex', '-1');
                overlayContent.focus({ preventScroll: true });
            }
        }, 100);

        // Add keyboard listener
        document.addEventListener('keydown', handleKeydown);
    }

    /**
     * Close the about overlay
     * @param {boolean} skipHistory - If true, don't modify history (used for popstate)
     */
    function closeAbout(skipHistory) {
        if (!overlay) return;

        overlay.classList.remove('active');

        // Restore body scroll
        document.body.style.overflow = '';

        // Update URL back to base (unless closing from popstate)
        if (!skipHistory) {
            history.pushState({ overlay: null }, '', getBaseUrl());
        }

        // Restore previous focus
        if (previousActiveElement) {
            previousActiveElement.focus();
            previousActiveElement = null;
        }

        // Remove keyboard listener
        document.removeEventListener('keydown', handleKeydown);
    }

    /**
     * Handle browser back/forward navigation
     */
    function handlePopState(e) {
        if (e.state && e.state.overlay === 'about') {
            openAbout(true);
        } else if (overlay && overlay.classList.contains('active')) {
            closeAbout(true);
        }
    }

    /**
     * Initialize about overlay module
     */
    function init() {
        overlay = document.getElementById('about-overlay');
        if (!overlay) return;

        overlayContent = overlay.querySelector('.overlay-content');
        closeButton = document.getElementById('close-about-btn');

        // Make overlay content accessible
        if (overlayContent) {
            overlayContent.setAttribute('role', 'dialog');
            overlayContent.setAttribute('aria-modal', 'true');
            overlayContent.setAttribute('aria-labelledby', 'about-title');
        }

        // Close button click
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                closeAbout();
            });
        }

        // Click outside to close
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeAbout();
            }
        });

        // Prevent clicks inside content from closing
        if (overlayContent) {
            overlayContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Set up trigger icon click
        var triggerCard = document.getElementById('about-trigger-card');

        if (triggerCard) {
            triggerCard.addEventListener('click', function(e) {
                e.preventDefault();
                openAbout();
            });
        }

        // Listen for browser back/forward
        window.addEventListener('popstate', handlePopState);

        // Cleanup on page unload
        window.addEventListener('pagehide', cleanup);
    }

    /**
     * Cleanup event listeners on page unload
     */
    function cleanup() {
        window.removeEventListener('popstate', handlePopState);
        window.removeEventListener('pagehide', cleanup);
        document.removeEventListener('keydown', handleKeydown);
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.AboutManager = {
        open: openAbout,
        close: closeAbout,
        isOpen: function() {
            return overlay && overlay.classList.contains('active');
        }
    };
})();
