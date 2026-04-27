/**
 * Overlay/Modal Module
 * ====================
 * Verwaltet mehrere Overlays (Impressum/Legal und Datenschutz/Privacy)
 * mit Fokus-Trap, ESC-Key und URL-History-Sync.
 */
(function() {
    'use strict';

    // Fallback auf document.documentElement.lang, wenn language.js nicht
    // geladen ist (z. B. auf der Grounding-Page).
    function getCurrentLang() {
        if (window.LanguageManager) return window.LanguageManager.getCurrentLang();
        return document.documentElement.lang || 'de';
    }

    function getLegalUrl() {
        const lang = getCurrentLang();
        if (lang === 'en') return '/en/legal-notice';
        if (lang === 'da') return '/da/kolofon';
        return '/de/impressum';
    }

    function getPrivacyUrl() {
        const lang = getCurrentLang();
        if (lang === 'en') return '/en/privacy';
        if (lang === 'da') return '/da/privatlivspolitik';
        return '/de/datenverarbeitung';
    }

    function getBaseUrl() {
        const lang = getCurrentLang();
        if (lang === 'en') return '/en/';
        if (lang === 'da') return '/da/';
        return '/';
    }

    /**
     * Registry aller Overlays.
     * key  = history-State-Identifier
     * el   = äußeres .overlay-Element
     * content = .overlay-content-Container
     * closeBtn = X-Button
     * triggers = Footer-Links, die das Overlay öffnen
     * getUrl = liefert die URL beim Öffnen
     * titleId = ID des <h2> für aria-labelledby
     */
    const OVERLAYS = {};

    let activeKey = null;               // welches Overlay aktuell offen ist
    let previousActiveElement = null;   // Fokus vor dem Öffnen
    let originalUrl = null;             // URL, auf die beim Schließen zurückgesetzt wird

    function getActive() {
        return activeKey ? OVERLAYS[activeKey] : null;
    }

    function getFocusableElements(content) {
        if (!content) return [];
        const selector = [
            'button',
            '[href]',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"])'
        ].join(', ');
        return Array.from(content.querySelectorAll(selector))
            .filter(el => !el.hasAttribute('disabled') && el.offsetParent !== null);
    }

    function handleTabKey(e) {
        const active = getActive();
        if (!active || !active.el.classList.contains('active')) return;

        const focusable = getFocusableElements(active.content);
        if (focusable.length === 0) return;

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (e.shiftKey) {
            if (document.activeElement === first) {
                e.preventDefault();
                last.focus();
            }
        } else {
            if (document.activeElement === last) {
                e.preventDefault();
                first.focus();
            }
        }
    }

    function handleKeydown(e) {
        const active = getActive();
        if (!active || !active.el.classList.contains('active')) return;
        if (e.key === 'Escape') {
            e.preventDefault();
            closeOverlay();
        } else if (e.key === 'Tab') {
            handleTabKey(e);
        }
    }

    /**
     * Öffnet ein Overlay. Schließt ein ggf. anderes aktives Overlay.
     * @param {string} key - Schlüssel in OVERLAYS
     * @param {boolean} skipHistory - true bei popstate / Server-Init
     */
    function openOverlay(key, skipHistory) {
        const target = OVERLAYS[key];
        if (!target) return;

        // Anderes Overlay noch offen? Schließen ohne History-Push.
        if (activeKey && activeKey !== key) {
            const other = OVERLAYS[activeKey];
            if (other) {
                other.el.classList.remove('active');
            }
        } else if (!activeKey) {
            // Nur wenn KEIN Overlay offen war, merken wir den Fokus
            previousActiveElement = document.activeElement;
        }

        if (!skipHistory && !document.body.dataset.overlay) {
            // Nur beim allerersten Öffnen die Ausgangs-URL merken
            if (originalUrl === null) {
                originalUrl = window.location.pathname;
            }
            history.pushState({ overlay: key }, '', target.getUrl());
        }

        target.el.classList.add('active');
        activeKey = key;

        document.body.style.overflow = 'hidden';

        setTimeout(function() {
            if (target.content) {
                target.content.setAttribute('tabindex', '-1');
                target.content.focus({ preventScroll: true });
            }
        }, 100);

        document.addEventListener('keydown', handleKeydown);
    }

    function closeOverlay(skipHistory) {
        const active = getActive();
        if (!active) return;

        active.el.classList.remove('active');
        document.body.style.overflow = '';

        if (!skipHistory) {
            history.pushState({ overlay: null }, '', originalUrl || getBaseUrl());
        }

        activeKey = null;

        if (previousActiveElement) {
            previousActiveElement.focus();
            previousActiveElement = null;
        }

        document.removeEventListener('keydown', handleKeydown);
    }

    function handlePopState(e) {
        const state = e.state;
        if (state && state.overlay && OVERLAYS[state.overlay]) {
            openOverlay(state.overlay, true);
        } else if (activeKey) {
            closeOverlay(true);
        }
    }

    /**
     * Registriert ein Overlay aus dem DOM.
     * Gibt true zurück, wenn das Overlay-Element existiert.
     */
    function register(key, config) {
        const el = document.getElementById(config.overlayId);
        if (!el) return false;

        const content = el.querySelector('.overlay-content');
        const closeBtn = document.getElementById(config.closeBtnId);

        if (content) {
            content.setAttribute('role', 'dialog');
            content.setAttribute('aria-modal', 'true');
            if (config.titleId) {
                content.setAttribute('aria-labelledby', config.titleId);
            }
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', function() { closeOverlay(); });
        }

        // Klick auf Backdrop schließt
        el.addEventListener('click', function(e) {
            if (e.target === el) closeOverlay();
        });
        if (content) {
            content.addEventListener('click', function(e) { e.stopPropagation(); });
        }

        // Footer-Trigger
        (config.triggerIds || []).forEach(function(id) {
            const trigger = document.getElementById(id);
            if (trigger) {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    openOverlay(key);
                });
            }
        });

        OVERLAYS[key] = {
            el: el,
            content: content,
            closeBtn: closeBtn,
            getUrl: config.getUrl,
            titleId: config.titleId
        };
        return true;
    }

    function init() {
        const hasLegal = register('legal', {
            overlayId: 'overlay',
            closeBtnId: 'close-overlay-btn',
            triggerIds: ['footer-link', 'footer-link-mobile'],
            titleId: 'overlay-title',
            getUrl: getLegalUrl
        });

        const hasPrivacy = register('privacy', {
            overlayId: 'privacy-overlay',
            closeBtnId: 'close-privacy-btn',
            triggerIds: ['footer-privacy-link', 'footer-privacy-link-mobile'],
            titleId: 'privacy-title',
            getUrl: getPrivacyUrl
        });

        if (!hasLegal && !hasPrivacy) return;

        window.addEventListener('popstate', handlePopState);
        window.addEventListener('pagehide', cleanup);

        if (!document.body.dataset.overlay) {
            history.replaceState({ overlay: null }, '', window.location.pathname);
        }

        // Legacy: ?impressum oder ?legal öffnet das Legal-Overlay
        const urlParams = new URLSearchParams(window.location.search);
        if ((urlParams.get('impressum') !== null || urlParams.get('legal') !== null) && hasLegal) {
            setTimeout(function() { openOverlay('legal', true); }, 100);
        }
    }

    function cleanup() {
        window.removeEventListener('popstate', handlePopState);
        window.removeEventListener('pagehide', cleanup);
        document.removeEventListener('keydown', handleKeydown);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Public API — default-Overlay ist 'legal' (Backward-Kompat).
    window.OverlayManager = {
        open: function(key) { openOverlay(key || 'legal'); },
        close: function() { closeOverlay(); },
        isOpen: function(key) {
            if (key) {
                return OVERLAYS[key] && OVERLAYS[key].el.classList.contains('active');
            }
            return activeKey !== null;
        },
        getActiveKey: function() { return activeKey; }
    };
})();
