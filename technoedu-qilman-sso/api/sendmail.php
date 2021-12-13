<?
$mail_title = "[FaceLink 영상협업 서비스] ";
$message_top = '안녕하세요. 반갑습니다. HTML5기반 영상 협업 서비스 <b>FaceLink</b>입니다.<br>'
			  .'당신은 FaceLink회원으로부터 영상 협업 서비스에 다음과 같이 초대되었습니다.<br><br>';
$message_bottom = '<br>해당 시간에 <a href="http://nia.wsmedia.koren.kr" target=_blank><b>FaceLink</b></a>를 방문하시고 로긴하신 다음 <b> "MyFaceLink"</b>를 누르셔셔 해당 회의실로 참가 해 주시면 됩니다.<br>'
			    .'저희 서비스를 이용해 주셔셔 감사드립니다. 안녕히 계십시요<br>'
				.'<br><br><a href="http://nia.wsmedia.koren.kr" target=_blank><img src="http://nia.wsmedia.koren.kr/images/sub_logo.png"></a>'
				.'<br><font color=gray>Copyright <a href="http://wooksungmedia.com" target=_blank><font color=gray>Wooksungmedia</font></a> inc. All Rights Reserved.</font>';

function FLSendMail($tolist, $subject, $content)
{
	// SendMail통하여 Mail을 보낸다.
	$mailList = '';

	$cnt = count($tolist);
	for ( $i=0; $i<$cnt; $i++ )
	{
		if ( $i > 0 ) $mailList .= ',';
		$mailList .= $tolist[$i];
	}

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <facelink@nia.wsmedia.koren.kr>' . "\r\n";
	mail($mailList, $subject, $content, $headers);
}
// SendMail Version for External Mail Server
/*

require_once("../mail/class.phpmailer.php");
require_once("../mail/class.smtp.php");

function FLSendMail($tolist, $subject, $content)
{
	$smtp_addr ="smtp.works.naver.com";
	$mail_sender_id = "facelink@wooksungmedia.com";
	$mail_sender_pw = "wsmedia2014";

	$mail=new PHPMailer(true);
	$mail->IsSMTP();
	try{
			$mail->Host=$smtp_addr;
			$mail->SMTPAuth=true;
			$mail->Port=465;
			$mail->SMTPSecure="ssl";
			$mail->Username=$mail_sender_id;
			$mail->Password=$mail_sender_pw;
			$mail->SetFrom($mail_sender_id);

			$cnt = count($tolist);

			for ( $i=0; $i<$cnt; $i++ )
			{
				$mail->AddAddress($tolist[$i]);
			}

			$mail->Subject=$subject;
			$mail->MsgHTML($content);
			$mail->Send();
	}
	catch (phpmailerException $e){
		echo $e->errorMessage();
	}
	catch (Exception $e){
		echo $e->getMessage();
	}
}
*/

?>
