<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResultFriend = array();

if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["friend_id"]) || strlen($_POST["friend_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

// status value : wait, done
if (empty($_POST["status"]) || strlen($_POST["status"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT COUNT(*) FROM user_friend WHERE user_id = '".$_POST["friend_id"]."' AND friend_id = '".$_POST["user_id"]."'";
if ($result = $db->query($qry)) {
	$row = $result->fetch_row();
	
	if ($row[0] <= 0) {
		$qry = "INSERT INTO user_friend (user_id, friend_id) VALUES ('".$_POST["friend_id"]."', '".$_POST["user_id"]."')";
		$db->query($qry);
	}
}

$qry = "UPDATE user_friend SET status = '".$_POST["status"]."', reg_datetime = now() WHERE user_id = '".$_POST["user_id"]."' AND friend_id = '".$_POST["friend_id"]."'";
$db->query($qry);
$qry = "UPDATE user_friend SET status = '".$_POST["status"]."', reg_datetime = now() WHERE user_id = '".$_POST["friend_id"]."' AND friend_id = '".$_POST["user_id"]."'";
$db->query($qry);
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
