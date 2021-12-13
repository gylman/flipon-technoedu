<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

$qrySearch = "";
if (!isset($_POST["search_val"]) || strlen($_POST["search_val"]) > 0 ) {
	$qrySearch = " AND rl.title LIKE '%".$_POST["search_val"]."%'";
}

if (!isset($_POST["search_day"]) || strlen($_POST["search_day"]) > 0 ) {
	if ( $_POST["search_day"] == "today" ) {
		$qrySearchDay = " AND rl.start_datetime < DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY ), '%Y-%m-%d 00:00:00') ";
	}
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "SELECT rl.id, rl.pw, rl.user_id, rl.title, rl.max_member, rl.is_open, rl.layout_type, rl.resolution, rl.record, rl.invite_msg, rl.record_url, rl.start_datetime, rl.end_datetime, rl.reg_datetime, rl.doclist, ub.name, rl.start_datetime <= DATE_ADD(NOW(),INTERVAL 1 MINUTE), rl.isbroadcast FROM room_list AS rl, user_basic AS ub WHERE rl.pw != '' AND rl.end_datetime >= now() AND rl.user_id = ub.id".$qrySearch.$qrySearchDay." ORDER BY start_datetime ASC";

$rt = $db->query($qry);

if ($rt->num_rows <= 0) {
	$arrJsonResult["rt_code"] = "2000"; // id or email not correct
	die(json_encode($arrJsonResult));
}

$i = 0;
$arrJsonResultRoomList = array();
while($row = $rt->fetch_row()) {
	$arrJsonResultRoomList[$i]["id"] = $row[0];
	$arrJsonResultRoomList[$i]["pw"] = $row[1];
	$arrJsonResultRoomList[$i]["user_id"] = $row[2];
	$arrJsonResultRoomList[$i]["title"] = $row[3];
	$arrJsonResultRoomList[$i]["max_number"] = $row[4];
	$arrJsonResultRoomList[$i]["is_open"] = $row[5];
	$arrJsonResultRoomList[$i]["layout_type"] = $row[6];
	$arrJsonResultRoomList[$i]["resolution"] = $row[7];
	$arrJsonResultRoomList[$i]["record"] = $row[8];
	$arrJsonResultRoomList[$i]["invite_msg"] = $row[9];
	$arrJsonResultRoomList[$i]["record_url"] = $row[10];
	$arrJsonResultRoomList[$i]["start_datetime"] = $row[11];
	$arrJsonResultRoomList[$i]["end_datetime"] = $row[12];
	$arrJsonResultRoomList[$i]["reg_datetime"] = $row[13];
	$arrJsonResultRoomList[$i]["doclist"] = $row[14];
	$arrJsonResultRoomList[$i]["user_name"] = $row[15];
	$arrJsonResultRoomList[$i]["is_starttime"] = $row[16];
	$arrJsonResultRoomList[$i]["is_broadcast"] = $row[17];
	$i++;
}

$arrJsonResult["room_list"] = $arrJsonResultRoomList;

$rt->close();
$db->close();

die(json_encode($arrJsonResult));
?>
