<? include "../include/header.php"; ?>
<?
	$sipnumber= "";
	
	if ( isset($_POST['sipnumber']) ) 
	{
		$sipnumber= $_POST['sipnumber'];
	}
?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">
<link rel="stylesheet" type="text/css" href="../css/chatbubble.css">

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

<script src="../sipjs/sip.js?v=1" type="text/javascript"> </script>
<script type='text/javascript'></script>

<script type="text/javascript">
window.onbeforeunload = function() {
	sipHangUp();
};

function room_init()
{
<?
	if ( strlen($sipnumber) <= 2 )
	{
?>
        alert("번호가 잘못되었습니다.");
        history.back(-1);
<?
    }
    else if ( substr($sipnumber, 0, 3) == "090" )
	{
?>
        alert("사용할 수 없는 번호입니다.");
        history.back(-1);
<?
	}
	else {
?>
    setTimeout( function() {
        setMCUInfo("<?=$sipnumber?>", g_user_id, g_user_id, g_user_id);
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
			<a href="../conference/directcomm.php" class="sub_select">번호 연결 서비스</a>
			<span class="path">HOME > 회의방 예약 > 번호 연결 서비스</span></li>
			<li class="r3"><span>번호 연결 서비스</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="mypage" style="margin-top:-25px;">
			<ul id="chat">
				<li id="movie">
					<div id="divVideo" class='div-video'>
						<div id="divVideoRemote" style='height:auto; width:100%'>
							<video class="video" width="100%" height="auto" id="video_remote" autoplay style="opacity: 100; 
								background-color: #FFFFFF; -webkit-transition-property: opacity; -webkit-transition-duration: 2s; margin-bottom:-6px;">
							</video>
						</div>
						<div id="divVideoLocal" style='border:0px solid #000; display:none;'>
							<video class="video" width="88px" height="72px" id="video_local" autoplay muted style="opacity: 0;
								margin-top: -80px; margin-left: 5px; background-color: #000000; -webkit-transition-property: opacity;
								-webkit-transition-duration: 2s;">
							</video>
                            <canvas id="video_canvas" width="320" height="180"></canvas>
						</div>
					</div>
				</li>
			<div id="movie_option">
				<img src="../images/option1.png" id=btn_fullscreen>
				<img src="../images/option3.png" id="img_mute_sound">
				<img src="../images/option2.png" id="img_mute_mic">
				<img src="../images/option4.png" id="img_mute_video">
				<img src="../images/option7.png" id="img_screenshare"></a>
				<img src="../images/switch_cam.png" id="btn_camswitch"></a>

				<button style="float:right;margin-top:3px;" class="btn_small gray" onclick="onEndFunc()">끝내기</button>
			</div>
			<br>
			</ul>

			<ul id="movie_chat">
				<!-- 음성 및 영상 제어 -->
				<li class="msg_area">
					<div id="msg_content"></div>
					<div id="msg_txt"><input type="text" id="chat_msg" maxlength="500"><input type="submit" class="btn_send" value="전송" id="chat_send"></div>
				</li>
			</ul>



            <!--
            <table border=0><tr><td>
            <video width=320 height=240 muted autoplay></video>
            </td>
            <td>&nbsp;</td>
            <td>
            <canvas id="meter" width="50" height="240"></canvas>
            </td></tr></table>

                <div class="select">
                    <label for="videoSource">카메라: </label><select id="videoSource" style="width:250px;"></select>
                </div>
                <input id="cameraSelect" type="button" value="카메라변경" class="btn_small blue" style="margin-left:110px;">
            -->




		</div>
	</section>

<script src="../sipjs/sip.js?v=20" type="text/javascript"> </script>
<script type='text/javascript' src="room_comm.js?v=42"></script>
<script type='text/javascript'>
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

$('#btn_camswitch').click(function(e) {
    switchCamera();
});

$('#cameraSelect').click( function() {
    selectCamera($('#videoSource').val())
    alert("디바이스 설정이 저장되었습니다.");
});

function onEndFunc() {
	if ( confirm("회의를 종료합니다. 회의방을 나가시겠습니까?") != 0 )
	{
		sipHangUp();
		location.href = "/";
	}
}
onSipDisconnectFunc = function()
{
	alert("회의 시간이 종료되었거나 다른 이유로 회의방을 닫습니다.");

	setTimeout(function() {
		location.href = "/";
	}, 500);
}


// Chat Function JEONG 20200423 moved from meeting_layout.php


var pointerSize = 13; // pointer image size is 25
//-----------------------------------------------------------------------
// Websocket Part
//-----------------------------------------------------------------------
"use strict";

// if user is running mozilla then use it's built-in WebSocket
window.WebSocket = window.WebSocket || window.MozWebSocket;

// if browser doesn't support WebSocket, just show some notification and exit
if (!window.WebSocket) {
	alert('브라우져가 WebSocket 기술을 제공하지 않습니다.' );
}

var g_userInfoList = new Array();

// open connection
//var connection = new WebSocket('ws://127.0.0.1:1337');
var connection = new WebSocket(g_presenceServerUrl);

connection.onopen = function () {
	//connection.send('{"cmd":"enter_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+"<?=$sipnumber?>"+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
	connection.send('{"cmd":"enter_room", "roomidx": "<?=$sipnumber?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+"<?=$sipnumber?>"+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
	
    // 일반
    $('.chat_list .list').append('<ul>\
            <li>'+g_user_name+'('+g_user_id+')'+'</li>\
        </ul>');

	g_userInfoList.push({id:g_user_id, name:g_user_name, partId:"0", amute:"false", vmute:"false", is_external:"false"});
	
	chat_msg_add( g_user_name+'('+g_user_id+')', '님이 방에 참여하셨습니다.', false, 'pink');
};

connection.onerror = function (error) {
	alert('문서 공유 서버 접속에 실패했습니다.' );
};

// most important part - incoming messages
connection.onmessage = function (message) {

	// try to parse JSON message. Because we know that the server always returns
	// JSON this should work without any problem but we should make sure that
	// the massage is not chunked or otherwise damaged.
	try {
		var json = JSON.parse(message.data);
	} catch (e) {
		alert('This doesn\'t look like a valid JSON:', message.data);
		return;
	}

	if ( json.cmd == "enter_room" )
	{
		chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에 참여하셨습니다.', false, 'pink');
		$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	}
	
	if ( json.cmd == "exit_room" )
	{
		if (typeof json.user_id != "undefined") {

			{
				// 일반 참여자가 나갔을 경우 해당 참여자만 제거함
				//$('#msg_content').append('<b>'+json.user_name+'('+json.user_id+')님이 방에서 나가셨습니다.</b><br>');
				chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에서 나가셨습니다.', false, 'pink');
				$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
				
				$('ul[data-user-id="'+json.user_id+'"]').remove();
				
			}
		}
	}
	
	// 강퇴
	if ( json.cmd == "exit_force" )
	{
		if (typeof json.user_id != "undefined") {
			if (json.user_id == g_user_id) {
				
				if (connection != null) {
					//alert('{"cmd":"enter_exit", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
					//connection.send('{"cmd":"exit_room", "roomidx": "<?=$room_id?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
					connection.send('{"cmd":"exit_room", "roomidx": "<?=$sipnumber?>", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
				}

				alert('방장에 의해 퇴장당하셨습니다');
				
				setTimeout(function() {
					location.href = "/";
				}, 500);
			}
		}
	}

	if ( json.cmd == "chat" )
	{
		if (json.content.length <= 0) {
			return false;
		}
		
		//$('#msg_content').append('<b>'+json.user_name+ ':</b> ' + json.content+ '<br>'); 
		chat_msg_add( json.user_name, json.content, false, 'blue');

		 $('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	}
}

$('#chat_send').click( function (e) {
	var content = $("#chat_msg").val();
	
	if (content.length <= 0) {
		return false;
	}
	
	//var msg = '{"cmd":"chat", "roomidx": "<?=$room_id?>", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
	var msg = '{"cmd":"chat", "roomidx": "<?=$sipnumber?>", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
	connection.send(msg);
	//$('#msg_content').append('<b>'+g_user_name+':</b> ' + content + '<br>'); 
	chat_msg_add(g_user_name, content, true, 'yellow');

	$("#chat_msg").val("");

	$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	
	return false;
});

function chat_msg_add( name, content, isRight, color )
{
	if ( isRight ) { 
		$('#msg_content').append('<div class="bubble bubble-alt '+color+'"><p>' +content + ': <b>'+name+'</b></p></div>'); 
 	}
	else {
		if ( color == 'pink' ) // system message
			$('#msg_content').append('<div class="bubble '+color+'"><p><b>'+name+'</b> ' +content + '</p></div>'); 
		else
			$('#msg_content').append('<div class="bubble '+color+'"><p><b>'+name+'</b> : ' +content + '</p></div>'); 
	}
}

$("#chat_msg").keyup( function (e) {
	if (event.keyCode == 13 ) {
			$('#chat_send').click();
	}
	
	return false;
});





// ----------- SIP.JS Contents Share Code ------- Modify by spbrain 20200406
function createUA(callerURI, displayName) {
    // https://stackoverflow.com/questions/7944460/detect-safari-browser
    var browserUa = navigator.userAgent.toLowerCase();
    var isSafari = false;
    var isFirefox = false;
    if (browserUa.indexOf("safari") > -1 && browserUa.indexOf("chrome") < 0) {
        isSafari = true;
    }
    else if (browserUa.indexOf("firefox") > -1 && browserUa.indexOf("chrome") < 0) {
        isFirefox = true;
    }

    // add by scchoi
    wsModifier = function(description) {
        //console.log("SCCHOI> Modifier:");
        //console.log(description);
        if ( description.type == "offer" )
        {
            description.sdp = description.sdp.replace("a=group:BUNDLE 0", "a=group:BUNDLE video");
            description.sdp = description.sdp.replace("a=mid:0", "a=mid:video");

        }
        else {
            description.sdp = description.sdp.replace("profile-level-id=4d 032","profile-level-id=4d0032");
        }
        return Promise.resolve(description);
    }


    var sessionDescriptionHandlerFactoryOptions = {};
    sessionDescriptionHandlerFactoryOptions.modifiers = [wsModifier];

    if (isFirefox) {
        sessionDescriptionHandlerFactoryOptions.alwaysAcquireMediaFirst = true;
    }

    var configuration = {
        uri: callerURI,
        authorizationUser: displayName,
        password: displayName,
        displayName: displayName,
        // Undocumented "Advanced" Options
        userAgentString: "Mentorservice",
        register: true,
        contactName: displayName,
        sessionDescriptionHandlerFactoryOptions: sessionDescriptionHandlerFactoryOptions,
        transportOptions: {
            traceSip: true,
            wsServers: g_webSocketServerURL
        }
    };
    var userAgent = new SIP.UA(configuration);
    return userAgent;
}

var sessionContent;
var sessionContentStateus = 'none';

function setupShareMediaBandwidth() {
    if (sessionContent) {
        var pc = sessionContent.sessionDescriptionHandler.peerConnection;
        if (pc.getSenders) {
            pc.getSenders().forEach(function (sender) {
                var track = sender.track;
                if (track && track.kind === "video") {
                    const parameters = sender.getParameters();
                    if ( !parameters.encodings) {
                        parameters.encodings = [{}];
                    }
                    parameters.encodings[0].maxBitrate = 2048 * 1000; // 2Mbps
                    parameters.encodings[0].networkPriority = "high";
                    parameters.encodings[0].priority = "high";
                    sender.setParameters(parameters)
                    .then(() => {
                        console.log("Set Shared Bandwidth Completed");
                        console.log(parameters);
                    })
                    .catch(e => console.error(e));
                }
            });
        }
    }
};

function makeShareCall(userAgent, target, audio, video, remoteRender, localRender) {
    // makes the call
    var options = { 
        sessionDescriptionHandlerOptions: {
            constraints: {
                sharescreen: true,
                audio: false,
                video: {width:1280, height:720}
            }
        }
    };

    console.log("invite.option:");
    console.log(options);

    var modifierArray = [];
    try {
        sessionContent = userAgent.invite('sip:' + target, options, modifierArray );
    }
    catch (error) {
        alert("해당 브라우져가 공유기능을 지원하지 않습니다.\n브라우져를 최신버전으로 업그레이드 해주세요.");
        return;
    }

    sessionContentStateus = 'inviting';
    sessionContent.on('accepted', function () {
            sessionContentStateus = 'accepted';
            console.log("Accept!\n");

	        setTimeout( setupShareMediaBandwidth, 1000); 
	        setTimeout( updateConfRoomUserList, 100); 
            });
    sessionContent.on('bye', function () {
            sessionContent = null;
            sessionContentStateus = 'none';	
            console.log("Content:Bye Receive!\n");
            });

}

var uaContents = createUA(g_user_id + "_content@mentorservice.co.kr", g_user_id + "_content");
var markAsRegistered = function () {
	console.log("SharedContent UA Regiseterd Content!!");
};
uaContents.on('registered', markAsRegistered);

$("#img_screenshare").click(function(){
	if ( sessionContentStateus == 'waiting' )
	{
		//Nothing
		console.log("Waiting connect..\n");
	}
	else if ( sessionContentStateus == 'accepted')
	{
        sessionContent.bye();
        sessionContent = null;
		sessionContentStateus = 'none';	
		$('#img_screenshare').attr("src", "../images/option7.png");
	    setTimeout( updateConfRoomUserList, 100); 
	}
	else if ( sessionContentStateus == 'inviting' )
	{
        sessionContent.cancel();
        sessionContent = null;
		sessionContentStateus = 'none';	
		$('#img_screenshare').attr("src", "../images/option7.png");
	}
	else {
		sessionContentStateus = 'waiting';	
		//var target = g_did + '@' + g_sipSvrUrl;
		var target = "<?=$sipnumber?>" + '@' + g_sipSvrUrl;
		makeShareCall(uaContents, target, false, true, null, null);

		$('#img_screenshare').attr("src", "../images/option7_off.png");
	}
});

var g_uid = '';
var oldRoomUserListData = "none";

function updateConfRoomUserList()
{
    /*
	// get room uid
	$.post('../mcutest/mcucomm.php', {cmd: 'GetConfPartList', uid: g_uid} )
	.done( 
		function ( data ) {

			if ( oldRoomUserListData == data ) {
				console.log("mcuList no changed");
				return;
			}
			oldRoomUserListData = data;

			val = eval('(' + data + ')');
			if ( val == null ) 
			{
				alert("error:"+data);
				return;
			}
			
			for ( var i = 0; i < val.partlist.length; i++ ) 
			{
				var findUser = false;
				var user_id = val.partlist[i].name.match(/^(.+)@/)[1];
				var devName = val.partlist[i].devName.replace(/@*./,""); //add by scchoi for DevName from MCU device_list.xml
				console.log("part:"+user_id);
				for (var j = 0; j < g_userInfoList.length; j++) 
				{
					if ( user_id == g_userInfoList[j].id )
					{
						findUser = true;
						console.log("find User:"+user_id+", partid:"+val.partlist[i].partid+"a:"+val.partlist[i].amute+", v:"+val.partlist[i].vmute);
						g_userInfoList[j].partId = val.partlist[i].partid;
						g_userInfoList[j].amute = val.partlist[i].amute;
						g_userInfoList[j].vmute = val.partlist[i].vmute;
						
						if ( g_userInfoList[j].amute == "true" )
							$('#uctl_amute_'+user_id).attr("src", "../images/v_off.png");
						else
							$('#uctl_amute_'+user_id).attr("src", "../images/v_on.png");

						if ( g_userInfoList[j].vmute == "true" )
							$('#uctl_vmute_'+user_id).attr("src", "../images/m_off.png");
						else
							$('#uctl_vmute_'+user_id).attr("src", "../images/m_on.png");
					}
				}
				if ( findUser == false )
				{	
					// Not Internal User
					addUserInfo(user_id, devName, val.partlist[i].partid, val.partlist[i].amute, val.partlist[i].vmute, "true");
				}
			}
			
			// Reverse Find miss user
			for (var j = 0; j < g_userInfoList.length; j++) 
			{
				findUser = false;
				if ( g_userInfoList[j].is_external == "false" ) continue;

				for ( var i = 0; i < val.partlist.length; i++ ) 
				{
					var user_id = val.partlist[i].name.match(/^(.+)@/)[1];
					if ( user_id == g_userInfoList[j].id ) findUser = true;
				}
				
				if ( findUser == false )
				{
					$('ul[data-user-id="'+g_userInfoList[j].id +'"]').remove();
					g_userInfoList.remove(j);
					j--;
				}
			}
			
			updatePosSelData();
		}
	);

	setTimeout( updateConfRoomUserList, 10*1000 ); // every 10 sec
    */
}





</script>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
