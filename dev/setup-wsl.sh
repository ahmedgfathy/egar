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
apt-get install -y software-properties-common ca-certificates curl gnupg
source /etc/os-release
if [[ "${VERSION_CODENAME:-}" == "resolute" ]]; then
  install -d -m 0755 /etc/apt/keyrings
  curl -fsSL https://packages.sury.org/php/apt.gpg -o /tmp/sury-php.gpg.asc
  gpg --dearmor --yes -o /tmp/sury-php.gpg /tmp/sury-php.gpg.asc
  install -m 0644 /tmp/sury-php.gpg /etc/apt/keyrings/sury-php.gpg
  echo "deb [signed-by=/etc/apt/keyrings/sury-php.gpg] https://packages.sury.org/php/ resolute main" \
    > /etc/apt/sources.list.d/sury-php.list
else
  add-apt-repository -y ppa:ondrej/php
fi
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

DB_NAME="${EGAR_DB_NAME:-egar}"
DB_USER="${EGAR_DB_USER:-root}"
DB_PASSWORD="${EGAR_DB_PASSWORD:-zerocall}"

"${DB_ADMIN[@]}" <<SQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\` CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER USER 'root'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
FLUSH PRIVILEGES;
SQL

if [[ "$DB_USER" != "root" ]]; then
  mariadb --user=root --password="$DB_PASSWORD" <<SQL
CREATE USER IF NOT EXISTS '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
ALTER USER '${DB_USER}'@'localhost' IDENTIFIED BY '${DB_PASSWORD}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'localhost';
FLUSH PRIVILEGES;
SQL
fi

cat > "$PROJECT_ROOT/config.local.php" <<PHP
<?php
\$dbconfig['db_server'] = 'localhost';
\$dbconfig['db_port'] = ':3306';
\$dbconfig['db_username'] = '${DB_USER}';
\$dbconfig['db_password'] = '${DB_PASSWORD}';
\$dbconfig['db_name'] = '${DB_NAME}';
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
echo "Import a database with: mysql -u ${DB_USER} -p${DB_PASSWORD} ${DB_NAME} < backup.sql"
