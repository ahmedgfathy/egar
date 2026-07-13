<?php
require_once 'modules/Vtiger/helpers/ReactNavigation.php';

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
        $tabId = getTabid('Products');
        $canEdit = $privileges->hasModuleActionPermission($tabId, 'EditView');
        $canImport = $privileges->hasModuleActionPermission($tabId, 'Import');
        $canExport = $privileges->hasModuleActionPermission($tabId, 'Export');
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

        $modules = Egar_ReactNavigation_Helper::getModules('Products');

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
            'canImport' => $canImport,
            'canExport' => $canExport,
            'createUrl' => 'index.php?module=Products&view=Edit',
            'importUrl' => 'index.php?module=Products&view=Import',
            'exportUrl' => 'index.php?module=Products&view=Export&viewname=' . $filterId,
            'legacyUrl' => 'index.php?module=Products&view=List&legacy=1&viewname=' . $filterId,
            'createFilterUrl' => 'index.php?module=CustomView&view=ReactEdit&source_module=Products',
            'dashboardUrl' => 'index.php?module=Vtiger&view=ReactDashboard',
            'settingsUrl' => Users_Record_Model::getCurrentUserModel()->isAdminUser() ? Egar_ReactNavigation_Helper::getSettingsUrl() : null
        ));
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
