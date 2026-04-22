/**
 * Grounding Page Email Obfuscation
 * =================================
 * Assembles the email address from parts to prevent scraping.
 */
(function() {
    'use strict';

    var d = ['eichhof', 'me'];
    var lang = document.documentElement.lang || 'de';
    var prefixes = { de: 'hallo', en: 'hello', da: 'hej' };
    var p = prefixes[lang] || 'hallo';
    var a = p + '@' + d[0] + '.' + d[1];

    var el = document.getElementById('overlay-email-link');
    if (el) {
        el.textContent = a;
        el.href = 'mailto:' + a;
    }
})();
