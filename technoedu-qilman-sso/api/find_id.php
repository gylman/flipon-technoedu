<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";
include "./config/mailinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (empty($_POST["name"]) || strlen($_POST["name"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["email"]) || strlen($_POST["email"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

$user_id = '';

$qry = "SELECT id FROM user_basic WHERE name = '".$_POST["name"]."' AND email = '".$_POST["email"]."'";

if ($result = $db->query($qry)) {
	$row = $result->fetch_row();
	$user_id = $row[0];
	
	if ($user_id == null || $user_id == '') {
		$result->free();
		$arrJsonResult["rt_code"] = "3000";
		die(json_encode($arrJsonResult));
	}
	
	$result->free();
}
$db->close();

require_once("./sendmail.php");
$arrEmailList = Array();
$arrEmailList[0] = $_POST["email"];
$subject ="[Facelink] 아이디 찾기로 요청하신 아이디입니다.";
$article = "안녕하세요. Facelink입니다.<br>고객님께서 요청하신 아이디는 '".$user_id."'입니다.<br><br>감사합니다.";

FLSendMail($arrEmailList, $subject, $article);
//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
