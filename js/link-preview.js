/**
 * Link Preview Module
 * ===================
 * Shows hoverable preview images for certain links in the tagline.
 * Desktop only - disabled on mobile/touch devices.
 * Previews appear after 500ms hover delay to avoid accidental triggers.
 */
(function() {
    'use strict';

    // DOM references
    let preview = null;
    let previewClose = null;
    let taglineElement = null;

    // State
    let previewTimeout = null;
    let hideTimeout = null;
    let currentPreviewElement = null;
    let currentUrl = null;
    let isOverPreview = false;
    let isOverLink = false;

    // Touch device detection
    const isTouchDevice = ('ontouchstart' in window) || (navigator.maxTouchPoints > 0);

    /**
     * Map of URLs to their preview images
     * Supports language-specific variants
     */
    const PREVIEW_IMAGES = {
        'schongeil.de': {
            de: '/images/hover/blog-preview.webp',
            en: '/images/hover/blog-preview-en.webp',
            da: '/images/hover/blog-preview-en.webp'
        },
        'soundcloud.com': '/images/hover/soundcloud-preview.webp'
    };

    /**
     * Get current language from LanguageManager or default to 'de'
     * @returns {string} Current language code
     */
    function getCurrentLang() {
        return window.LanguageManager ? window.LanguageManager.getCurrentLang() : 'de';
    }

    /**
     * Get preview image path for a given URL
     * @param {string} url - The URL to get preview for
     * @returns {string|null} Preview image path or null if not available
     */
    function getPreviewImage(url) {
        for (const key in PREVIEW_IMAGES) {
            if (url.includes(key)) {
                const value = PREVIEW_IMAGES[key];
                // Handle language-specific previews
                if (typeof value === 'object') {
                    return value[getCurrentLang()] || value['de'];
                }
                return value;
            }
        }
        return null;
    }

    /**
     * Show link preview after hover delay
     * @param {string} url - URL to preview
     * @param {HTMLElement} linkElement - The link element being hovered
     */
    function showLinkPreview(url, linkElement) {
        clearTimeout(previewTimeout);
        clearTimeout(hideTimeout);

        const previewImage = getPreviewImage(url);
        if (!previewImage) return;

        currentUrl = url;

        // Delay showing to avoid accidental triggers
        previewTimeout = setTimeout(function() {
            // Remove old preview image if present
            if (currentPreviewElement) {
                preview.removeChild(currentPreviewElement);
            }

            // Create new preview image
            const img = document.createElement('img');
            img.src = previewImage;
            img.alt = 'Preview';
            currentPreviewElement = img;
            preview.appendChild(img);

            // Calculate optimal position
            const rect = linkElement.getBoundingClientRect();
            const previewWidth = 400;
            const previewHeight = 240;

            let left = rect.left + rect.width / 2 - previewWidth / 2;
            let top = rect.bottom + 20;

            // Keep within viewport bounds
            if (left + previewWidth > window.innerWidth - 20) {
                left = window.innerWidth - previewWidth - 20;
            }
            if (left < 20) {
                left = 20;
            }

            // If no space below, show above
            if (top + previewHeight > window.innerHeight - 20) {
                top = rect.top - previewHeight - 20;
            }

            preview.style.left = left + 'px';
            preview.style.top = top + 'px';
            preview.classList.add('active');
        }, 500);
    }

    /**
     * Hide link preview
     * @param {boolean} force - If true, hide immediately
     */
    function hideLinkPreview(force) {
        clearTimeout(previewTimeout);
        clearTimeout(hideTimeout);

        if (force === true) {
            // Immediate hide
            preview.classList.remove('active');
            setTimeout(function() {
                if (currentPreviewElement && !isOverPreview && !isOverLink) {
                    preview.removeChild(currentPreviewElement);
                    currentPreviewElement = null;
                    currentUrl = null;
                }
            }, 300);
            return;
        }

        // Delayed hide (allows moving cursor from link to preview)
        hideTimeout = setTimeout(function() {
            if (!isOverPreview && !isOverLink) {
                preview.classList.remove('active');
                setTimeout(function() {
                    if (currentPreviewElement && !isOverPreview && !isOverLink) {
                        preview.removeChild(currentPreviewElement);
                        currentPreviewElement = null;
                        currentUrl = null;
                    }
                }, 300);
            }
        }, 300);
    }

    /**
     * Keep preview visible when hovering over it
     */
    function keepPreviewVisible() {
        isOverPreview = true;
        clearTimeout(hideTimeout);
        clearTimeout(previewTimeout);
    }

    /**
     * Initialize link preview for tagline links
     */
    function initLinkPreviews() {
        // Desktop only
        if (isTouchDevice || window.innerWidth <= 768) return;
        if (!taglineElement) return;

        const links = taglineElement.querySelectorAll('a');
        links.forEach(function(link) {
            const url = link.getAttribute('href');
            if (!getPreviewImage(url)) return;

            link.addEventListener('mouseenter', function() {
                isOverLink = true;
                clearTimeout(hideTimeout);
                if (url) {
                    showLinkPreview(url, link);
                }
            });

            link.addEventListener('mouseleave', function() {
                isOverLink = false;
                hideLinkPreview();
            });
        });
    }

    /**
     * Initialize the module
     */
    function init() {
        preview = document.getElementById('link-preview');
        if (!preview) return;

        previewClose = document.getElementById('preview-close');
        taglineElement = document.getElementById('tagline');

        // Preview hover events
        preview.addEventListener('mouseenter', keepPreviewVisible);
        preview.addEventListener('mouseleave', function() {
            isOverPreview = false;
            hideLinkPreview();
        });

        // Click preview to open link
        preview.addEventListener('click', function(e) {
            if (e.target === previewClose || e.target.closest('.preview-close')) return;
            if (currentUrl) {
                window.open(currentUrl, '_blank', 'noopener,noreferrer');
            }
        });

        // Close button
        if (previewClose) {
            previewClose.addEventListener('click', function(e) {
                e.stopPropagation();
                isOverPreview = false;
                isOverLink = false;
                hideLinkPreview(true);
            });
        }

        // Initialize for current links
        initLinkPreviews();

        // Re-initialize when tagline content changes (language switch)
        // Using MutationObserver to detect changes
        if (taglineElement) {
            const observer = new MutationObserver(function() {
                // Small delay to ensure DOM is updated
                setTimeout(initLinkPreviews, 100);
            });
            observer.observe(taglineElement, { childList: true, subtree: true });
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Export for external use
    window.LinkPreview = {
        show: showLinkPreview,
        hide: hideLinkPreview
    };
})();
