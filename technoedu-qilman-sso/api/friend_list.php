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

$strSearch = "";
if (!empty($_POST["search_val"]) && strlen($_POST["search_val"]) > 0) {
	$strSearch = " AND ub.name LIKE '%".$_POST["search_val"]."%'";
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT ub.id, ub.name, ub.part, uf.status FROM user_basic AS ub, user_friend AS uf WHERE uf.user_id = '".$_POST["user_id"]."' AND ub.id = uf.friend_id".$strSearch;

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultFriend[$i]["id"]	= $row["id"];
		$arrJsonResultFriend[$i]["name"]	= $row["name"];
		$arrJsonResultFriend[$i]["part"]	= $row["part"];
		$arrJsonResultFriend[$i]["status"]	= $row["status"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["count"] = $i;
$arrJsonResult["friend"] = $arrJsonResultFriend;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
