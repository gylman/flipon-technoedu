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

if (empty($_POST["friend_id"]) || strlen($_POST["friend_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "INSERT INTO user_friend (user_id, friend_id) VALUES ('".$_POST["user_id"]."', '".$_POST["friend_id"]."')";

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->error;
}
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
