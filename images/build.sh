#!/usr/bin/env bash
# Regeneriert die Profilfoto-Varianten (WebP + AVIF, 320w/640w/920w)
# aus dem PNG-Master oliver-eichhof.png (920×920, lossless, korrekter Ausschnitt).
#
# Pipeline:
#   ffmpeg scale=...:flags=lanczos   — hochwertiger Downscale (deutlich schärfer als sips)
#   unsharp=3:3:0.4 / 0.3            — dezenter Post-Sharpen nur bei 320w/640w
#                                      (ohne leiden kleine Varianten unter der
#                                       Weichheit des Downscales)
#   cwebp  -q 93                     — WebP nahe an Original-Qualität (~99 KB @ 920w)
#   avifenc -q 80 --speed 2          — AVIF ~54 KB @ 920w bei visueller Parität
#
# Dependencies (macOS via Homebrew):
#   brew install ffmpeg webp libavif

set -euo pipefail
cd "$(dirname "$0")"

MASTER="oliver-eichhof.png"
[[ -f "$MASTER" ]] || { echo "Master $MASTER nicht gefunden"; exit 1; }

TMP=$(mktemp -d)
trap 'rm -rf "$TMP"' EXIT

# Zwischen-PNGs: Lanczos-Downscale + leichtes Sharpen für die kleinen Varianten.
# Das 920er bleibt unangetastet — wäre eine Identitäts-Skalierung.
ffmpeg -y -loglevel error -i "$MASTER" \
    -vf "scale=320:320:flags=lanczos,unsharp=3:3:0.4:3:3:0.0" "$TMP/320.png"
ffmpeg -y -loglevel error -i "$MASTER" \
    -vf "scale=640:640:flags=lanczos,unsharp=3:3:0.3:3:3:0.0" "$TMP/640.png"
cp "$MASTER" "$TMP/920.png"

# WebP (q=93 — nahe an originaler Qualität)
cwebp -quiet -q 93 "$TMP/320.png" -o oliver-eichhof-320.webp
cwebp -quiet -q 93 "$TMP/640.png" -o oliver-eichhof-640.webp
cwebp -quiet -q 93 "$TMP/920.png" -o oliver-eichhof.webp

# AVIF (q=80 — ~45% kleiner als WebP bei vergleichbarer Qualität)
avifenc -q 80 --speed 2 "$TMP/320.png" oliver-eichhof-320.avif >/dev/null
avifenc -q 80 --speed 2 "$TMP/640.png" oliver-eichhof-640.avif >/dev/null
avifenc -q 80 --speed 2 "$TMP/920.png" oliver-eichhof.avif >/dev/null

echo "OK — Varianten neu erzeugt:"
ls -la oliver-eichhof*.{avif,webp} | awk '{printf "  %-35s %6.1f KB\n", $NF, $5/1024}'
