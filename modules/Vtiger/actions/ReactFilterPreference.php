<?php

class Vtiger_ReactFilterPreference_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        $moduleName = $request->get('source_module');
        $module = Vtiger_Module_Model::getInstance($moduleName);
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        $moduleName = $request->get('source_module');
        $filterId = (int) $request->get('filter');
        $module = Vtiger_Module_Model::getInstance($moduleName);
        $response = new Vtiger_Response();

        try {
            if (!$filterId || !$module) {
                throw new AppException('Invalid filter preference');
            }

            $customView = CustomView_Record_Model::getInstanceById($filterId);
            if (!$customView || $customView->getModule()->get('name') !== $moduleName) {
                throw new AppException('Invalid filter for module');
            }

            $currentUser = Users_Record_Model::getCurrentUserModel();
            $db = PearDatabase::getInstance();
            $result = $db->pquery(
                'SELECT 1 FROM vtiger_user_module_preferences WHERE userid = ? AND tabid = ?',
                array($currentUser->getId(), $module->getId())
            );

            if ($db->num_rows($result)) {
                $db->pquery(
                    'UPDATE vtiger_user_module_preferences SET default_cvid = ? WHERE userid = ? AND tabid = ?',
                    array($filterId, $currentUser->getId(), $module->getId())
                );
            } else {
                $db->pquery(
                    'INSERT INTO vtiger_user_module_preferences(userid, tabid, default_cvid) VALUES (?,?,?)',
                    array($currentUser->getId(), $module->getId(), $filterId)
                );
            }

            $response->setResult(array('source_module' => $moduleName, 'filter' => $filterId));
        } catch (Throwable $error) {
            $response->setError('FILTER_PREFERENCE_FAILED', $error->getMessage());
        }

        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateWriteAccess();
    }
}
