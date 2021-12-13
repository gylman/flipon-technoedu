<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

$qrySearchDay = " AND datetime > DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00') ";

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "SELECT id, user_id, call_info, datetime FROM room_list_ext WHERE user_id = '".$_POST["user_id"]."' ".$qrySearchDay." ORDER BY datetime ASC";

$rt = $db->query($qry);

if ($rt->num_rows <= 0) {
	$arrJsonResult["rt_code"] = "2000"; // id or email not correct
	$arrJsonResult["query"] = $qry; 
	die(json_encode($arrJsonResult));
}

$i = 0;
$arrJsonResultRoomList = array();
while($row = $rt->fetch_row()) {
	$arrJsonResultRoomList[$i]["id"] = $row[0];
	$arrJsonResultRoomList[$i]["user_id"] = $row[1];
	$arrJsonResultRoomList[$i]["call_info"] = $row[2];
	$arrJsonResultRoomList[$i]["datetime"] = $row[3];
	$i++;
}

$arrJsonResult["room_list"] = $arrJsonResultRoomList;

$rt->close();
$db->close();

echo json_encode($arrJsonResult);
?>
