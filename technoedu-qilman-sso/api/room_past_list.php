<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$page = 0;
$listcnt = 8;

if ( isset($_POST["page"]) ) $page = (int)$_POST['page'];
if ( isset($_POST["listcnt"]) ) $listcnt = (int)$_POST['listcnt'];

if ( $page > 0 ) $page = $page-1;
$limit_start = $page*$listcnt;

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

// for total count
$qry = "SELECT COUNT(DISTINCT rl.id) FROM room_list AS rl, room_member AS rm WHERE ((rl.user_id = '".$_SESSION['user_id']."') OR (rm.user_id = '".$_SESSION['user_id']."' AND rl.id = rm.room_id) ) AND rl.end_datetime < now()";

$rt = $db->query($qry);
$row = $rt->fetch_row();
$arrJsonResult["total_count"] = $row[0];
$rt->free();

// for list
$qry = "SELECT DISTINCT rl.id, rl.title, rl.start_datetime, rl.end_datetime FROM room_list AS rl, room_member AS rm WHERE ( (rl.user_id = '".$_SESSION['user_id']."') OR (rm.user_id = '".$_SESSION['user_id']."' AND rl.id = rm.room_id) ) AND rl.end_datetime < now() ORDER BY start_datetime DESC LIMIT ".$limit_start.",".$listcnt;

$rt = $db->query($qry);

$i = 0;
$arrJsonResultRoomList = array();
while($row = $rt->fetch_assoc()) {
	$arrJsonResultRoomList[$i]["id"] = $row["id"];
	$arrJsonResultRoomList[$i]["title"] = $row["title"];
	$arrJsonResultRoomList[$i]["start_datetime"] = $row["start_datetime"];
	$arrJsonResultRoomList[$i]["end_datetime"] = $row["end_datetime"];
	$i++;
}

$arrJsonResult["count"] = $i;
$arrJsonResult["room_list"] = $arrJsonResultRoomList;

//$arrJsonResult["qry"] = $qry;

$rt->close();
$db->close();

die(json_encode($arrJsonResult));
?>
