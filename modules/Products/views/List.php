<?php

/**
 * Product list entry point.
 *
 * Products has been migrated to the React list. The legacy List view used the
 * shared Vtiger list templates, which cannot be deleted because other modules
 * still depend on them. Redirect only the Products route and leave the shared
 * framework intact.
 */
class Products_List_View extends Vtiger_List_View {
    public function checkPermission(Vtiger_Request $request) {
        $module = Vtiger_Module_Model::getInstance('Products');
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        $query = array('module' => 'Products', 'view' => 'ReactList');
        $viewName = (int) $request->get('viewname');
        if ($viewName) {
            $query['filter'] = $viewName;
        }

        header('Location: index.php?' . http_build_query($query));
        exit;
    }

    public function process(Vtiger_Request $request) {
        // preProcess performs the redirect before legacy Smarty rendering.
    }
}
