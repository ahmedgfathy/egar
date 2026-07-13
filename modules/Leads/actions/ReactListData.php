<?php

class Leads_ReactListData_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        $module = Vtiger_Module_Model::getInstance('Leads');
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        if (!$module || !$privileges->hasModulePermission($module->getId())) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        try {
            $page = max(1, (int) $request->get('page'));
            $limit = min(100, max(10, (int) $request->get('limit') ?: 25));
            $filterId = (int) $request->get('filter');
            $search = trim($request->get('search'));
            $alphabet = strtoupper(substr(trim($request->get('alphabet')), 0, 1));
            $sortBy = trim($request->get('sortBy'));
            $sortOrder = strtoupper(trim($request->get('sortOrder'))) === 'DESC' ? 'DESC' : 'ASC';

            $filters = CustomView_Record_Model::getAll('Leads');
            $allowedFilters = array();
            $filterPayload = array();
            foreach ($filters as $filter) {
                $id = (int) $filter->getId();
                $allowedFilters[$id] = true;
                $filterPayload[] = array('id' => $id, 'name' => decode_html($filter->get('viewname')));
            }
            if (!$filterId || empty($allowedFilters[$filterId])) {
                $all = CustomView_Record_Model::getAllFilterByModule('Leads');
                $filterId = $all ? (int) $all->getId() : (!empty($filterPayload) ? (int) $filterPayload[0]['id'] : 0);
            }

            $listModel = Vtiger_ListView_Model::getInstance('Leads', $filterId);
            $headers = $listModel->getListViewHeaders();
            if ($sortBy !== '' && isset($headers[$sortBy])) {
                $listModel->set('orderby', $sortBy);
                $listModel->set('sortorder', $sortOrder);
            } else {
                $sortBy = '';
            }
            if ($alphabet !== '' && preg_match('/^[A-Z]$/', $alphabet)) {
                $listModel->set('search_key', 'lastname');
                $listModel->set('search_value', $alphabet);
                $listModel->set('operator', 's');
            } elseif ($search !== '') {
                $listModel->set('search_key', 'lastname');
                $listModel->set('search_value', $search);
                $listModel->set('operator', 'c');
            }

            $paging = new Vtiger_Paging_Model();
            $paging->set('page', $page);
            $paging->set('limit', $limit);
            $paging->set('viewid', $filterId);
            $records = $listModel->getListViewEntries($paging);

            try {
                $filteredCount = (int) $listModel->getListViewCount();
            } catch (Throwable $countError) {
                $filteredCount = count($records) + (($page - 1) * $limit) + ($paging->isNextPageExists() ? 1 : 0);
            }
            $pageCount = max(1, (int) ceil($filteredCount / $limit));

            $headerPayload = array();
            foreach ($headers as $name => $field) {
                if (!$field) continue;
                $headerPayload[] = array('name' => $name, 'label' => vtranslate($field->get('label'), 'Leads'), 'sortable' => true, 'type' => $field->getFieldDataType());
            }

            $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
            $tabId = getTabid('Leads');
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
                $rows[] = array(
                    'id' => (int) $recordId,
                    'values' => $values,
                    'detailUrl' => 'index.php?module=Leads&view=ReactDetail&record=' . (int) $recordId,
                    'editUrl' => 'index.php?module=Leads&view=Edit&record=' . (int) $recordId,
                    'canEdit' => $canEdit
                );
            }

            $definitions = array(
                array('Products', 'Property'), array('Leads', 'Leads'), array('Contacts', 'Contacts'),
                array('Potentials', 'Opportunities'), array('Project', 'Projects'), array('Calendar', 'Calendar'),
                array('Documents', 'Documents'), array('Reports', 'Reports')
            );
            $modules = array();
            foreach ($definitions as $definition) {
                $module = Vtiger_Module_Model::getInstance($definition[0]);
                if (!$module || !$privileges->hasModulePermission($module->getId())) continue;
                $url = $module->getListViewUrl();
                if ($definition[0] === 'Products') $url = 'index.php?module=Products&view=ReactList';
                if ($definition[0] === 'Leads') $url = 'index.php?module=Leads&view=ReactList';
                $modules[] = array('name' => $definition[0], 'label' => $definition[1], 'url' => $url);
            }

            $db = PearDatabase::getInstance();
            $totalResult = $db->pquery("SELECT COUNT(*) AS count FROM vtiger_crmentity WHERE deleted=0 AND setype='Leads'", array());
            $monthResult = $db->pquery("SELECT COUNT(*) AS count FROM vtiger_crmentity WHERE deleted=0 AND setype='Leads' AND createdtime >= DATE_FORMAT(CURRENT_DATE, '%Y-%m-01')", array());

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
                    'total' => (int) $db->query_result($totalResult, 0, 'count'),
                    'filtered' => $filteredCount,
                    'visible' => count($rows),
                    'addedThisMonth' => (int) $db->query_result($monthResult, 0, 'count')
                ),
                'canCreate' => $canEdit,
                'canImport' => $canImport,
                'canExport' => $canExport,
                'createUrl' => 'index.php?module=Leads&view=Edit',
                'importUrl' => 'index.php?module=Leads&view=Import',
                'exportUrl' => 'index.php?module=Leads&view=Export&viewname=' . $filterId,
                'createFilterUrl' => 'index.php?module=CustomView&view=ReactEdit&source_module=Leads',
                'legacyUrl' => 'index.php?module=Leads&view=List&legacy=1&viewname=' . $filterId,
                'dashboardUrl' => 'index.php?module=Vtiger&view=ReactDashboard'
            ));
            $response->emit();
        } catch (Throwable $error) {
            $response = new Vtiger_Response();
            $response->setError('LEAD_LIST_FAILED', $error->getMessage());
            $response->emit();
        }
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
