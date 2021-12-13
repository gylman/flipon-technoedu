<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

$qry_set = '';

// post data check
if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (!empty($_POST["pw"]) && strlen($_POST["pw"]) > 0) {
	$qry_set .= ", pw = '".md5($_POST["pw"])."'";
}

if (!empty($_POST["name"]) && strlen($_POST["name"]) > 0) {
	$qry_set .= ", name = '".$_POST["name"]."'";
}

if (!empty($_POST["email"]) && strlen($_POST["email"]) > 0) {
	$qry_set .= ", email = '".$_POST["email"]."'";
}

if (isset($_POST["allow_mailing"])) {
	$qry_set .= ", allow_mailing = ".((int)$_POST["allow_mailing"]);
}

if (!empty($_POST["phone"]) && strlen($_POST["phone"]) > 0) {
	$qry_set .= ", phone = '".$_POST["phone"]."'";
}

if (!empty($_POST["birthday"]) && strlen($_POST["birthday"]) > 0) {
	$qry_set .= ", birthday = '".$_POST["birthday"]."'";
}

if (!empty($_POST["sex"]) && strlen($_POST["sex"]) > 0) {
	$qry_set .= ", sex = '".$_POST["sex"]."'";
}

if (!empty($_POST["part"]) && strlen($_POST["part"]) > 0) {
	$qry_set .= ", part = '".$_POST["part"]."'";
}

if (!empty($_POST["depart"]) && strlen($_POST["depart"]) > 0) {
	$qry_set .= ", depart = '".$_POST["depart"]."'";
}

if (strlen($qry_set) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

$qry_set = substr($qry_set, 2);

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "UPDATE user_basic SET ".$qry_set." WHERE id = '".$_POST["user_id"]."'";

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->error;
}
$db->close();

//$arrJsonResult["qry"] = $qry;

session_start();
if (isset($_SESSION['user_part'])) {
	$_SESSION['user_part'] = $_POST["part"];
}

echo json_encode($arrJsonResult);
?>
