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

$qry = "UPDATE board_qna SET hits = hits + 1 WHERE id = ".$_POST["bid"];
$db->query($qry);

$qry = "SELECT * FROM board_qna WHERE id = ".$_POST["bid"];

if ($result = $db->query($qry)) {
	$row = $result->fetch_assoc();
	
	$arrJsonResult["id"]				= $row["id"];
	$arrJsonResult["title"]			= $row["title"];
	$arrJsonResult["content"]		= str_replace("\n", "<br>", $row["content"]);
	$arrJsonResult["user_name"]		= $row["user_name"];
	$arrJsonResult["phone"]			= $row["phone"];
	$arrJsonResult["email"]			= $row["email"];
	$arrJsonResult["hits"]			= $row["hits"];
	$arrJsonResult["reg_datetime"]	= $row["reg_datetime"];
	
	$result->free();
}

$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
