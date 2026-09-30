#!/usr/bin/env bash
# Build a slim cPanel upload archive. Run from repo root: bash deploy/build-deploy.sh
# Produces deploy/deploy.tar.gz — cPanel File Manager > Extract handles .tar.gz.
set -euo pipefail
cd "$(dirname "$0")/.."

OUT=deploy/deploy.tar.gz
rm -f "$OUT"

# gzip -1: images/mp4 don't compress anyway; -1 keeps build fast. vendor/php text still shrinks.
GZIP=-1 tar -czf "$OUT" -X deploy/.deployignore \
  app bootstrap config database public routes storage vendor \
  artisan composer.json composer.lock package.json

echo "Built: $OUT"
du -sh "$OUT"
