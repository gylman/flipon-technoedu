<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultFriend = array();

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

$qry = "SELECT DISTINCT ub.id, ub.name, ub.part FROM user_basic AS ub, user_friend AS uf WHERE uf.friend_id = '".$_POST["user_id"]."' AND uf.status = 'wait' AND ub.id = uf.user_id";

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultFriend[$i]["id"]	= $row["id"];
		$arrJsonResultFriend[$i]["name"]	= $row["name"];
		$arrJsonResultFriend[$i]["part"]	= $row["part"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["count"] = $i;
$arrJsonResult["friend"] = $arrJsonResultFriend;
$db->close();

$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
