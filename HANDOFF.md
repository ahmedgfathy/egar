# EGAR CRM modernization handoff

## Non-negotiable operating rules

1. **Production approval:** never synchronize, deploy, pull, migrate, restart, or
   otherwise change the production server until the owner is shown the exact
   scope and explicitly approves that specific action. Local runtime sync is not
   production deployment.
2. **Dependency-first React replacement:** before replacing a legacy screen,
   trace its PHP controller, Smarty includes, JavaScript/CSS, CSRF, permissions,
   sessions, workflows, and module dependencies across the project. Keep the
   legacy screen during testing. Remove it only when the React replacement has
   equivalent behavior, no remaining consumers, and explicit owner acceptance.

## Architecture

- Source repository: `/mnt/c/Users/ahmed/Downloads/egar/egar`
- Fast local Apache runtime: `/home/xinreal/egar-runtime`
- Local URL: `http://localhost`
- Backend: Vtiger 6.5, PHP 7.4, Apache 2.4
- Local database: MariaDB 12.3 (`egar` database)
- Production database: MySQL 8; production remains authoritative
- React is introduced screen-by-screen while Vtiger retains authentication,
  authorization, business logic, workflows, and database access.

## Completed React migration

### Login

- React source: `frontend/login/src/main.jsx`
- Styles: `frontend/login/src/styles.css`
- Vtiger host template: `layouts/vlayout/modules/Users/Login.Custom.tpl`
- Health API: `modules/Users/actions/LoginBootstrap.php`
- Built assets: `public/react-login/assets/`
- Authentication still posts to `Users_Login_Action`; Vtiger owns passwords,
  CSRF, sessions, login history, and redirects.
- The superseded `Login.Default.tpl` was removed after local validation.

### CRM shell/dashboard

- React source: `frontend/login/src/dashboard.jsx`
- Styles: `frontend/login/src/dashboard.css`
- Vtiger view/template: `Vtiger_ReactDashboard_View` / `ReactDashboard.tpl`
- Authenticated API: `Vtiger_ReactBootstrap_Action`
- Successful login routes to the React dashboard.
- Legacy modules remain linked and available for comparison/testing.

### Product/Property list

- React source: `frontend/login/src/product.jsx`
- Styles: `frontend/login/src/product.css`
- Vtiger view/template: `Products_ReactList_View` / `ReactList.tpl`
- Authenticated data action: `Products_ReactListData_Action`
- Route: `index.php?module=Products&view=ReactList`
- Reuses Vtiger's Product list model, QueryGenerator, saved custom views,
  profile field visibility, display-value conversion, paging, permissions, and
  Product-specific list overrides.
- Supports saved-filter selection, including filter 546 (`test2`), dynamic
  headers, Product-name search, paging, create/edit/detail links, responsive
  navigation, and a link to compare the legacy list.
- Legacy Product List/Edit/Detail, popup, relation, currencies, save, and mass
  action code remains in place pending behavioral acceptance and later React
  migrations.

## Build and local synchronization

```bash
cd frontend/login
npm install
npm run build
cd ../..
bash dev/sync-local.sh
```

`dev/sync-local.sh` only copies source into the local Linux runtime. It never
contacts GitHub or production.

## Local stack notes

- Apache serves the Linux runtime for speed; serving thousands of PHP files from
  `/mnt/c` was approximately 12 times slower.
- Start classic WSL services with `sudo service mariadb start` and
  `sudo service apache2 start`.
- Generated data/config remains ignored: local config, CSRF secret, PEM files,
  SQL dumps, Smarty compiled templates, caches, logs, and user privilege files.

## Current validation baseline

- React login and CSRF POST work.
- PHP/database health API returns Vtiger 6.5.0.
- Database contains 588 tables.
- Product filter 546 resolves headers `cf_832`, `product_no`, and `cf_751`.
- Production has not received these changes.

## Migration sequence

1. React shell/dashboard and navigation.
2. Product/Property list and saved filters.
3. Product/Property detail and edit forms.
4. Shared list/detail/edit components for other modules.
5. Settings/admin surfaces last due to their broad permission dependencies.
