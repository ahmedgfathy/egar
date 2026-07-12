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
        $limit = min(100, max(10, (int) $request->get('limit') ?: 25));
        $filterId = (int) $request->get('filter');
        $search = trim($request->get('search'));
        $alphabet = strtoupper(substr(trim($request->get('alphabet')), 0, 1));
        $sortBy = trim($request->get('sortBy'));
        $sortOrder = strtoupper(trim($request->get('sortOrder'))) === 'DESC' ? 'DESC' : 'ASC';

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
        $headers = $listModel->getListViewHeaders();
        if ($sortBy !== '' && isset($headers[$sortBy])) {
            $listModel->set('orderby', $sortBy);
            $listModel->set('sortorder', $sortOrder);
        } else {
            $sortBy = '';
        }
        if ($alphabet !== '' && preg_match('/^[A-Z]$/', $alphabet)) {
            $listModel->set('search_key', 'productname');
            $listModel->set('search_value', $alphabet);
            $listModel->set('operator', 's');
        } elseif ($search !== '') {
            $listModel->set('search_key', 'productname');
            $listModel->set('search_value', $search);
            $listModel->set('operator', 'c');
        }

        $paging = new Vtiger_Paging_Model();
        $paging->set('page', $page);
        $paging->set('limit', $limit);
        $paging->set('viewid', $filterId);
        $records = $listModel->getListViewEntries($paging);

        $filteredCount = 0;
        try {
            $filteredCount = (int) $listModel->getListViewCount();
        } catch (Throwable $countError) {
            $filteredCount = count($records) + (($page - 1) * $limit) + ($paging->isNextPageExists() ? 1 : 0);
        }
        $pageCount = max(1, (int) ceil($filteredCount / $limit));

        $headerPayload = array();
        foreach ($headers as $name => $field) {
            if (!$field) continue;
            $headerPayload[] = array(
                'name' => $name,
                'label' => vtranslate($field->get('label'), 'Products'),
                'sortable' => true,
                'type' => $field->getFieldDataType()
            );
        }

        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        $canEdit = $privileges->hasModuleActionPermission(getTabid('Products'), 'EditView');
        $rows = array();
        foreach ($records as $recordId => $record) {
            $values = array();
            foreach ($headers as $name => $field) {
                if (!$field) continue;
                $values[$name] = decode_html($field->getDisplayValue($record->get($name), $recordId, $record));
            }
            $reactDetailUrl = 'index.php?module=Products&view=ReactDetail&record=' . (int) $recordId;
            $legacyDetailUrl = 'index.php?module=Products&view=Detail&record=' . (int) $recordId . '&legacy=1';
            $rows[] = array(
                'id' => (int) $recordId,
                'values' => $values,
                'detailUrl' => $reactDetailUrl,
                'reactDetailUrl' => $reactDetailUrl,
                'legacyDetailUrl' => $legacyDetailUrl,
                'fullDetailUrl' => $legacyDetailUrl . '&mode=showDetailViewByMode&requestMode=full',
                'editUrl' => 'index.php?module=Products&view=Edit&record=' . (int) $recordId,
                'canEdit' => $canEdit
            );
        }

        $moduleDefinitions = array(
            array('name' => 'Products', 'label' => 'Property'),
            array('name' => 'Leads', 'label' => 'Leads'),
            array('name' => 'Contacts', 'label' => 'Contacts'),
            array('name' => 'Potentials', 'label' => 'Opportunities'),
            array('name' => 'Project', 'label' => 'Projects'),
            array('name' => 'Calendar', 'label' => 'Calendar'),
            array('name' => 'Documents', 'label' => 'Documents'),
            array('name' => 'Reports', 'label' => 'Reports'),
            array('name' => 'Campaigns', 'label' => 'Marketing')
        );
        $modules = array();
        foreach ($moduleDefinitions as $definition) {
            $module = Vtiger_Module_Model::getInstance($definition['name']);
            if (!$module || !$privileges->hasModulePermission($module->getId())) continue;
            $modules[] = array(
                'name' => $definition['name'],
                'label' => $definition['label'],
                'url' => $definition['name'] === 'Products' ? 'index.php?module=Products&view=ReactList' : $module->getListViewUrl()
            );
        }

        $db = PearDatabase::getInstance();
        $totalResult = $db->pquery(
            'SELECT COUNT(*) AS count FROM vtiger_products p INNER JOIN vtiger_crmentity e ON e.crmid=p.productid WHERE e.deleted=0',
            array()
        );
        $monthResult = $db->pquery(
            'SELECT COUNT(*) AS count FROM vtiger_products p INNER JOIN vtiger_crmentity e ON e.crmid=p.productid WHERE e.deleted=0 AND e.createdtime >= DATE_FORMAT(CURRENT_DATE, \'%Y-%m-01\')',
            array()
        );
        $totalProducts = (int) $db->query_result($totalResult, 0, 'count');
        $addedThisMonth = (int) $db->query_result($monthResult, 0, 'count');

        $response = new Vtiger_Response();
        $response->setResult(array(
            'filters' => $filterPayload,
            'activeFilter' => $filterId,
            'headers' => $headerPayload,
            'rows' => $rows,
            'modules' => $modules,
            'page' => $page,
            'limit' => $limit,
            'filteredCount' => $filteredCount,
            'pageCount' => $pageCount,
            'hasPrevious' => $page > 1,
            'hasNext' => $page < $pageCount,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder,
            'alphabet' => $alphabet,
            'metrics' => array(
                'total' => $totalProducts,
                'filtered' => $filteredCount,
                'visible' => count($rows),
                'addedThisMonth' => $addedThisMonth
            ),
            'canCreate' => $canEdit,
            'createUrl' => 'index.php?module=Products&view=Edit',
            'legacyUrl' => 'index.php?module=Products&view=List&viewname=' . $filterId,
            'dashboardUrl' => 'index.php?module=Vtiger&view=ReactDashboard'
        ));
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
