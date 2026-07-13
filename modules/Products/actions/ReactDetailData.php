<?php

class Products_ReactDetailData_Action extends Vtiger_Action_Controller {
    public function checkPermission(Vtiger_Request $request) {
        $recordId = (int) $request->get('record');
        if (!$recordId || !Users_Privileges_Model::isPermitted('Products', 'DetailView', $recordId)) {
            throw new AppException(vtranslate('LBL_PERMISSION_DENIED'));
        }
        return true;
    }

    public function process(Vtiger_Request $request) {
        try {
            $recordId = (int) $request->get('record');
            $record = Vtiger_Record_Model::getInstanceById($recordId, 'Products');
            $structure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel(
                $record,
                Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL
            )->getStructure();

            $blocks = array();
            foreach ($structure as $blockLabel => $fields) {
                $fieldPayload = array();
                foreach ($fields as $fieldName => $field) {
                    if (!$field) continue;
                    $rawValue = $record->get($fieldName);
                    $fieldPayload[] = array(
                        'name' => $fieldName,
                        'label' => vtranslate($field->get('label'), 'Products'),
                        'value' => decode_html($field->getDisplayValue($rawValue, $recordId, $record)),
                        'type' => $field->getFieldDataType()
                    );
                }
                if ($fieldPayload) {
                    $blocks[] = array(
                        'label' => vtranslate($blockLabel, 'Products'),
                        'fields' => $fieldPayload
                    );
                }
            }

            $images = array();
            foreach ((array) $record->getImageDetails() as $imageGroup) {
                foreach ((array) $imageGroup as $image) {
                    if (!empty($image['path']) && !empty($image['name'])) {
                        $images[] = $image['path'] . '_' . $image['name'];
                    } elseif (!empty($image['url'])) {
                        $images[] = $image['url'];
                    }
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
            $modules = array();
            $definitions = array(
                array('Products', 'Property'), array('Leads', 'Leads'), array('Contacts', 'Contacts'),
                array('Potentials', 'Opportunities'), array('Project', 'Projects'), array('Calendar', 'Calendar'),
                array('Documents', 'Documents'), array('Reports', 'Reports')
            );
            foreach ($definitions as $definition) {
                $module = Vtiger_Module_Model::getInstance($definition[0]);
                if (!$module || !$privileges->hasModulePermission($module->getId())) continue;
                $modules[] = array(
                    'name' => $definition[0],
                    'label' => $definition[1],
                    'url' => $definition[0] === 'Products' ? 'index.php?module=Products&view=ReactList' : $module->getListViewUrl()
                );
            }

            $response = new Vtiger_Response();
            $response->setResult(array(
                'id' => $recordId,
                'name' => decode_html($record->getName()),
                'number' => decode_html($record->get('product_no')),
                'blocks' => $blocks,
                'images' => $images,
                'modules' => $modules,
                'canEdit' => $record->isEditable('Products'),
                'canDelete' => $record->isDeletable('Products'),
                'editUrl' => 'index.php?module=Products&view=Edit&record=' . $recordId,
                'listUrl' => 'index.php?module=Products&view=ReactList',
                'previousUrl' => $previousId ? 'index.php?module=Products&view=ReactDetail&record=' . $previousId : null,
                'nextUrl' => $nextId ? 'index.php?module=Products&view=ReactDetail&record=' . $nextId : null
            ));
            $response->emit();
        } catch (Throwable $error) {
            $response = new Vtiger_Response();
            $response->setError('PROPERTY_DETAIL_FAILED', $error->getMessage());
            $response->emit();
        }
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
