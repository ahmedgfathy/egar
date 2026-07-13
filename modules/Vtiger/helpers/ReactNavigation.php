<?php

class Egar_ReactNavigation_Helper {
    public static function getModules($currentModule = '') {
        $db = PearDatabase::getInstance();
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        $result = $db->pquery(
            "SELECT tabid, name, tablabel, parent, isentitytype
             FROM vtiger_tab
             WHERE presence IN (0, 2)
             ORDER BY tabsequence, tabid",
            array()
        );

        $modules = array();
        for ($index = 0; $index < $db->num_rows($result); $index++) {
            $name = $db->query_result($result, $index, 'name');
            if (in_array($name, array('Home', 'Import'))) continue;

            $module = Vtiger_Module_Model::getInstance($name);
            if (!$module || !$privileges->hasModulePermission($module->getId())) continue;

            $url = $module->getListViewUrl();
            if ($name === 'Dashboard') $url = 'index.php?module=Vtiger&view=ReactDashboard';
            if ($name === 'Products') $url = 'index.php?module=Products&view=ReactList';
            if ($name === 'Leads') $url = 'index.php?module=Leads&view=ReactList';

            $label = vtranslate($db->query_result($result, $index, 'tablabel'), $name);
            if ($name === 'Products') $label = 'Property';

            $modules[] = array(
                'name' => $name,
                'label' => decode_html($label),
                'group' => self::getGroup($db->query_result($result, $index, 'parent'), $name),
                'url' => $url,
                'icon' => self::getIcon($name),
                'isEntity' => (int) $db->query_result($result, $index, 'isentitytype') === 1,
                'active' => $name === $currentModule || ($currentModule === 'Vtiger' && $name === 'Dashboard')
            );
        }

        return $modules;
    }

    public static function getSettingsUrl() {
        return 'index.php?module=Vtiger&parent=Settings&view=ReactIndex';
    }

    public static function getIcon($moduleName) {
        $icons = array(
            'Dashboard' => 'dashboard',
            'Products' => 'apartment',
            'Leads' => 'group_add',
            'Contacts' => 'contacts',
            'Accounts' => 'business',
            'Potentials' => 'monitoring',
            'Calendar' => 'calendar_month',
            'Events' => 'event',
            'Documents' => 'description',
            'Reports' => 'bar_chart',
            'Project' => 'workspaces',
            'ProjectTask' => 'task_alt',
            'ProjectMilestone' => 'flag',
            'Campaigns' => 'campaign',
            'Quotes' => 'request_quote',
            'Invoice' => 'receipt_long',
            'SalesOrder' => 'shopping_cart',
            'PurchaseOrder' => 'assignment',
            'Vendors' => 'storefront',
            'Services' => 'home_repair_service',
            'Assets' => 'inventory_2',
            'HelpDesk' => 'support_agent',
            'Faq' => 'help',
            'PriceBooks' => 'price_change',
            'Emails' => 'mail',
            'Users' => 'manage_accounts'
        );
        return isset($icons[$moduleName]) ? $icons[$moduleName] : 'apps';
    }

    private static function getGroup($parent, $moduleName) {
        if ($moduleName === 'Dashboard') return 'Workspace';
        if (in_array($moduleName, array('Products', 'Leads', 'Contacts', 'Accounts', 'Potentials'))) return 'Sales';
        if (in_array($moduleName, array('Project', 'ProjectTask', 'ProjectMilestone', 'Calendar', 'Events', 'Documents'))) return 'Operations';
        if (in_array($moduleName, array('Reports', 'Campaigns'))) return 'Insights';
        return $parent ? decode_html($parent) : 'Other';
    }
}
