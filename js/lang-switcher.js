/**
 * Disclosure-Verhalten für den Sprachwähler.
 * ==========================================
 * Desktop klappt das Menü über CSS :hover auf, Tastaturnutzung über
 * :focus-within — beides ohne JS. Auf Touch-Devices reicht :focus-within
 * nicht zuverlässig (iOS Safari setzt erst seit 14.5 konsistent Fokus auf
 * <button>, und auch danach ist das Verhalten uneinheitlich). Deshalb
 * togglen wir hier zusätzlich ein data-expanded-Attribut beim Tap/Klick
 * auf den Trigger. Dieselbe CSS-Regel feuert für alle drei Zustände.
 *
 * Nebenbei halten wir aria-expanded akkurat, damit Screenreader den
 * Offen/Zu-Status korrekt ansagen.
 */
(function() {
    'use strict';

    const switcher = document.querySelector('.lang-switcher');
    if (!switcher) return;

    const trigger = switcher.querySelector('.lang-switcher-current');
    if (!trigger) return;

    function setOpen(open) {
        switcher.dataset.expanded = open ? 'true' : 'false';
        trigger.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    trigger.addEventListener('click', function(event) {
        // Klick auf den aktuellen Sprachen-Trigger navigiert nicht —
        // er togglet das Menü. stopPropagation verhindert, dass die
        // "Klick ausserhalb schliesst"-Regel unten direkt wieder zumacht.
        event.stopPropagation();
        setOpen(switcher.dataset.expanded !== 'true');
    });

    document.addEventListener('click', function(event) {
        if (!switcher.contains(event.target)) setOpen(false);
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && switcher.dataset.expanded === 'true') {
            setOpen(false);
            trigger.focus();
        }
    });
})();
