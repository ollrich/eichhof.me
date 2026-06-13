/**
 * Profile Mode Toggle (Standard ↔ European alternatives)
 * ======================================================
 * Switches the visible profile buttons between the default set
 * (LinkedIn, Instagram, Bluesky) and European alternatives
 * (XING, Pixelfed, Mastodon) by toggling html.eu-mode.
 *
 * The initial state is already applied pre-paint by the inline
 * bootstrap in includes/theme-init.php (reads localStorage 'profiles'),
 * so there is no flash of the wrong button set. This module only wires
 * up the click handler and keeps aria-checked in sync.
 *
 * Persisted in localStorage ('profiles' = 'eu' | 'default'), consistent
 * with the privacy-first approach (theme is the only other local key).
 */
(function() {
    'use strict';

    var KEY = 'profiles';
    var root = document.documentElement;
    var toggle = document.getElementById('profile-toggle');
    if (!toggle) return;

    function isEu() {
        return root.classList.contains('eu-mode');
    }

    // Sync aria-checked with the pre-paint state.
    toggle.setAttribute('aria-checked', isEu() ? 'true' : 'false');

    toggle.addEventListener('click', function() {
        var next = !isEu();
        root.classList.toggle('eu-mode', next);
        toggle.setAttribute('aria-checked', next ? 'true' : 'false');
        try {
            localStorage.setItem(KEY, next ? 'eu' : 'default');
        } catch (e) {
            // localStorage unavailable (private mode quota etc.) — the
            // toggle still works for the session, just won't persist.
        }
    });
})();
