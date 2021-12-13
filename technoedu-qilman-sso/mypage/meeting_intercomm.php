<? include "../include/header.php"; ?>

<?
	$is_extsite = false;
	$sipuri = "";
	$sipfrom = "";
	$service_id = "";
	
	if ( isset($_POST['sipuri']) ) 
	{
		$sipuri= $_POST['sipuri'];
	}
	else if ( isset($_POST['extrid']) ) 
	{
		$is_extsite = true;
		
		$sipuri = $_POST['sip_to_uri'];
		$sipfrom = $_POST['sip_from_uri'];
		$title= $_POST['title'];
		$caller_name = $_POST['caller_name'];
		$caller_email = $_POST['caller_email'];
		$service_id = $_POST['service_id'];
	}
?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
	div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
	div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }

#movie { min-width:320px; min-height:240px; border:1px solid #c8c7c7; box-shadow: 3px 3px 3px #888888;}
#movie_option { min-height:50px; clear:both; width:752px; padding-top:3px;}
#movie_option > img { display:block; float:left; width:35px; height:35px; margin-top:3px; margin-right:3px; cursor:pointer;}
.msg_area { width:750px; min-width:250px; padding-left:0px; }
.msg_area > #msg_content { min-width:252px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
.msg_area > #msg_txt { width:750px; height:30px; } 
.msg_area > #msg_txt > #chat_msg { float:left; width:702px; height:30px;  border:1px solid #d6d6d6; } 
.msg_area > #msg_txt > .btn_send { float:left; width:46px; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }

</style>

<script src="../js/SIPml-api.js" type="text/javascript"> </script>
<script type='text/javascript' src="room_comm.js"></script>
<script type='text/javascript' src="../js/dscomm.js"></script>

<script type="text/javascript">

var sip_from = '<?=$sipfrom?>';
var serviceID = '<?=$service_id?>';

window.onbeforeunload = function() {
	sipHangUp();
};

function room_init()
{
<?
	if ( strlen($sipuri) <= 3 )
	{
?>
	alert("SIP URI가 잘못되었습니다.");
	history.back(-1);
<?
	}
	else {
?>
	setTimeout( function() {
		var sip_id = g_user_id;

		if ( sip_from.length > 0 && sip_from.indexOf("@") > 0) {
			sip_id = sip_from.substring(0,sip_from.indexOf("@"));
		}
		/*
		if ( serviceID == 'nablecomm' || serviceID == 'wescan' ) sip_id = sip_from.substring(0,sip_from.indexOf("@"));
		*/

		setMCUInfoInterComm('<?=$sipuri?>', g_user_id, sip_id, sip_id);
	
		sipRegister();
	}, 500);
<?
	}
?>
}

</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2">
			<a href="../conference/reserve.php">회의방 예약</a>
			<a href="../conference/realtime.php" >실시간 회의방 신청</a>
			<!--a href="./invited.php">1:1회의초청</a-->
			<a href="../conference/room_list.php">공개 회의방 목록</a>
			<a href="../conference/intercomm.php" class="sub_select">상호연동</a>
			<span class="path">HOME > 회의방 예약 > 상호연동</span></li>
			<li class="r3"><span>상호 연동</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="mypage" style="margin-top:-25px;">
<? if ( $is_extsite ) {?>
			<p class="title"><?=$title?></p>
			<p>서비스:<?=$service_id?>, 초청자:<?=$caller_name?>(<?=$caller_email?>) </p>
<? } 
else
{
?>
			<!-- 회의방(일반) -->
			<p>연동 SIP 주소는 <?=$sipuri?> 입니다.</p>
<?
}
?>
			<ul id="chat">
				<li id="movie">
					<div id="divVideo" class='div-video'>
						<div id="divVideoRemote" style='height:auto; width:100%'>
							<video class="video" width="100%" height="auto" id="video_remote" autoplay style="opacity: 0; 
								background-color: #FFFFFF; -webkit-transition-property: opacity; -webkit-transition-duration: 2s; margin-bottom:-6px;">
							</video>
						</div>
						<div id="divVideoLocal" style='border:0px solid #000; display:none;'>
							<video class="video" width="88px" height="72px" id="video_local" autoplay muted style="opacity: 0;
								margin-top: -80px; margin-left: 5px; background-color: #000000; -webkit-transition-property: opacity;
								-webkit-transition-duration: 2s;">
							</video>
						</div>
					</div>
				</li>
			<div id="movie_option">
				<img src="../images/option1.png" id=btn_fullscreen>
				<img src="../images/option3.png" id="img_mute_sound">
				<img src="../images/option2.png" id="img_mute_mic">
				<img src="../images/option4.png" id="img_mute_video">
				<button style="float:right;margin-top:3px;" class="btn_small gray" onclick="onEndFunc()">끝내기</button>
			</div>
			<br>
