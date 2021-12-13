<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

// post data check
if (empty($_POST["rid"]) || strlen($_POST["rid"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "SELECT max_member FROM room_list WHERE id = ".$_POST["rid"];

$result = $db->query($qry);
$row = $result->fetch_row();
$maxMember = $row[0];
$result->free();

$qry = "SELECT COUNT(*) FROM room_member WHERE room_id = ".$_POST["rid"];

$result = $db->query($qry);
$row = $result->fetch_row();
$currMember = $row[0];
$result->free();

if ($maxMember <= $currMember) {
	$arrJsonResult["rt_code"] = "3000";
	$db->close();
	die(json_encode($arrJsonResult));
}

$qry = "SELECT COUNT(*) FROM room_member WHERE room_id = ".$_POST["rid"]." AND user_id = '".$_POST["user_id"]."'";

$result = $db->query($qry);
$row = $result->fetch_row();
if ($row[0] > 0) {
	$arrJsonResult["rt_code"] = "4000";
	$arrJsonResult["error"] = $db->error;
} else {
	$qry = "INSERT INTO room_member (room_id, user_id) VALUES (".$_POST["rid"].", '".$_POST["user_id"]."')";
	
	$db->query($qry);
	if ($db->affected_rows <= 0) {
		$arrJsonResult["rt_code"] = "5000";
		$arrJsonResult["error"] = $db->error;
	}
}

$result->free();
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
