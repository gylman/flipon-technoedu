<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

// post data check
if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_pw"]) || strlen($_POST["user_pw"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_name"]) || strlen($_POST["user_name"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_byear"]) || strlen($_POST["user_byear"]) <= 0) {
	$arrJsonResult["rt_code"] = "1003";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_bmonth"]) || strlen($_POST["user_bmonth"]) <= 0) {
	$arrJsonResult["rt_code"] = "1004";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_bday"]) || strlen($_POST["user_bday"]) <= 0) {
	$arrJsonResult["rt_code"] = "1005";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_sex"]) || strlen($_POST["user_sex"]) <= 0) {
	$arrJsonResult["rt_code"] = "1006";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_phone"]) || strlen($_POST["user_phone"]) <= 0) {
	$arrJsonResult["rt_code"] = "1007";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_email"]) || strlen($_POST["user_email"]) <= 0) {
	$arrJsonResult["rt_code"] = "1008";
	die(json_encode($arrJsonResult));
}

/*
$arrJsonResult["user_name"] = $_POST["user_name"];
$arrJsonResult["user_byear"] = $_POST["user_byear"];
$arrJsonResult["user_bmonth"] = $_POST["user_bmonth"];
$arrJsonResult["user_bday"] = $_POST["user_bday"];
$arrJsonResult["user_sex"] = $_POST["user_sex"];
$arrJsonResult["user_id"] = $_POST["user_id"];
$arrJsonResult["user_pw"] = $_POST["user_pw"];
$arrJsonResult["user_group"] = $_POST["user_group"];
$arrJsonResult["user_phone"] = $_POST["user_phone"];
$arrJsonResult["user_email"] = $_POST["user_email"];
$arrJsonResult["user_allow_mailing"] = $_POST["user_allow_mailing"];
$arrJsonResult["user_address"] = $_POST["user_address"];
*/

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "INSERT INTO user_basic (id, pw, name, email, allow_mailing, phone, birthday, sex, part, depart, reg_datetime) ".
		"VALUES ('".$_POST["user_id"]."', '".md5($_POST["user_pw"])."', '".$_POST["user_name"]."', '".$_POST["user_email"]."', ".$_POST["user_allow_mailing"].", '".$_POST["user_phone"]."', '".$_POST["user_byear"]."-".$_POST["user_bmonth"]."-".$_POST["user_bday"]."', '".$_POST["user_sex"]."', '".$_POST["user_group"]."', '".$_POST["user_depart"]."', now())";

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->error;
}
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
