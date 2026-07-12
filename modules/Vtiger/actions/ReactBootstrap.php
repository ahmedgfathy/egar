<?php

class Vtiger_ReactBootstrap_Action extends Vtiger_Action_Controller {
    public function process(Vtiger_Request $request) {
        $db = PearDatabase::getInstance();
        $user = Users_Record_Model::getCurrentUserModel();
        $privileges = Users_Privileges_Model::getCurrentUserPrivilegesModel();

        $moduleDefinitions = array(
            array('name' => 'Products', 'label' => 'Property', 'group' => 'Workspace'),
            array('name' => 'Leads', 'label' => 'Leads', 'group' => 'Workspace'),
            array('name' => 'Contacts', 'label' => 'Contacts', 'group' => 'Workspace'),
            array('name' => 'Potentials', 'label' => 'Opportunities', 'group' => 'Workspace'),
            array('name' => 'Project', 'label' => 'Projects', 'group' => 'Operations'),
            array('name' => 'Calendar', 'label' => 'Calendar', 'group' => 'Operations'),
            array('name' => 'Documents', 'label' => 'Documents', 'group' => 'Operations'),
            array('name' => 'Reports', 'label' => 'Reports', 'group' => 'Insights')
        );

        $modules = array();
        foreach ($moduleDefinitions as $definition) {
            $module = Vtiger_Module_Model::getInstance($definition['name']);
            if (!$module || !$privileges->hasModulePermission($module->getId())) {
                continue;
            }
            $modules[] = array(
                'name' => $definition['name'],
                'label' => $definition['label'],
                'group' => $definition['group'],
                'url' => $definition['name'] === 'Products'
                    ? 'index.php?module=Products&view=ReactList'
                    : $module->getListViewUrl()
            );
        }

        $metricQueries = array(
            'properties' => "SELECT COUNT(*) count FROM vtiger_products p INNER JOIN vtiger_crmentity e ON e.crmid=p.productid WHERE e.deleted=0",
            'leads' => "SELECT COUNT(*) count FROM vtiger_leaddetails l INNER JOIN vtiger_crmentity e ON e.crmid=l.leadid WHERE e.deleted=0",
            'contacts' => "SELECT COUNT(*) count FROM vtiger_contactdetails c INNER JOIN vtiger_crmentity e ON e.crmid=c.contactid WHERE e.deleted=0"
        );
        $metrics = array();
        foreach ($metricQueries as $key => $sql) {
            $result = $db->pquery($sql, array());
            $metrics[$key] = (int) $db->query_result($result, 0, 'count');
        }

        $recent = array();
        $recentResult = $db->pquery(
            "SELECT p.productid, p.productname, p.product_no, e.modifiedtime
             FROM vtiger_products p INNER JOIN vtiger_crmentity e ON e.crmid=p.productid
             WHERE e.deleted=0 ORDER BY e.modifiedtime DESC LIMIT 6", array()
        );
        for ($index = 0; $index < $db->num_rows($recentResult); $index++) {
            $id = (int) $db->query_result($recentResult, $index, 'productid');
            $recent[] = array(
                'id' => $id,
                'name' => $db->query_result($recentResult, $index, 'productname'),
                'number' => $db->query_result($recentResult, $index, 'product_no'),
                'modified' => $db->query_result($recentResult, $index, 'modifiedtime'),
                'url' => 'index.php?module=Products&view=Detail&record=' . $id
            );
        }

        $response = new Vtiger_Response();
        $response->setResult(array(
            'user' => array(
                'id' => (int) $user->getId(),
                'name' => trim($user->get('first_name') . ' ' . $user->get('last_name')) ?: $user->get('user_name'),
                'username' => $user->get('user_name'),
                'admin' => $user->isAdminUser()
            ),
            'modules' => $modules,
            'metrics' => $metrics,
            'recentProperties' => $recent,
            'legacySettingsUrl' => 'index.php?module=Users&parent=Settings&view=List'
        ));
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) {
        return true;
    }
}