<?
//if ( $is_extsite == true ) 
{
?>
			<p>* 채팅 연동 서비스</p>
				<li class="msg_area">
					<div id="msg_content"></div>
					<div id="msg_txt"><input type="text" id="chat_msg" maxlength="500"><input type="submit" class="btn_send" value="전송" id="chat_send"></div>
				</li>
<?
}
?>

			</ul>
		</div>
	</section>

<script type="text/javascript">
var bIsAudioMute = false;
var bIsVideoMute = false;
var bIsSpeakerMute = false;

$('#btn_fullscreen').click(function(e) {
	var elem = document.getElementById("video_remote");
	if (elem.requestFullscreen) {
		elem.requestFullscreen();
	} else if (elem.mozRequestFullScreen) {
		elem.mozRequestFullScreen();
	} else if (elem.webkitRequestFullscreen) {
		elem.webkitRequestFullscreen();
	}
	return false;
});
	
$('#img_mute_mic').click(function(e) {
	bIsAudioMute = !bIsAudioMute;
	muteLocalAudio(bIsAudioMute);

	if ( bIsAudioMute ) $('#img_mute_mic').attr("src", "../images/option2_off.png");
	else $('#img_mute_mic').attr("src", "../images/option2.png");
});

$('#img_mute_sound').click(function(e) {
	var vid = document.getElementById("video_remote");
	bIsSpeakerMute = !bIsSpeakerMute;
	vid.muted = bIsSpeakerMute;	

	if ( bIsSpeakerMute) $('#img_mute_sound').attr("src", "../images/option3_off.png");
	else $('#img_mute_sound').attr("src", "../images/option3.png");
});

$('#img_mute_video').click(function(e) {
	bIsVideoMute = !bIsVideoMute;
	muteLocalVideo(bIsVideoMute);

	if ( bIsVideoMute) $('#img_mute_video').attr("src", "../images/option4_off.png");
	else $('#img_mute_video').attr("src", "../images/option4.png");
});

function onEndFunc() {
	if ( confirm("회의를 종료합니다. 회의방을 나가시겠습니까?") != 0 )
	{
		sipHangUp();
		location.href = "/";
	}
}

<?
//if ( $is_extsite == true ) 
{
?>
$('#chat_send').click( function (e) {
	var content = $("#chat_msg").val();
	
	if (content.length <= 0) {
		return false;
	}
	$('#msg_content').append('<b>'+g_user_name+':</b> ' + content + '<br>'); 
	$("#chat_msg").val("");
	$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));

	DSSendChatMsg('<?=$sipuri?>', sip_from, g_user_name, g_user_email, content);
	
	return false;
});

$("#chat_msg").keyup( function (e) {
	if (event.keyCode == 13 ) {
			$('#chat_send').click();
	}
	
	return false;
});

function OnDSCommMsg( msg )
{
	console.log(msg);
	if ( msg.cmd == "ChatMsgNotify" ) {
		$('#msg_content').append('<b>'+msg.data.sender.name+':</b> ' + msg.data.msg.text + '<br>'); 
		$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
		
	}
}

// waiting for getting login info 
function InitChat()
{
	if ( g_user_id.length > 0 )
		DSSendChatInit('<?=$sipuri?>', g_user_name, g_user_email);
	else 
		setTimeout( InitChat, 500);
}

DSCommInit(g_dsCommSvr, OnDSCommMsg);
setTimeout( InitChat, 500 );
<?
}
?>

onSipDisconnectFunc = function()
{
	alert("회의 시간이 종료되었거나 다른 이유로 회의방을 닫습니다.");

	setTimeout(function() {
		location.href = "/";
	}, 500);
}

</script>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
