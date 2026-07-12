#!/usr/bin/env bash
set -euo pipefail

SOURCE_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
RUNTIME_ROOT="${EGAR_RUNTIME_ROOT:-$HOME/egar-runtime}"

mkdir -p "$RUNTIME_ROOT"
rsync -a --delete \
  --exclude='.git/' \
  --exclude='frontend/' \
  --exclude='node_modules/' \
  --exclude='mcp/' \
  --exclude='*.pem' \
  --exclude='*.sql' \
  --exclude='config.local.php' \
  --exclude='config.csrf-secret.php' \
  --exclude='/cache/' \
  "$SOURCE_ROOT/" "$RUNTIME_ROOT/"

mkdir -p "$RUNTIME_ROOT/cache/images" "$RUNTIME_ROOT/cache/import" \
  "$RUNTIME_ROOT/cache/upload" "$RUNTIME_ROOT/test/templates_c/vlayout"
chmod -R a+rwX "$RUNTIME_ROOT/cache" "$RUNTIME_ROOT/storage" \
  "$RUNTIME_ROOT/test/templates_c" "$RUNTIME_ROOT/user_privileges"

install -m 0660 "$SOURCE_ROOT/config.csrf-secret.php" "$RUNTIME_ROOT/config.csrf-secret.php"
cat > "$RUNTIME_ROOT/config.local.php" <<PHP
<?php
\$dbconfig['db_server'] = 'localhost';
\$dbconfig['db_port'] = ':3306';
\$dbconfig['db_username'] = 'egar';
\$dbconfig['db_password'] = 'egar_local_dev';
\$dbconfig['db_name'] = 'egar';
\$site_URL = 'http://localhost';
\$root_directory = '${RUNTIME_ROOT}/';
PHP

echo "Synced local runtime to $RUNTIME_ROOT"
