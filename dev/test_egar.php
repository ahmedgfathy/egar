<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
$_SERVER["REQUEST_URI"] = "/";
$_SERVER["HTTP_HOST"] = "localhost:8080";
$_SERVER["SERVER_NAME"] = "localhost";
$_SERVER["SERVER_PORT"] = "8080";
$_SERVER["REQUEST_METHOD"] = "GET";
$_SERVER["SCRIPT_NAME"] = "/index.php";
$_SERVER["PHP_SELF"] = "/index.php";
$_SERVER["DOCUMENT_ROOT"] = "/home/xinreal/egar";
$_SERVER["SERVER_PROTOCOL"] = "HTTP/1.1";
$_SERVER["REMOTE_ADDR"] = "127.0.0.1";
chdir("/home/xinreal/egar");
echo "BEFORE INCLUDE\n";
ob_start();
try {
    include "index.php";
} catch (\Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . "\n";
}
$out = ob_get_clean();
echo "OUTPUT LEN: " . strlen($out) . "\n";
echo substr($out, 0, 1000);
echo "\nDONE\n";
