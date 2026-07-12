# Local WSL development and production deployment

Production currently runs Ubuntu 24.04, Apache 2.4, PHP 7.4 and MySQL 8.0.
Local WSL uses the already-established MariaDB installation (a supported MySQL
compatible database) to preserve other local CRM databases.

## One-time WSL setup

From the repository root:

```bash
sudo bash dev/setup-wsl.sh
```

Then import a **sanitized** database dump (never commit it):

```bash
mysql -u egar -pegar_local_dev egar < /path/to/sanitized-backup.sql
```

Open <http://localhost>. Local database, URL and filesystem values live in
the ignored `config.local.php`; production continues using its normal config.

Apache serves a fast Linux-filesystem runtime copy. After changing source files,
sync them with:

```bash
bash dev/sync-local.sh
```

Useful checks:

```bash
apache2ctl configtest
php -v
php -m
mysql --version
sudo tail -f /var/log/apache2/egar-local-error.log
```

## GitHub Actions deployment

The workflow deploys every push to `main` using a fast-forward-only update.
Add these GitHub repository Actions secrets:

- `PRODUCTION_HOST`: the production host/IP
- `PRODUCTION_USER`: `ubuntu`
- `PRODUCTION_SSH_KEY`: the complete private-key contents

Do not add the PEM file itself to Git. The production checkout must have a
working GitHub remote and its own deploy-key access to that private repository.

## Sensitive data

PEM keys, `config.local.php`, SQL dumps, uploads, logs, and caches are ignored.
The repository history currently contains database exports and credentials;
rotate exposed credentials and remove sensitive history before wider access.
