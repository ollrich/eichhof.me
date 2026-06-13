<?php
/**
 * Pre-Paint Theme-Initialisierung
 * ================================
 * Liest die Theme-Präferenz aus localStorage und setzt die passende
 * Klasse auf <html>, bevor das erste Paint stattfindet. Verhindert
 * Theme-Flash beim Seitenaufruf (sowohl light→dark als auch dark→light).
 *
 * Setzt ausserdem html.eu-mode pre-paint (Profil-Umschalter Standard ↔
 * europäische Alternativen), damit die richtigen Buttons ohne Flash
 * erscheinen.
 *
 * Muss synchron im <head> vor allen Stylesheets includet werden.
 * Der Script-Inhalt ist über SHA-256-Hash in der CSP whitelisted
 * (Hash: sha256-X3wFpvvZ5OYG2+y6a6/fqNfdt2RZqkoaA4EwiHqSISs=).
 * Der Script-Inhalt darf NICHT verändert werden, ohne auch den
 * CSP-Hash in .htaccess anzupassen.
 */
?>
<script>(function(){var d=document.documentElement,t=localStorage.getItem('theme');if(t==='dark'||t==='light')d.classList.add(t+'-mode');if(localStorage.getItem('profiles')==='eu')d.classList.add('eu-mode');})();</script>
