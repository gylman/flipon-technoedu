<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";
$arrJsonResult["count"] = 0;
$arrJsonResultFriend = array();

if (empty($_POST["group_id"]) || strlen($_POST["group_id"]) <= 0) {
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

$user_id = '';
$qry = "SELECT user_id FROM user_group WHERE id = '".$_POST["group_id"]."'";
if ($result = $db->query($qry)) {
	$row = $result->fetch_row();
	$user_id = $row[0];
	$result->free();
}

if ($user_id == '') {
	$arrJsonResult["rt_code"] = "2001";
	die(json_encode($arrJsonResult));
}

$qry = "SELECT ub.id, ub.name, ub.part FROM user_basic AS ub, group_friend AS gf WHERE gf.group_id = '".$_POST["group_id"]."' AND ub.id = gf.friend_id".$strSearch;

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultFriend[$i]["id"]	= $row["id"];
		$arrJsonResultFriend[$i]["name"]	= $row["name"];
		$arrJsonResultFriend[$i]["part"]	= $row["part"];
		
		$qry = "SELECT status FROM user_friend WHERE user_id = '".$user_id."' AND friend_id = '".$arrJsonResultFriend[$i]["id"]."'";
		$result2 = $db->query($qry);
		$row2 = $result2->fetch_row();
		
		$arrJsonResultFriend[$i]["status"]	= $row2[0];
		$result2->free();
		
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
