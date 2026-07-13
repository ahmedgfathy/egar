#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
APP_ROOT="$ROOT/frontend/app"
ASSET_ROOT="$ROOT/public/react-login/assets"

if [[ ! -f "$APP_ROOT/package.json" ]]; then
  echo "Missing canonical frontend workspace: $APP_ROOT" >&2
  exit 1
fi

rm -rf "$ASSET_ROOT"
npm --prefix "$APP_ROOT" install
npm --prefix "$APP_ROOT" run build

for asset in login.js dashboard.js product.js product-detail.js leads.js lead-detail.js; do
  if [[ ! -s "$ASSET_ROOT/$asset" ]]; then
    echo "Frontend build failed: missing $ASSET_ROOT/$asset" >&2
    exit 1
  fi
done

echo "React frontend built successfully from frontend/app"
