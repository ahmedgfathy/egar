<?php

class Products_ReactDetail_View extends Vtiger_Index_View {
    public function checkPermission(Vtiger_Request $request) {
        $recordId = (int) $request->get('record');
        if (!$recordId || !Users_Privileges_Model::isPermitted('Products', 'DetailView', $recordId)) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->assign('RECORD_ID', (int) $request->get('record'));
        $viewer->view('ReactDetail.tpl', 'Products');
    }
}
