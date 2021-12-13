<?
header('Content-type: application/json');
session_start();

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0) {
	$arrJsonResult["user_id"] = $_SESSION['user_id'];
	$arrJsonResult["user_name"] = $_SESSION['user_name'];
	$arrJsonResult["user_email"] = $_SESSION['user_email'];
	$arrJsonResult["user_part"] = $_SESSION['user_part'];
	$arrJsonResult["user_dept"] = $_SESSION['user_dept'];
	$arrJsonResult["user_level"] = $_SESSION['user_level'];

	die(json_encode($arrJsonResult)); // login
}

$arrJsonResult["rt_code"] = "1000"; // logout
die(json_encode($arrJsonResult));
?>
