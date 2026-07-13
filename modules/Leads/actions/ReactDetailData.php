<?php

class Leads_ReactDetailData_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        $recordId = (int) $request->get('record');
        if (!$recordId || !Users_Privileges_Model::isPermitted('Leads', 'DetailView', $recordId)) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        try {
            $recordId = (int) $request->get('record');
            $record = Vtiger_Record_Model::getInstanceById($recordId, 'Leads');
            $structure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel(
                $record,
                Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL
            )->getStructure();

            $blocks = array();
            foreach ($structure as $blockLabel => $fields) {
                $fieldPayload = array();
                foreach ($fields as $fieldName => $field) {
                    if (!$field) continue;
                    $fieldPayload[] = array(
                        'name' => $fieldName,
                        'label' => vtranslate($field->get('label'), 'Leads'),
                        'value' => decode_html($field->getDisplayValue($record->get($fieldName), $recordId, $record)),
                        'type' => $field->getFieldDataType()
                    );
                }
                if ($fieldPayload) {
                    $blocks[] = array('label' => vtranslate($blockLabel, 'Leads'), 'fields' => $fieldPayload);
                }
            }

            $navigation = ListViewSession::getListViewNavigation($recordId);
            $previousId = null;
            $nextId = null;
            $found = false;
            foreach ((array) $navigation as $pageInfo) {
                foreach ((array) $pageInfo as $candidateId) {
                    if ($found) { $nextId = (int) $candidateId; break 2; }
                    if ((int) $candidateId === $recordId) { $found = true; continue; }
                    if (!$found) $previousId = (int) $candidateId;
                }
            }

            $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();
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

            $name = trim($record->get('firstname') . ' ' . $record->get('lastname'));
            if ($name === '') $name = $record->getName();

            $response = new Vtiger_Response();
            $response->setResult(array(
                'id' => $recordId,
                'name' => decode_html($name),
                'number' => decode_html($record->get('lead_no')),
                'blocks' => $blocks,
                'modules' => $modules,
                'canEdit' => $record->isEditable('Leads'),
                'canDelete' => $record->isDeletable('Leads'),
                'editUrl' => 'index.php?module=Leads&view=Edit&record=' . $recordId,
                'legacyDetailUrl' => 'index.php?module=Leads&view=Detail&record=' . $recordId . '&legacy=1&mode=showDetailViewByMode&requestMode=full',
                'listUrl' => 'index.php?module=Leads&view=ReactList',
                'previousUrl' => $previousId ? 'index.php?module=Leads&view=ReactDetail&record=' . $previousId : null,
                'nextUrl' => $nextId ? 'index.php?module=Leads&view=ReactDetail&record=' . $nextId : null
            ));
            $response->emit();
        } catch (Throwable $error) {
            $response = new Vtiger_Response();
            $response->setError('LEAD_DETAIL_FAILED', $error->getMessage());
            $response->emit();
        }
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
