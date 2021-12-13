<?
header('Content-type: application/json');
session_start();

include "./config/dbinfo.inc.php";
include "./config/mailinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

if (empty($_POST["id"]) || strlen($_POST["id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["name"]) || strlen($_POST["name"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["email"]) || strlen($_POST["email"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "2000";
	die(json_encode($arrJsonResult));
}

// 랜덤 문자열 배열 생성 ('a' ~ 'z', 'A' ~ 'Z', '0' ~ '9', 사칙연산 특수문자)
$rand_char = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
		
// 새 비밀번호 길이 지정
$new_password_length = 10;

// 새 비밀번호 생성
for($i = 0; $i < $new_password_length; $i++) {
	$rand_range = rand(0, count($rand_char) - 1);
	$new_password .= $rand_char[$rand_range];
}

$qry = "UPDATE user_basic SET pw = '".md5($new_password)."' WHERE id = '".$_POST["id"]."' AND name = '".$_POST["name"]."' AND email = '".$_POST["email"]."'";

$db->query($qry);
if ($db->affected_rows <= 0) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->error;
	
	$db->close();
	die(json_encode($arrJsonResult));
}
$db->close();

require_once("./sendmail.php");
$arrEmailList = Array();
$arrEmailList[0] = $_POST["email"];
$subject ="[Facelink] 요청하신 임시 비밀번호입니다.";
$article ="안녕하세요. Facelink입니다.<br>고객님께서 요청하신 임시 비밀번호는 '".$new_password."'입니다.<br>반드시 로그인 후 비밀번호를 변경해 주세요.<br><br>감사합니다.";

FLSendMail($arrEmailList, $subject, $article);

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
