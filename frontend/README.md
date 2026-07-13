# EGAR frontend workspaces

## Canonical workspace

Use `frontend/app` for all React builds:

```bash
bash dev/build-frontend.sh
```

or:

```bash
cd frontend/app
npm install
npm run build
```

The generated assets remain under `public/react-login/assets` for backward compatibility with the existing Vtiger templates. The public URL is intentionally unchanged in this migration so login, dashboard, Product list and Product detail routes continue to work without template changes.

## Compatibility source

`frontend/login/src` temporarily remains the source directory during the first migration stage. This prevents a large source move and build-path change from happening in the same release. `frontend/app/vite.config.js` is the canonical build configuration and consumes those source entries.

After this branch is validated in the local runtime, a separate cleanup branch can move `frontend/login/src` to `frontend/app/src`, update imports, and remove the compatibility workspace. That second step will not change the deployed asset URLs.

## Entries

- Login: `main.jsx`
- Dashboard: `dashboard.jsx`
- Product list: `product.jsx`
- Product detail: `product-detail.jsx`

## Runtime synchronization

`dev/sync-local.sh` excludes the entire `frontend` directory and synchronizes the compiled files in `public/react-login/assets`. This behavior remains unchanged.
