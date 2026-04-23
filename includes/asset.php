<?php
/**
 * Asset-Versionierung via filemtime()
 * ====================================
 * Hängt die letzte Änderungszeit der Datei als Query-String an, damit
 * Browser nach einem Deploy die neue Version laden statt die gecachte.
 * Ersetzt das manuelle `?v=N`-Bumpen bei jeder CSS/JS-Änderung.
 *
 * Fällt still auf den unversionierten Pfad zurück, wenn die Datei nicht
 * gefunden wird (z. B. fehlerhafter Pfad).
 */

function asset($path) {
    static $root = null;
    if ($root === null) $root = realpath(__DIR__ . '/..');
    $mtime = @filemtime($root . $path);
    return $path . ($mtime ? '?v=' . $mtime : '');
}
