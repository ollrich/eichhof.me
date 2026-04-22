<?php
/**
 * Pre-Paint Theme-Initialisierung
 * ================================
 * Liest die Theme-Präferenz aus localStorage und setzt die passende
 * Klasse auf <html>, bevor das erste Paint stattfindet. Verhindert
 * Theme-Flash beim Seitenaufruf (sowohl light→dark als auch dark→light).
 *
 * Muss synchron im <head> vor allen Stylesheets includet werden.
 * Der Script-Inhalt ist über SHA-256-Hash in der CSP whitelisted
 * (Hash: sha256-MCyEvVOO67rI0IwZN9PCA4aINLRDAhxFdM6P0A8p6R4=).
 * Der Script-Inhalt darf NICHT verändert werden, ohne auch den
 * CSP-Hash in .htaccess anzupassen.
 */
?>
<script>(function(){var t=localStorage.getItem('theme');if(t==='dark'||t==='light')document.documentElement.classList.add(t+'-mode');})();</script>
