<?php

class Settings_Vtiger_ReactIndex_View extends Vtiger_Index_View {
    public function checkPermission(Vtiger_Request $request) {
        if (!Users_Record_Model::getCurrentUserModel()->isAdminUser()) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED', 'Vtiger'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->view('ReactIndex.tpl', 'Settings:Vtiger');
    }

    public function preProcess(Vtiger_Request $request, $display = true) {
        return true;
    }

    public function postProcess(Vtiger_Request $request) {
        return true;
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateReadAccess();
    }
}
