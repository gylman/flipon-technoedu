<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (!isset($_POST["rid"]) || strlen($_POST["rid"]) <= 0 ) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "SELECT rl.id, rl.pw, rl.user_id, rl.title, rl.max_member, rl.is_open, rl.layout_type, rl.resolution, rl.record, rl.invite_msg, rl.record_url, rl.start_datetime, rl.end_datetime, rl.reg_datetime, rl.doclist, ub.name FROM room_list AS rl, user_basic AS ub WHERE rl.id = ".$_POST["rid"]." AND rl.user_id = ub.id";

$rt = $db->query($qry);

if ($rt->num_rows <= 0) {
	$arrJsonResult["rt_code"] = "2000"; // id or email not correct
	$arrJsonResult["query"] = $qry; // id or email not correct
	die(json_encode($arrJsonResult));
}

$row = $rt->fetch_row();
$arrJsonResult["id"] = $row[0];
$arrJsonResult["pw"] = $row[1];
$arrJsonResult["user_id"] = $row[2];
$arrJsonResult["title"] = $row[3];
$arrJsonResult["max_number"] = $row[4];
$arrJsonResult["is_open"] = $row[5];
$arrJsonResult["layout_type"] = $row[6];
$arrJsonResult["resolution"] = $row[7];
$arrJsonResult["record"] = $row[8];
$arrJsonResult["invite_msg"] = $row[9];
$arrJsonResult["record_url"] = $row[10];
$arrJsonResult["start_datetime"] = $row[11];
$arrJsonResult["end_datetime"] = $row[12];
$arrJsonResult["reg_datetime"] = $row[13];
$arrJsonResult["doclist"] = urldecode($row[14]);
$arrJsonResult["name"] = $row[15];

$rt->close();

// member list
$qry = "SELECT DISTINCT rm.user_id, ub.name, ub.part FROM room_member AS rm, user_basic AS ub WHERE rm.room_id = ".$_POST["rid"]." AND rm.user_id = ub.id";
$rt = $db->query($qry);

$arrJsonResultUser = array();
if ($rt->num_rows > 0) {
	$i = 0;
	while($row = $rt->fetch_row()) {
		$arrJsonResultUser[$i]["user_id"] = $row[0];
		$arrJsonResultUser[$i]["name"] = $row[1];
		$arrJsonResultUser[$i]["part"] = $row[2];
		$i++;
	}
}

$arrJsonResult["member"] = $arrJsonResultUser;

$rt->close();
$db->close();

die(json_encode($arrJsonResult));
?>
