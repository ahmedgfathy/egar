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
        $permittedNames = array();
        foreach ($moduleDefinitions as $definition) {
            $module = Vtiger_Module_Model::getInstance($definition['name']);
            if (!$module || !$privileges->hasModulePermission($module->getId())) continue;
            $permittedNames[] = $definition['name'];
            $url = $module->getListViewUrl();
            if ($definition['name'] === 'Products') $url = 'index.php?module=Products&view=ReactList';
            if ($definition['name'] === 'Leads') $url = 'index.php?module=Leads&view=ReactList';
            $modules[] = array(
                'name' => $definition['name'],
                'label' => $definition['label'],
                'group' => $definition['group'],
                'url' => $url
            );
        }

        $metrics = array();
        foreach ($permittedNames as $moduleName) {
            if ($moduleName === 'Reports') continue;
            $result = $db->pquery(
                'SELECT COUNT(*) AS count FROM vtiger_crmentity WHERE deleted=0 AND setype=?',
                array($moduleName)
            );
            $metrics[strtolower($moduleName)] = (int) $db->query_result($result, 0, 'count');
        }
        $metrics['properties'] = isset($metrics['products']) ? $metrics['products'] : 0;
        $metrics['opportunities'] = isset($metrics['potentials']) ? $metrics['potentials'] : 0;
        $metrics['activities'] = (isset($metrics['calendar']) ? $metrics['calendar'] : 0) + (isset($metrics['events']) ? $metrics['events'] : 0);

        $recentRecords = array();
        if ($permittedNames) {
            $placeholders = implode(',', array_fill(0, count($permittedNames), '?'));
            $recentResult = $db->pquery(
                "SELECT crmid, setype, label, createdtime, modifiedtime
                 FROM vtiger_crmentity
                 WHERE deleted=0 AND setype IN ($placeholders)
                 ORDER BY modifiedtime DESC LIMIT 12",
                $permittedNames
            );
            for ($index = 0; $index < $db->num_rows($recentResult); $index++) {
                $id = (int) $db->query_result($recentResult, $index, 'crmid');
                $moduleName = $db->query_result($recentResult, $index, 'setype');
                $detailView = in_array($moduleName, array('Products', 'Leads')) ? 'ReactDetail' : 'Detail';
                $recentRecords[] = array(
                    'id' => $id,
                    'module' => $moduleName,
                    'label' => decode_html($db->query_result($recentResult, $index, 'label')),
                    'created' => $db->query_result($recentResult, $index, 'createdtime'),
                    'modified' => $db->query_result($recentResult, $index, 'modifiedtime'),
                    'url' => 'index.php?module=' . urlencode($moduleName) . '&view=' . $detailView . '&record=' . $id
                );
            }
        }

        $upcoming = array();
        if (in_array('Calendar', $permittedNames)) {
            $activityResult = $db->pquery(
                "SELECT a.activityid, a.subject, a.activitytype, a.date_start, a.time_start,
                        a.status, a.eventstatus
                 FROM vtiger_activity a
                 INNER JOIN vtiger_crmentity e ON e.crmid=a.activityid
                 WHERE e.deleted=0 AND a.date_start >= CURRENT_DATE
                 ORDER BY a.date_start ASC, a.time_start ASC LIMIT 8",
                array()
            );
            for ($index = 0; $index < $db->num_rows($activityResult); $index++) {
                $id = (int) $db->query_result($activityResult, $index, 'activityid');
                $upcoming[] = array(
                    'id' => $id,
                    'subject' => decode_html($db->query_result($activityResult, $index, 'subject')),
                    'type' => $db->query_result($activityResult, $index, 'activitytype'),
                    'date' => $db->query_result($activityResult, $index, 'date_start'),
                    'time' => $db->query_result($activityResult, $index, 'time_start'),
                    'status' => $db->query_result($activityResult, $index, 'eventstatus') ?: $db->query_result($activityResult, $index, 'status'),
                    'url' => 'index.php?module=Calendar&view=Detail&record=' . $id
                );
            }
        }

        $leadStatus = array();
        if (in_array('Leads', $permittedNames)) {
            $leadResult = $db->pquery(
                "SELECT l.leadstatus, COUNT(*) AS count
                 FROM vtiger_leaddetails l
                 INNER JOIN vtiger_crmentity e ON e.crmid=l.leadid
                 WHERE e.deleted=0
                 GROUP BY l.leadstatus ORDER BY count DESC LIMIT 8",
                array()
            );
            for ($index = 0; $index < $db->num_rows($leadResult); $index++) {
                $leadStatus[] = array(
                    'label' => decode_html($db->query_result($leadResult, $index, 'leadstatus')) ?: 'Unspecified',
                    'count' => (int) $db->query_result($leadResult, $index, 'count')
                );
            }
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
            'recentRecords' => $recentRecords,
            'upcomingActivities' => $upcoming,
            'leadStatus' => $leadStatus,
            'legacySettingsUrl' => 'index.php?module=Users&parent=Settings&view=List'
        ));
        $response->emit();
    }

    public function validateRequest(Vtiger_Request $request) { return true; }
}
