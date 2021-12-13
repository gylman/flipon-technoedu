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

$qry = "SELECT name, email, allow_mailing, phone, birthday, sex, part, depart, login_datetime, reg_datetime, level FROM user_basic WHERE id = '".$_POST["user_id"]."'";

$i = 0;
if ($result = $db->query($qry)) {
	while ($row = $result->fetch_assoc()) {
		$arrJsonResultFriend[$i]["name"]				= $row["name"];
		$arrJsonResultFriend[$i]["email"]			= $row["email"];
		$arrJsonResultFriend[$i]["allow_mailing"]	= $row["allow_mailing"];
		$arrJsonResultFriend[$i]["phone"]			= $row["phone"];
		$arrJsonResultFriend[$i]["birthday"]			= $row["birthday"];
		$arrJsonResultFriend[$i]["sex"]				= $row["sex"];
		$arrJsonResultFriend[$i]["part"]				= $row["part"];
		$arrJsonResultFriend[$i]["depart"]			= $row["depart"];
		$arrJsonResultFriend[$i]["login_datetime"]	= $row["login_datetime"];
		$arrJsonResultFriend[$i]["reg_datetime"]		= $row["reg_datetime"];
		$arrJsonResultFriend[$i]["level"]		= $row["level"];
		$i++;
	}
	$result->free();
}

$arrJsonResult["count"] = $i;
$arrJsonResult["user"] = $arrJsonResultFriend;
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
