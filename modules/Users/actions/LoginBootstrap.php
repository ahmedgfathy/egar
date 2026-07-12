<?php

class Users_LoginBootstrap_Action extends Vtiger_Action_Controller {

    public function loginRequired() {
        return false;
    }

    public function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request) {
        $response = new Vtiger_Response();
        try {
            $db = PearDatabase::getInstance();
            $result = $db->pquery('SELECT 1 AS connected', array());
            $connected = (int) $db->query_result($result, 0, 'connected') === 1;
            $response->setResult(array(
                'success' => $connected,
                'service' => 'EGAR CRM',
                'version' => vglobal('vtiger_current_version')
            ));
        } catch (Exception $exception) {
            $response->setResult(array('success' => false));
        }
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) {
        return true;
    }
}
