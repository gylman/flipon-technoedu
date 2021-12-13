<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["count"] = "0";
$arrJsonResultUser = array();

if (empty($_POST["search_key"]) || strlen($_POST["search_key"]) <= 0 ||
	empty($_POST["search_val"]) || strlen($_POST["search_val"]) <= 0) {
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	die(json_encode($arrJsonResult));
}

$qry = "SELECT id, name, part FROM user_basic WHERE ".$_POST["search_key"]." LIKE '%".$_POST["search_val"]."%'";

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && strlen($_SESSION['user_id']) > 0) {
	$qry .= " AND id != '".$_SESSION['user_id']."'";
}

$i = 0;
$result = $db->query($qry);
while ($row = $result->fetch_row()) {
	$arrJsonResultUser[$i]["id"] = $row[0];
	$arrJsonResultUser[$i]["name"] = $row[1];
	$arrJsonResultUser[$i]["part"] = $row[2];
	$i++;
}

$arrJsonResult["count"] = $i;
//$arrJsonResult["qry"] = $qry;
$arrJsonResult["user"] = $arrJsonResultUser;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
