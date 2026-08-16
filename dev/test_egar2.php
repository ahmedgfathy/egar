<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
chdir("/home/xinreal/egar");
echo "Step 1: include Relation.php\n";
@include_once 'include/Webservices/Relation.php';
echo "Step 2: include Module.php\n";
@include_once 'vtlib/Vtiger/Module.php';
echo "Step 3: include WebUI.php\n";
@include_once 'includes/main/WebUI.php';
echo "Step 4: done includes\n";
