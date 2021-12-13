<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["count"] = "0";
$arrJsonResultUser = array();

if (empty($_POST["search_val"]) || strlen($_POST["search_val"]) <= 0) {
	die(json_encode($arrJsonResult));
}

if (empty($_POST["group_id"]) || strlen($_POST["group_id"]) <= 0) {
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	die(json_encode($arrJsonResult));
}

$qry = "SELECT DISTINCT ub.id, ub.name, ub.part, uf.status FROM user_basic AS ub, group_friend AS gf, user_friend AS uf WHERE gf.group_id = ".$_POST["group_id"]." AND gf.friend_id = ub.id AND gf.friend_id = uf.friend_id AND (ub.name LIKE '%".$_POST["search_val"]."%' OR ub.part LIKE '%".$_POST["search_val"]."%')";

$i = 0;
$result = $db->query($qry);
while ($row = $result->fetch_row()) {
	$arrJsonResultUser[$i]["id"] = $row[0];
	$arrJsonResultUser[$i]["name"] = $row[1];
	$arrJsonResultUser[$i]["part"] = $row[2];
	$arrJsonResultUser[$i]["status"] = $row[3];
	$i++;
}

$arrJsonResult["count"] = $i;
//$arrJsonResult["qry"] = $qry;
$arrJsonResult["user"] = $arrJsonResultUser;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
