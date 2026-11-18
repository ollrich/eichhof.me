/**
 * Disclosure-Verhalten für den Sprachwähler.
 * ==========================================
 * Ein einziger Zustand steuert Optik (data-expanded) und Ansage
 * (aria-expanded) gemeinsam. Vorher klappte CSS das Menü über :hover und
 * :focus-within auf, aria-expanded folgte aber nur dem Klick — Sichtbares
 * und Angesagtes liefen auseinander, und ein per Tastaturfokus geöffnetes
 * Menü liess sich mit Escape nicht schliessen.
 *
 * Zwei Quellen ergeben "offen":
 *   pinned   — per Klick/Tap oder Enter/Leertaste geöffnet (bleibt offen,
 *              bis Klick ausserhalb, Escape oder Fokus verlässt das Menü)
 *   hovering — Maus über dem Wähler (nur auf Geräten mit echtem Hover;
 *              Touch-Geräte feuern sonst bei jedem Tap ein mouseenter)
 *
 * Die Klasse .is-enhanced schaltet den reinen CSS-Rückfall (:hover,
 * :focus-within) ab, der ohne JS weiter greift.
 */
(function() {
    'use strict';

    const switcher = document.querySelector('.lang-switcher');
    if (!switcher) return;

    const trigger = switcher.querySelector('.lang-switcher-current');
    if (!trigger) return;

    const canHover = window.matchMedia('(hover: hover)').matches;
    let pinned = false;
    let hovering = false;

    function render() {
        const open = pinned || hovering;
        switcher.dataset.expanded = open ? 'true' : 'false';
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    function close() {
        pinned = false;
        hovering = false;
        render();
    }

    switcher.classList.add('is-enhanced');

    trigger.addEventListener('click', function(event) {
        // Klick auf den aktuellen Sprachen-Trigger navigiert nicht — er
        // togglet das Menü. stopPropagation verhindert, dass die
        // "Klick ausserhalb schliesst"-Regel unten direkt wieder zumacht.
        event.stopPropagation();
        pinned = !pinned;
        render();
    });

    if (canHover) {
        switcher.addEventListener('mouseenter', function() { hovering = true; render(); });
        switcher.addEventListener('mouseleave', function() { hovering = false; render(); });
    }

    // Tastatur: Tab aus dem Menü heraus schliesst es.
    switcher.addEventListener('focusout', function(event) {
        if (!switcher.contains(event.relatedTarget)) {
            pinned = false;
            render();
        }
    });

    document.addEventListener('click', function(event) {
        if (!switcher.contains(event.target)) {
            pinned = false;
            render();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && switcher.dataset.expanded === 'true') {
            close();
            trigger.focus();
        }
    });
})();
