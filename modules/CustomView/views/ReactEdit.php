<?php

class CustomView_ReactEdit_View extends Vtiger_Index_View {
    public function preProcess(Vtiger_Request $request, $display = true) { return true; }
    public function postProcess(Vtiger_Request $request) { return true; }

    public function checkPermission(Vtiger_Request $request) {
        $sourceModule = $request->get('source_module');
        $module = Vtiger_Module_Model::getInstance($sourceModule);
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $sourceModule = $request->get('source_module');
        $record = $request->get('record');
        $moduleModel = Vtiger_Module_Model::getInstance($sourceModule);
        $recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceForModule($moduleModel);

        if (!empty($record)) {
            $customViewModel = CustomView_Record_Model::getInstanceById($record);
        } else {
            $customViewModel = new CustomView_Record_Model();
            $customViewModel->setModule($sourceModule);
        }

        $recordStructure = $recordStructureInstance->getStructure();
        if (in_array($sourceModule, getInventoryModules())) {
            unset($recordStructure['LBL_ITEM_DETAILS']);
        }

        $backUrl = $moduleModel->getListViewUrl();
        if ($sourceModule === 'Products') $backUrl = 'index.php?module=Products&view=ReactList';
        if ($sourceModule === 'Leads') $backUrl = 'index.php?module=Leads&view=ReactList';

        $viewer = $this->getViewer($request);
        $viewer->assign('SOURCE_MODULE', $sourceModule);
        $viewer->assign('SOURCE_MODULE_LABEL', vtranslate($moduleModel->get('label'), $sourceModule));
        $viewer->assign('MODULE', $request->getModule());
        $viewer->assign('RECORD_ID', $record);
        $viewer->assign('RECORD_STRUCTURE', $recordStructure);
        $viewer->assign('CUSTOMVIEW_MODEL', $customViewModel);
        $viewer->assign('SELECTED_FIELDS', $customViewModel->getSelectedFields());
        $viewer->assign('BACK_URL', $backUrl);
        $viewer->assign('CV_PRIVATE_VALUE', CustomView_Record_Model::CV_STATUS_PRIVATE);
        $viewer->assign('CV_PUBLIC_VALUE', CustomView_Record_Model::CV_STATUS_PUBLIC);
        $viewer->view('ReactEdit.tpl', 'CustomView');
    }
}
