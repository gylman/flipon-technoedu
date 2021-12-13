<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "1000";

if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "SELECT COUNT(*) FROM user_note WHERE to_user_id = '".$_POST["user_id"]."' AND is_noti = 0";

$result = $db->query($qry);
$row = $result->fetch_row();
if ($row[0] > 0) {
	$arrJsonResult["rt_code"] = "0";
}

$qry = "UPDATE user_note SET is_noti = 1 WHERE to_user_id = '".$_POST["user_id"]."'";
$db->query($qry);
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
