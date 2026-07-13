<?php

class Leads_ReactList_View extends Vtiger_Index_View {
    public function preProcess(Vtiger_Request $request, $display = true) { return true; }
    public function postProcess(Vtiger_Request $request) { return true; }

    public function checkPermission(Vtiger_Request $request) {
        $module = Vtiger_Module_Model::getInstance('Leads');
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->view('ReactList.tpl', 'Leads');
    }
}
