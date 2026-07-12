<?php

class Products_ReactListData_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        $module = Vtiger_Module_Model::getInstance('Products');
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        try {
            $this->processRequest($request);
        } catch (Throwable $error) {
            $response = new Vtiger_Response();
            $response->setError('PROPERTY_LIST_FAILED', $error->getMessage());
            $response->emit();
        }
    }

    private function processRequest(Vtiger_Request $request) {
        $page = max(1, (int) $request->get('page'));
        $limit = min(50, max(10, (int) $request->get('limit') ?: 25));
        $filterId = (int) $request->get('filter');
        $search = trim($request->get('search'));

        $filters = CustomView_Record_Model::getAll('Products');
        $allowedFilters = array();
        $filterPayload = array();
        foreach ($filters as $filter) {
            $id = (int) $filter->getId();
            $allowedFilters[$id] = true;
            $filterPayload[] = array('id' => $id, 'name' => decode_html($filter->get('viewname')));
        }
        if (!$filterId || empty($allowedFilters[$filterId])) {
            $all = CustomView_Record_Model::getAllFilterByModule('Products');
            $filterId = $all ? (int) $all->getId() : (int) reset($filterPayload)['id'];
        }

        $listModel = Vtiger_ListView_Model::getInstance('Products', $filterId);
        if ($search !== '') {
            $listModel->set('search_key', 'productname');
            $listModel->set('search_value', $search);
            $listModel->set('operator', 'c');
        }
        $paging = new Vtiger_Paging_Model();
        $paging->set('page', $page);
        $paging->set('limit', $limit);
        $paging->set('viewid', $filterId);

        $headers = $listModel->getListViewHeaders();
        $records = $listModel->getListViewEntries($paging);
        $headerPayload = array();
        foreach ($headers as $name => $field) {
            if (!$field) continue;
            $headerPayload[] = array('name' => $name, 'label' => vtranslate($field->get('label'), 'Products'));
        }

        $rows = array();
        foreach ($records as $recordId => $record) {
            $values = array();
            foreach ($headers as $name => $field) {
                if (!$field) continue;
                $values[$name] = decode_html($field->getDisplayValue($record->get($name), $recordId, $record));
            }
            $rows[] = array(
                'id' => (int) $recordId,
                'values' => $values,
                'detailUrl' => 'index.php?module=Products&view=Detail&record=' . (int) $recordId,
                'editUrl' => 'index.php?module=Products&view=Edit&record=' . (int) $recordId
            );
        }

        $response = new Vtiger_Response();
        $response->setResult(array(
            'filters' => $filterPayload,
            'activeFilter' => $filterId,
            'headers' => $headerPayload,
            'rows' => $rows,
            'page' => $page,
            'hasNext' => $paging->isNextPageExists(),
            'canCreate' => Users_Privileges_Model::getCurrentUserPrivilegesModel()->hasModuleActionPermission(getTabid('Products'), 'EditView'),
            'createUrl' => 'index.php?module=Products&view=Edit',
            'legacyUrl' => 'index.php?module=Products&view=List&viewname=' . $filterId,
            'dashboardUrl' => 'index.php?module=Vtiger&view=ReactDashboard'
        ));
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
