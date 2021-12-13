<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultMsg = array();

if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

// limit
$page_limit = 10;
$qry_limit = '';
if (isset($_POST["page"])) {
	if (isset($_POST["limit"])) {
		$page_limit = $_POST["limit"];
	}
	$qry_limit = " LIMIT ".($_POST["page"] * $page_limit).", ".$page_limit;
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT COUNT(*) FROM user_note WHERE to_user_id = '".$_POST["user_id"]."'";

$total_count = 0;
if ($result = $db->query($qry)) {
	$row = $result->fetch_row();
	$total_count = $row[0];
	$result->free();
}

$qry = "SELECT b.name, b.part, n.* FROM user_note AS n, user_basic AS b WHERE n.to_user_id = '".$_POST["user_id"]."' AND b.id = n.from_user_id ORDER BY n.reg_datetime DESC".$qry_limit;

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultMsg[$i]["to_id"]		= $row["to_user_id"];
		$arrJsonResultMsg[$i]["from_id"]		= $row["from_user_id"];
		$arrJsonResultMsg[$i]["from_name"]	= $row["name"];
		$arrJsonResultMsg[$i]["from_part"]	= $row["part"];
		$arrJsonResultMsg[$i]["message"]		= $row["message"];
		$arrJsonResultMsg[$i]["is_noti"]		= $row["is_noti"];
		$arrJsonResultMsg[$i]["read_datetime"]	= $row["read_datetime"];
		$arrJsonResultMsg[$i]["reg_datetime"]	= $row["reg_datetime"];
		$i++;
	}
	$result->free();
}

//메시지를 가지고 올때 Noti를 푼다.
$qry = "UPDATE user_note SET is_noti = 1 WHERE to_user_id = '".$_POST["user_id"]."'";
$db->query($qry);

$arrJsonResult["total_count"] = $total_count;
$arrJsonResult["count"] = $i;
$arrJsonResult["msg"] = $arrJsonResultMsg;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
