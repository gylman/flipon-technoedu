<?
header('Content-type: application/json');
session_start();
session_destroy();

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
die(json_encode($arrJsonResult));
?>