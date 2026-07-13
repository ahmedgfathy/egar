# EGAR CRM

EGAR CRM is a customized real estate customer management system for handling properties, leads, contacts, documents, campaigns, reports, invoices, and user administration.

The application combines the existing PHP backend with a React-based user experience for the main CRM workflows. It is configured for a focused production setup with unused modules, legacy themes, and extra language packs removed.

## Main Features

- Property inventory and detail management
- Leads list, filters, saved filter preferences, and detail views
- Contacts and document management
- Campaigns, reports, invoices, and user settings
- React dashboard, module navigation, settings experience, and modern list/detail pages
- English and Arabic language support
- Single maintained legacy skin for backend compatibility

## Local Environment

Expected local stack:

- Ubuntu or WSL Ubuntu
- Apache
- MySQL
- PHP compatible with the current application setup
- Node.js for rebuilding React frontend assets

Common local database credentials used in this workspace:

```text
Database user: root
Database password: zerocall
```

## Frontend Build

React source files live in:

```text
frontend/login
```

Build frontend assets with:

```bash
cd frontend/login
npm run build
```

The built assets are written to:

```text
public/react-login/assets
```

## Runtime Notes

- Keep `config.inc.php`, `config.security.php`, and local database settings aligned with the target machine.
- Writable runtime/cache directories must remain writable by Apache.
- Only `en_us` and `ar_ae` language packs are kept.
- Removed legacy modules should not be reintroduced unless the database tables, permissions, navigation, layouts, and language files are restored together.

## Useful Maintenance Commands

Clear compiled templates:

```bash
find test/templates_c /tmp/egar-templates_c -type f -delete 2>/dev/null || true
```

Restart Apache:

```bash
sudo service apache2 restart
```
