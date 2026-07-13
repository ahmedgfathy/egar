<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Leads_Detail_View extends Accounts_Detail_View {
    public function preProcess(Vtiger_Request $request, $display = true) {
        $recordId = (int) $request->get('record');
        $mode = $request->getMode();

        // Normal browser navigation uses React. Internal Vtiger modes remain on
        // the inherited Accounts/Vtiger implementation for related lists and AJAX.
        if ($recordId && empty($mode)) {
            header('Location: index.php?module=Leads&view=ReactDetail&record=' . $recordId);
            exit;
        }

        return parent::preProcess($request, $display);
    }
}
