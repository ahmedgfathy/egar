<?php
require_once 'modules/Vtiger/helpers/ReactNavigation.php';

class Settings_Vtiger_ReactData_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        if (!Users_Record_Model::getCurrentUserModel()->isAdminUser()) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        try {
            $settingsModel = Settings_Vtiger_Module_Model::getInstance();
            $menus = array();
            $totalItems = 0;
            foreach ($settingsModel->getMenus() as $menu) {
                $items = array();
                foreach ($menu->getMenuItems() as $item) {
                    $items[] = $this->formatItem($item);
                    $totalItems++;
                }
                $menus[] = array(
                    'id' => (int) $menu->getId(),
                    'label' => decode_html(vtranslate($menu->getLabel(), 'Settings:Vtiger')),
                    'rawLabel' => $menu->getLabel(),
                    'items' => $items
                );
            }

            $shortcuts = array();
            foreach (Settings_Vtiger_MenuItem_Model::getPinnedItems() as $item) {
                $shortcuts[] = $this->formatItem($item);
            }

            $response = new Vtiger_Response();
            $response->setResult(array(
                'modules' => Egar_ReactNavigation_Helper::getModules('Settings'),
                'settingsUrl' => Egar_ReactNavigation_Helper::getSettingsUrl(),
                'legacyUsersUrl' => 'index.php?module=Users&parent=Settings&view=List',
                'extensionStoreUrl' => null,
                'menus' => $menus,
                'shortcuts' => $shortcuts,
                'metrics' => array(
                    'activeUsers' => Users_Record_Model::getCount(true),
                    'activeWorkflows' => Settings_Workflows_Module_Model::getActiveWorkflowCount(),
                    'activeModules' => Settings_ModuleManager_Module_Model::getModulesCount(true),
                    'settingItems' => $totalItems
                )
            ));
            $response->emit();
        } catch (Throwable $error) {
            $response = new Vtiger_Response();
            $response->setError('SETTINGS_REACT_FAILED', $error->getMessage());
            $response->emit();
        }
    }

    private function formatItem($item) {
        $rawUrl = decode_html($item->get('linkto'));
        $moduleName = $this->getModuleFromUrl($rawUrl);
        return array(
            'id' => (int) $item->getId(),
            'blockId' => (int) $item->get('blockid'),
            'name' => decode_html(vtranslate($item->get('name'), $moduleName)),
            'rawName' => $item->get('name'),
            'description' => decode_html(vtranslate($item->get('description'), $moduleName)),
            'url' => $item->getUrl(),
            'rawUrl' => $rawUrl,
            'module' => $moduleName,
            'pinned' => $item->isPinned(),
            'pinUrl' => $item->getPinUnpinActionUrl(),
            'icon' => $this->getIcon($item->get('name'), $moduleName)
        );
    }

    private function getModuleFromUrl($url) {
        $query = parse_url(htmlspecialchars_decode($url), PHP_URL_QUERY);
        $params = array();
        parse_str($query, $params);
        if (!empty($params['parent']) && !empty($params['module'])) {
            return $params['parent'] . ':' . $params['module'];
        }
        return !empty($params['module']) ? $params['module'] : 'Settings:Vtiger';
    }

    private function getIcon($name, $moduleName) {
        $key = strtolower($name . ' ' . $moduleName);
        $map = array(
            'user' => 'manage_accounts',
            'role' => 'admin_panel_settings',
            'profile' => 'verified_user',
            'group' => 'groups',
            'sharing' => 'share',
            'field' => 'view_column',
            'login' => 'history',
            'module' => 'extension',
            'picklist' => 'list_alt',
            'menu' => 'menu_open',
            'notification' => 'notifications',
            'company' => 'apartment',
            'server' => 'dns',
            'currency' => 'payments',
            'tax' => 'percent',
            'proxy' => 'lan',
            'announcement' => 'campaign',
            'workflow' => 'account_tree',
            'cron' => 'schedule',
            'mail' => 'mail',
            'portal' => 'language',
            'webform' => 'dynamic_form',
            'sms' => 'sms',
            'inventory' => 'inventory_2'
        );
        foreach ($map as $needle => $icon) {
            if (strpos($key, $needle) !== false) return $icon;
        }
        return 'settings';
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateReadAccess();
    }
}
