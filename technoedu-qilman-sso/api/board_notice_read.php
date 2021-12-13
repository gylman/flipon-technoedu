<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (empty($_POST["bid"]) || strlen($_POST["bid"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "UPDATE board_notice SET hits = hits + 1 WHERE id = ".$_POST["bid"];
$db->query($qry);

$qry = "SELECT * FROM board_notice WHERE id = ".$_POST["bid"];

if ($result = $db->query($qry)) {
	$row = $result->fetch_assoc();
	
	$arrJsonResult["id"]			= $row["id"];
	$arrJsonResult["user_id"]	= $row["user_id"];
	$arrJsonResult["title"]		= $row["title"];
	$arrJsonResult["content"]	= str_replace("\n", "<br>", $row["content"]);
	$arrJsonResult["hits"]		= $row["hits"];
	$arrJsonResult["reg_datetime"]	= $row["reg_datetime"];
	
	$result->free();
}

$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
