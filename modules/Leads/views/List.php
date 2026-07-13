<?php

class Leads_List_View extends Vtiger_List_View {
    public function checkPermission(Vtiger_Request $request) {
        $module = Vtiger_Module_Model::getInstance('Leads');
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        if ($request->get('legacy')) {
            return parent::preProcess($request, $display);
        }
        $query = array('module' => 'Leads', 'view' => 'ReactList');
        $viewName = (int) $request->get('viewname');
        if ($viewName) $query['filter'] = $viewName;
        header('Location: index.php?' . http_build_query($query));
        exit;
    }

    public function process(Vtiger_Request $request) {
        if ($request->get('legacy')) {
            return parent::process($request);
        }
    }
}
