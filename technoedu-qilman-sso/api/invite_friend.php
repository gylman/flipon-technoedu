<?
header('Content-type: application/json');

include "./config/dbinfo.inc.php";

$arrJsonResult = array();
$arrJsonResult["rt_code"] = "0";

$db = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
$db->set_charset("utf8");
if ($db->connect_error) {
	$arrJsonResult["rt_code"] = "1000";
	$arrJsonResult["error"] = $db->connect_error;
	die(json_encode($arrJsonResult));
}

if (!empty($_POST["room_id"])) {
	$room_id = $_POST["room_id"];
	$arrJsonResult["room_id"] = $room_id;
	
	//scchoi for Email -copy by kjsim from reserve.php
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

echo json_encode($arrJsonResult);
?>
