<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

// post data check
if (empty($_POST["user_name"]) || strlen($_POST["user_name"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["title"]) || strlen($_POST["title"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["content"]) || strlen($_POST["content"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

$qry = "INSERT INTO board_qna (title, content, user_name, phone, email, reg_datetime) VALUES ('".htmlspecialchars($_POST["title"])."', '".htmlspecialchars($_POST["content"])."', '".htmlspecialchars($_POST["user_name"])."', '".htmlspecialchars($_POST["phone"])."', '".htmlspecialchars($_POST["email"])."', now())";

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->error;
}
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
