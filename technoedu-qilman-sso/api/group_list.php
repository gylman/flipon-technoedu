<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultGroup = array();

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

$qry = "SELECT * FROM user_group WHERE user_id = '".$_POST["user_id"]."'";

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultGroup[$i]["id"]				= $row["id"];
		$arrJsonResultGroup[$i]["user_id"]			= $row["user_id"];
		$arrJsonResultGroup[$i]["group_name"]		= $row["group_name"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["count"] = $i;
$arrJsonResult["group"] = $arrJsonResultGroup;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
