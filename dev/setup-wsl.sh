#!/usr/bin/env bash
set -euo pipefail

if [[ ${EUID} -ne 0 ]]; then
  echo "Run this script with sudo: sudo bash dev/setup-wsl.sh" >&2
  exit 1
fi

PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
REAL_PROJECT_ROOT="$(realpath "$PROJECT_ROOT")"
DEV_USER="${SUDO_USER:-$USER}"

apt-get update
apt-get install -y software-properties-common ca-certificates curl
add-apt-repository -y ppa:ondrej/php
apt-get update
DEBIAN_FRONTEND=noninteractive apt-get install -y \
  apache2 mariadb-server libapache2-mod-php7.4 php7.4-cli php7.4-common \
  php7.4-curl php7.4-gd php7.4-imap php7.4-intl php7.4-mbstring \
  php7.4-mysql php7.4-soap php7.4-xml php7.4-zip

sed "s|__PROJECT_ROOT__|$REAL_PROJECT_ROOT|g" \
  "$PROJECT_ROOT/dev/apache-vtiger.conf.template" \
  > /etc/apache2/sites-available/egar-local.conf
install -m 0644 "$PROJECT_ROOT/dev/php-vtiger.ini" /etc/php/7.4/apache2/conf.d/99-vtiger.ini

a2enmod rewrite
a2ensite egar-local.conf
a2dissite 000-default.conf || true

if ! grep -qE '^[[:space:]]*127\.0\.0\.1[[:space:]].*\begar\.local\b' /etc/hosts; then
  printf '127.0.0.1 egar.local\n' >> /etc/hosts
fi

if [[ "$(ps -p 1 -o comm=)" == "systemd" ]]; then
  systemctl enable --now mariadb apache2
else
  service mariadb start
  service apache2 start
fi

DB_ADMIN=(mariadb --user=root)
if ! "${DB_ADMIN[@]}" --execute='SELECT 1' >/dev/null 2>&1; then
  read -r -s -p 'Existing MariaDB root password: ' DB_ROOT_PASSWORD
  echo
  DB_ADMIN+=(--password="$DB_ROOT_PASSWORD")
fi

"${DB_ADMIN[@]}" <<'SQL'
CREATE DATABASE IF NOT EXISTS egar CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE USER IF NOT EXISTS 'egar'@'localhost' IDENTIFIED BY 'egar_local_dev';
ALTER USER 'egar'@'localhost' IDENTIFIED BY 'egar_local_dev';
GRANT ALL PRIVILEGES ON egar.* TO 'egar'@'localhost';
FLUSH PRIVILEGES;
SQL

cat > "$PROJECT_ROOT/config.local.php" <<PHP
<?php
\$dbconfig['db_server'] = 'localhost';
\$dbconfig['db_port'] = ':3306';
\$dbconfig['db_username'] = 'egar';
\$dbconfig['db_password'] = 'egar_local_dev';
\$dbconfig['db_name'] = 'egar';
\$site_URL = 'http://localhost';
\$root_directory = '${REAL_PROJECT_ROOT}/';
PHP
chown "$DEV_USER":"$(id -gn "$DEV_USER")" "$PROJECT_ROOT/config.local.php"

mkdir -p "$PROJECT_ROOT/cache/images" "$PROJECT_ROOT/cache/import" "$PROJECT_ROOT/cache/upload" \
  "$PROJECT_ROOT/storage" "$PROJECT_ROOT/test/templates_c/vlayout"
chown -R "$DEV_USER":www-data "$PROJECT_ROOT/cache" "$PROJECT_ROOT/storage" "$PROJECT_ROOT/test/templates_c"
chmod -R a+rwX "$PROJECT_ROOT/cache" "$PROJECT_ROOT/storage" "$PROJECT_ROOT/test/templates_c" "$PROJECT_ROOT/user_privileges"

apache2ctl configtest
if [[ "$(ps -p 1 -o comm=)" == "systemd" ]]; then
  systemctl restart apache2
else
  service apache2 restart
fi

echo "Local stack is ready at http://localhost"
echo "Import a sanitized database with: mysql -u egar -pegar_local_dev egar < backup.sql"
