/**
 * Overlay/Modal Module
 * ====================
 * Handles the legal notice modal with proper accessibility features
 * including focus trap for keyboard navigation.
 */
(function() {
    'use strict';

    let overlay = null;
    let overlayContent = null;
    let closeButton = null;
    let previousActiveElement = null;
    let focusableElements = [];

    /**
     * Get all focusable elements within the overlay
     * @returns {Array} Array of focusable DOM elements
     */
    function getFocusableElements() {
        if (!overlayContent) return [];

        const selector = [
            'button',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(', ');

        return Array.from(overlayContent.querySelectorAll(selector))
            .filter(el => !el.hasAttribute('disabled') && el.offsetParent !== null);
    }

    /**
     * Handle Tab key for focus trapping
     * @param {KeyboardEvent} e - Keyboard event
     */
    function handleTabKey(e) {
        if (!overlay || !overlay.classList.contains('active')) return;

        focusableElements = getFocusableElements();
        if (focusableElements.length === 0) return;

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey) {
            // Shift+Tab: If at first element, wrap to last
            if (document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            // Tab: If at last element, wrap to first
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
            closeOverlay();
        } else if (e.key === 'Tab') {
            handleTabKey(e);
        }
    }

    /**
     * Open the overlay modal
     */
    function openOverlay() {
        if (!overlay) return;

        // Store current focus to restore later
        previousActiveElement = document.activeElement;

        // Show overlay
        overlay.classList.add('active');

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Focus the close button (or first focusable element)
        setTimeout(function() {
            focusableElements = getFocusableElements();
            if (closeButton) {
                closeButton.focus();
            } else if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        }, 100); // Small delay for transition

        // Add keyboard listener
        document.addEventListener('keydown', handleKeydown);
    }

    /**
     * Close the overlay modal
     */
    function closeOverlay() {
        if (!overlay) return;

        overlay.classList.remove('active');

        // Restore body scroll
        document.body.style.overflow = '';

        // Restore previous focus
        if (previousActiveElement) {
            previousActiveElement.focus();
            previousActiveElement = null;
        }

        // Remove keyboard listener
        document.removeEventListener('keydown', handleKeydown);
    }

    /**
     * Initialize overlay module
     */
    function init() {
        overlay = document.getElementById('overlay');
        if (!overlay) return;

        overlayContent = overlay.querySelector('.overlay-content');
        closeButton = document.getElementById('close-overlay-btn');

        // Make overlay content accessible
        if (overlayContent) {
            overlayContent.setAttribute('role', 'dialog');
            overlayContent.setAttribute('aria-modal', 'true');
            overlayContent.setAttribute('aria-labelledby', 'overlay-title');
        }

        // Close button click
        if (closeButton) {
            closeButton.addEventListener('click', closeOverlay);
        }

        // Click outside to close
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                closeOverlay();
            }
        });

        // Prevent clicks inside content from closing
        if (overlayContent) {
            overlayContent.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Set up footer link triggers
        const footerLink = document.getElementById('footer-link');
        const footerLinkMobile = document.getElementById('footer-link-mobile');

        if (footerLink) {
            footerLink.addEventListener('click', function(e) {
                e.preventDefault();
                openOverlay();
            });
        }

        if (footerLinkMobile) {
            footerLinkMobile.addEventListener('click', function(e) {
                e.preventDefault();
                openOverlay();
            });
        }

        // Check for URL parameter to auto-open
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('impressum') !== null || urlParams.get('legal') !== null) {
            // Small delay to ensure page is ready
            setTimeout(openOverlay, 100);
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.OverlayManager = {
        open: openOverlay,
        close: closeOverlay,
        isOpen: function() {
            return overlay && overlay.classList.contains('active');
        }
    };
})();
