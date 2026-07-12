<?php

class Products_ReactList_View extends Vtiger_Index_View {
    public function preProcess(Vtiger_Request $request, $display = true) { return true; }
    public function postProcess(Vtiger_Request $request) { return true; }
    public function process(Vtiger_Request $request) {
        $this->getViewer($request)->view('ReactList.tpl', 'Products');
    }
}
