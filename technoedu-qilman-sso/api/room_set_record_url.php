<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

// post data check
if (empty($_POST["rid"]) || strlen($_POST["rid"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["record_url"]) || strlen($_POST["record_url"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "UPDATE room_list SET record_url = '".$_POST["record_url"]."' WHERE id = ".$_POST["rid"];

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->error;
}
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
