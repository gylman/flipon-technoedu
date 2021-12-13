<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultRoom = array();

if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT DISTINCT r.id AS idx, r.*, r.start_datetime <= DATE_ADD(NOW(),INTERVAL 1 MINUTE) as is_opentime FROM room_list AS r, room_member AS rm WHERE (r.user_id = '".$_POST["user_id"]."' AND r.end_datetime > now()) OR (rm.user_id = '".$_POST["user_id"]."' AND rm.room_id = r.id AND r.end_datetime > now()) ORDER BY start_datetime ASC";

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultRoom[$i]["id"]				= $row["id"];
		$arrJsonResultRoom[$i]["user_id"]		= $row["user_id"];
		$arrJsonResultRoom[$i]["day"]			= strftime("%a", strtotime($row["start_datetime"]));
		$arrJsonResultRoom[$i]["start_datetime"]	= $row["start_datetime"];
		$arrJsonResultRoom[$i]["end_datetime"]	= $row["end_datetime"];
		$arrJsonResultRoom[$i]["max_member"]		= $row["max_member"];
		$arrJsonResultRoom[$i]["is_open"]		= $row["is_open"];
		$arrJsonResultRoom[$i]["title"]			= $row["title"];
		$arrJsonResultRoom[$i]["pw"]				= $row["pw"];
		$arrJsonResultRoom[$i]["layout_type"]	= $row["layout_type"];
		$arrJsonResultRoom[$i]["resolution"]		= $row["resolution"];
		$arrJsonResultRoom[$i]["record"]			= $row["record"];
		$arrJsonResultRoom[$i]["invite_email"]	= $row["invite_msg"];
		$arrJsonResultRoom[$i]["doclist"]		= $row["doclist"];
		$arrJsonResultRoom[$i]["mcu_id"]			= $row["mcu_id"];
		$arrJsonResultRoom[$i]["reg_datetime"]	= $row["reg_datetime"];
		$arrJsonResultRoom[$i]["is_opentime"]	= $row["is_opentime"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["count"] = $i;
$arrJsonResult["room_list"] = $arrJsonResultRoom;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
