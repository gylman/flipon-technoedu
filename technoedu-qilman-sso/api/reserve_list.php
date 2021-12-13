<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultRoom = array();

if (empty($_POST["date"]) || strlen($_POST["date"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["limit"]) || strlen($_POST["limit"]) <= 0) {
	$_POST["limit"] = "2";
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT * FROM room_list WHERE start_datetime >= '".$_POST["date"]."' AND start_datetime < ADDDATE('".$_POST["date"]."', ".$_POST["limit"].") ORDER BY start_datetime ASC";

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultRoom[$i]["id"]				= $row["id"];
		$arrJsonResultRoom[$i]["user_id"]		= $row["user_id"];
		$arrJsonResultRoom[$i]["day"]			= strftime("%a", strtotime($row["start_datetime"]));
		$arrJsonResultRoom[$i]["start_datetime"]	= $row["start_datetime"];
		$arrJsonResultRoom[$i]["end_datetime"]	= $row["end_datetime"];
		$arrJsonResultRoom[$i]["max_member"]		= $row["max_member"];
		$arrJsonResultRoom[$i]["title"]			= $row["title"];
		$arrJsonResultRoom[$i]["pw"]				= $row["pw"];
		$arrJsonResultRoom[$i]["layout_type"]	= $row["layout_type"];
		$arrJsonResultRoom[$i]["resolution"]		= $row["resolution"];
		$arrJsonResultRoom[$i]["record"]			= $row["record"];
		$arrJsonResultRoom[$i]["invite_msg"]	= $row["invite_msg"];
		$arrJsonResultRoom[$i]["doclist"]		= $row["doclist"];
		$arrJsonResultRoom[$i]["mcu_id"]			= $row["mcu_id"];
		$arrJsonResultRoom[$i]["reg_datetime"]	= $row["reg_datetime"];
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
