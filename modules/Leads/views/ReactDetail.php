<?php

class Leads_ReactDetail_View extends Vtiger_Index_View {
    public function preProcess(Vtiger_Request $request, $display = true) { return true; }
    public function postProcess(Vtiger_Request $request) { return true; }

    public function checkPermission(Vtiger_Request $request) {
        $recordId = (int) $request->get('record');
        if (!$recordId || !Users_Privileges_Model::isPermitted('Leads', 'DetailView', $recordId)) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->assign('RECORD_ID', (int) $request->get('record'));
        $viewer->view('ReactDetail.tpl', 'Leads');
    }
}
