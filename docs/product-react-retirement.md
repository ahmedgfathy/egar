# Product React retirement audit

## Scope

The Products list and normal Products detail entry points are now owned by React:

- `index.php?module=Products&view=List` redirects to `Products&view=ReactList`.
- `index.php?module=Products&view=Detail&record=<id>` redirects to `Products&view=ReactDetail&record=<id>`.

Saved custom-view IDs are preserved when the old Product list URL contains `viewname`.

## Why shared Smarty templates were not deleted

Products did not have isolated legacy List/Detail Smarty implementations that could be removed safely. The old screens were rendered by shared templates under `layouts/vlayout/modules/Vtiger`. Those files remain active consumers for Leads, Contacts, Potentials, Projects, Calendar, Documents, Reports, administration surfaces, and other modules that have not yet been migrated to React.

Deleting shared Vtiger templates would break unrelated modules and is outside this cleanup scope.

## Preserved dependencies

The following Product functionality intentionally remains intact:

- Edit, Save and Delete actions.
- Popup and relation selection views.
- Related-list AJAX modes.
- PriceBooks and currency calculations.
- Product images, taxes and display-value conversion.
- Saved Vtiger filters and QueryGenerator behavior.
- Profile, field and record permissions.
- Workflows, events and database access.
- List-session previous/next navigation.

`Products_Detail_View` is retained only for internal Vtiger detail/related modes. Normal browser navigation is redirected to React before legacy Smarty rendering.

## Validation checklist

1. Open `Products&view=List`; confirm it redirects to `Products&view=ReactList` and preserves `viewname` as `filter`.
2. Open `Products&view=Detail&record=<id>`; confirm it redirects to `Products&view=ReactDetail&record=<id>`.
3. Test React list filters, sorting, alphabet filtering and pagination.
4. Test React detail fields, images and previous/next navigation.
5. Create and edit a Product using the existing Vtiger form.
6. Test Product popup selection from another module.
7. Test Product related lists and PriceBooks.
8. Test at least one unmigrated module list and detail screen to confirm shared Vtiger templates still work.
