#!/usr/bin/env bash
# Regeneriert die Profilfoto-Varianten (WebP + AVIF, 320w/640w/960w)
# aus dem PNG-Master oliver-eichhof.png (1024×1024, lossless).
#
# Qualität: Option B (visuelle Parität zum alten Stand)
#   WebP q=93    ~77 KB für 960w
#   AVIF q=80    ~40 KB für 960w
#
# Dependencies (macOS via Homebrew):
#   brew install webp libavif
# sips ist auf macOS vorinstalliert; auf Linux stattdessen z.B. ImageMagick.

set -euo pipefail
cd "$(dirname "$0")"

MASTER="oliver-eichhof.png"
[[ -f "$MASTER" ]] || { echo "Master $MASTER nicht gefunden"; exit 1; }

TMP=$(mktemp -d)
trap 'rm -rf "$TMP"' EXIT

# Zwischen-PNGs in Zielgrößen
sips -Z 320 --resampleWidth 320 "$MASTER" --out "$TMP/320.png" >/dev/null
sips -Z 640 --resampleWidth 640 "$MASTER" --out "$TMP/640.png" >/dev/null
sips -Z 960 --resampleWidth 960 "$MASTER" --out "$TMP/960.png" >/dev/null

# WebP (q=93 — nahe an originaler Qualität)
cwebp -quiet -q 93 "$TMP/320.png" -o oliver-eichhof-320.webp
cwebp -quiet -q 93 "$TMP/640.png" -o oliver-eichhof-640.webp
cwebp -quiet -q 93 "$TMP/960.png" -o oliver-eichhof.webp

# AVIF (q=80 — ~44% kleiner als WebP bei vergleichbarer Qualität)
avifenc -q 80 --speed 2 "$TMP/320.png" oliver-eichhof-320.avif >/dev/null
avifenc -q 80 --speed 2 "$TMP/640.png" oliver-eichhof-640.avif >/dev/null
avifenc -q 80 --speed 2 "$TMP/960.png" oliver-eichhof.avif >/dev/null

echo "OK — Varianten neu erzeugt:"
ls -la oliver-eichhof*.{avif,webp} | awk '{printf "  %-35s %6.1f KB\n", $NF, $5/1024}'
