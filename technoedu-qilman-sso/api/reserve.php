<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

// post data check
if (empty($_POST["user_id"]) || strlen($_POST["user_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1000";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["start_datetime"]) || strlen($_POST["start_datetime"]) <= 0) {
	$arrJsonResult["rt_code"] = "1001";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["end_datetime"]) || strlen($_POST["end_datetime"]) <= 0) {
	$arrJsonResult["rt_code"] = "1002";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["max_member"]) || strlen($_POST["max_member"]) <= 0) {
	$arrJsonResult["rt_code"] = "1003";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["title"]) || strlen($_POST["title"]) <= 0) {
	$arrJsonResult["rt_code"] = "1004";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["pw"]) || strlen($_POST["pw"]) <= 0) {
	$_POST["pw"] = "";
}

if (empty($_POST["layout_type"]) || strlen($_POST["layout_type"]) <= 0) {
	$arrJsonResult["rt_code"] = "1006";
	die(json_encode($arrJsonResult));
}

if (empty($_POST["mcu_id"]) || strlen($_POST["mcu_id"]) <= 0) {
	$arrJsonResult["rt_code"] = "1007";
	die(json_encode($arrJsonResult));
}

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "9000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

// data check
// 같은 사용자가 겹치는 시간에 회의를 예약하지 못하도록 함
$qry = "SELECT COUNT(*) FROM room_list WHERE user_id = '".$_POST["user_id"]."' AND start_datetime <= '".$_POST["start_datetime"]."' AND end_datetime > '".$_POST["start_datetime"]."'";
$rt = $db->query($qry);
$row = $rt->fetch_row();
if ($row[0] > 0) {
	$arrJsonResult["rt_code"] = "2000";
	$db->close();
	die(json_encode($arrJsonResult));
}
$rt->close(); // add by scchoi

$qry = "INSERT INTO room_list (user_id, start_datetime, end_datetime, max_member, title, pw, layout_type, resolution, record, invite_msg, mcu_id, reg_datetime) ".
		"VALUES ('".$_POST["user_id"]."', '".$_POST["start_datetime"]."', '".$_POST["end_datetime"]."', ".$_POST["max_member"].", '".$_POST["title"]."', '".$_POST["pw"]."', ".$_POST["layout_type"].", ".$_POST["resolution"].", ".$_POST["record"].", '".$_POST["invite_msg"]."', '".$_POST["mcu_id"]."', now())";

$db->query($qry);
if ($db->insert_id <= 0) {
	$arrJsonResult["rt_code"] = "3000";
	$arrJsonResult["error"] = $db->error;
} else {
	$room_id = $db->insert_id;
	$arrJsonResult["room_id"] = $room_id;

	//scchoi for Email
	$emailQuery = "";

	$msg = $_POST["user_id"]."님께서 영상회의에 초대하셨습니다.\n";
	$msg .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
	$msg .= '회의 시간   : '.$_POST["start_datetime"].' ~ '.$_POST["end_datetime"].'\n';
	$msg .= '회의방 제목 : '.$_POST['title'].'\n';
	$msg .= '초대 메시지 : '.$_POST['invite_msg'].'\n';
	
	if (!empty($_POST["member"])) {
		foreach($_POST["member"] as $memID) {
			$qry = "INSERT INTO room_member (room_id, user_id) VALUES (".$room_id.", '".$memID."')";
			$db->query($qry);

			if ( $emailQuery != "" ) $emailQuery .=' or ';
			
			$emailQuery .= ' id ="'.$memID.'" ';

			$qryMsg = "INSERT INTO user_note (to_user_id, from_user_id, message, reg_datetime) VALUES ('".$memID."', '".$_POST["user_id"]."', '".htmlspecialchars($msg)."', now())";
			$db->query($qryMsg);
		}
	}

	if ($emailQuery != "" )
	{ 
		// Email List를 가지고 온다.
		$getEmailListQuery = 'select id, email, allow_mailing from user_basic where '.$emailQuery;
		$rt = $db->query($getEmailListQuery);

		$emailIdx = 0;
		$arrEmailList = array();

		while($row = $rt->fetch_row()) 
		{
			if ( $row[2] == "0 " ) continue;
			$arrEmailList[$emailIdx] = $row[1];	
			$emailIdx++;
		}
		$rt->close();

		// 메일을 보낸다.
		if ( $emailIdx> 0 )
		{
			require_once("./sendmail.php");
			
			$subject = $mail_title." ".$_POST["user_id"]."님께서 영상회의에 초대하셨습니다.";
			
			$article = $message_top;
			$article .= '초대자 아이디:<b>'.$_POST['user_id'].'</b><br>';
			$article .= '예약 시간 : '.$_POST["start_datetime"].' 부터 '.$_POST["end_datetime"].' 까지 <br>';
			$article .= '회의방 제목:'.$_POST['title'].'<br>';
			$article .= '초대 메시지:'.$_POST['invite_msg'].'<br>';
			$article .= $message_bottom;
			
			FLSendMail($arrEmailList, $subject, $article);
		}
	}
}
$db->close();

//$arrJsonResult["qry"] = $qry;

echo json_encode($arrJsonResult);
?>
