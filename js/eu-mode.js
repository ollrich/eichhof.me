/**
 * Profile Mode Toggle (Standard ↔ European alternatives)
 * ======================================================
 * Switches the visible profile buttons between the default set
 * (LinkedIn, Instagram, Bluesky) and European alternatives
 * (XING, Pixelfed, Mastodon) by toggling html.eu-mode.
 *
 * The initial state is already applied pre-paint by the inline
 * bootstrap in includes/theme-init.php (reads localStorage 'profiles'),
 * so there is no flash of the wrong button set. This module wires up the
 * click handler, keeps aria-checked in sync, and silences the attention
 * pulse once the toggle has been used.
 *
 * Persisted in localStorage ('profiles' = 'eu' | 'default'), consistent
 * with the privacy-first approach.
 */
(function() {
    'use strict';

    var KEY = 'profiles';
    var SEEN = 'profileToggleSeen'; // '1' once the user has used the toggle
    var root = document.documentElement;
    var toggle = document.getElementById('profile-toggle');
    if (!toggle) return;

    function isEu() {
        return root.classList.contains('eu-mode');
    }

    // Attention pulse only plays until the toggle has been used once.
    // For returning visitors we add the class well before the animation's
    // 2.5s delay elapses, so the pulse never becomes visible (no flash).
    try {
        if (localStorage.getItem(SEEN) === '1') {
            root.classList.add('profile-toggle-seen');
        }
    } catch (e) {
        // localStorage unavailable — pulse just plays again next time.
    }

    // Sync aria-checked with the pre-paint state.
    toggle.setAttribute('aria-checked', isEu() ? 'true' : 'false');

    toggle.addEventListener('click', function() {
        var next = !isEu();
        root.classList.toggle('eu-mode', next);
        toggle.setAttribute('aria-checked', next ? 'true' : 'false');

        // Used → stop the pulse now and on all future visits.
        root.classList.add('profile-toggle-seen');

        try {
            localStorage.setItem(KEY, next ? 'eu' : 'default');
            localStorage.setItem(SEEN, '1');
        } catch (e) {
            // localStorage unavailable — works for the session, just
            // won't persist the choice or the "seen" state.
        }
    });
})();
