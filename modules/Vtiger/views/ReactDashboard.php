<?php

class Vtiger_ReactDashboard_View extends Vtiger_Index_View {
    // Standalone React document: do not emit or permission-check the legacy
    // Vtiger header/sidebar pipeline around this view.
    public function preProcess(Vtiger_Request $request, $display = true) {
        return true;
    }

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $viewer->view('ReactDashboard.tpl', 'Vtiger');
    }

    public function postProcess(Vtiger_Request $request) {
        return true;
    }
}
