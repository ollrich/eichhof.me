<?php
/**
 * Pre-Paint Theme-Initialisierung
 * ================================
 * Liest die Theme-Präferenz aus localStorage und setzt die passende
 * Klasse auf <html>, bevor das erste Paint stattfindet. Verhindert
 * Theme-Flash beim Seitenaufruf (sowohl light→dark als auch dark→light).
 *
 * Der try/catch ist Pflicht, nicht Kosmetik: Bei blockierten Site-Daten
 * (Safari ohne Speichererlaubnis, Firefox mit blockierten Cookies,
 * restriktive Enterprise-Policies) wirft bereits der Zugriff auf
 * localStorage eine SecurityError — sonst stünde vor jedem Seitenaufbau
 * ein Konsolenfehler.
 *
 * Muss synchron im <head> vor allen Stylesheets includet werden.
 * Der Script-Inhalt ist über SHA-256-Hash in der CSP whitelisted
 * (Hash: sha256-Z1iFNpZwZ4H8/PXS52nPWtnQu0MIsUKrx1T/QwLeFY4=).
 * Der Script-Inhalt darf NICHT verändert werden, ohne auch den
 * CSP-Hash in .htaccess anzupassen.
 */
?>
<script>(function(){try{var t=localStorage.getItem('theme');if(t==='dark'||t==='light')document.documentElement.classList.add(t+'-mode')}catch(e){}})();</script>
