<? include "../include/header.php"; ?>

<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css?v=16042">
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

<script src="../js/SIPml-api.js" type="text/javascript"> </script>
<script type='text/javascript' src="../js/dscomm.js"></script>
<script type="text/javascript" src="js/swfobject.js" ></script>
<script type="text/javascript" src="viewbc.js"></script>

<script type="text/javascript">

$.post('../mcutest/mcucomm.php', {cmd: 'GetBroadcast', uid: '<?=$_POST["uid"]?>'} )
.done( function ( data ) 
	{
		val = eval('(' + data + ')');
		if ( val == null ) 
		{
			alert("error:"+data);
			return;
		}
		if ( val.ret == "false" ) return;

		viewBroadcast(val.url, val.stream); 
	});

</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의 방송 서비스</li>
			<li class="r2">
			<a href="../conference/reserve.php">회의방 예약</a>
			<a href="../conference/realtime.php" >실시간 회의방 신청</a>
			<!--a href="./invited.php">1:1회의초청</a-->
			<a href="../conference/room_list.php">공개 회의방 목록</a>
			<span class="path">HOME > 회의방 예약 > 회의 방송</span></li>
			<li class="r3"><span>회의 방송 서비스</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<div id="movie">
				<div id="movieContainer"> </div>
			</div>
			<div id="msg_area">
				<div id="msg_content"></div>
				<div id="msg_txt"><input type="text" id="chat_msg" maxlength="500"><input type="submit" class="btn_send" value="전송" id="chat_send"></div>
			</div>
		</div>
	</section>

<script type="text/javascript">

var room_id = '<?=$_POST["rid"]?>'+'_chat';
var g_did = getMcuDid(<?=$_POST["rid"]?>);

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


$('#chat_send').click( function (e) {
	var content = $("#chat_msg").val();
	
	if (content.length <= 0) {
		return false;
	}
	var msg = '{"cmd":"chat", "roomidx": "'+room_id+'", "user_id": "'+g_user_id+'", "user_name":"'+g_user_name+'", "content":"'+ content +'"}';
	connection.send(msg);
	//$('#msg_content').append('<b>'+g_user_name+':</b> ' + content + '<br>'); 
	chat_msg_add(g_user_name, content, true, 'yellow');

	$("#chat_msg").val("");

	$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	
	return false;
});

$("#chat_msg").keyup( function (e) {
	if (event.keyCode == 13 ) {
			$('#chat_send').click();
	}
	
	return false;
});

var connection = new WebSocket(g_presenceServerUrl);

connection.onopen = function () {
	connection.send('{"cmd":"enter_room", "roomidx": "'+room_id+'", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'", "user_email": "'+g_user_email+'", "roomaddr":"'+g_did+'@'+g_outboundSipSvrUrl.substring(6)+'"}');
	
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
	
	if ( json.cmd == "add_user" )
	{
	}

	if ( json.cmd == "exit_room" )
	{
		if (typeof json.user_id != "undefined") {
			/*
			if (json.user_id == g_roomMaker) {
				// 방장이 나갔을 경우 모든 참여자를 강퇴시킴
				alert('방장이 퇴실했습니다');
				location.href = "/";
			} else 
			*/

			{
				// 일반 참여자가 나갔을 경우 해당 참여자만 제거함
				//$('#msg_content').append('<b>'+json.user_name+'('+json.user_id+')님이 방에서 나가셨습니다.</b><br>');
				chat_msg_add( json.user_name+'('+json.user_id+')', '님이 방에서 나가셨습니다.', false, 'pink');
				$('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
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
					connection.send('{"cmd":"exit_room", "roomidx": "'+room_id+'", "user_id":"'+g_user_id+'", "user_name":"'+g_user_name+'"}');
				}

				alert('방장에 의해 퇴장당하셨습니다');
				
				setTimeout(function() {
					location.href = "/";
				}, 500);
			}
		}
	}
	else if ( json.cmd == "chat" )
	{
		if (json.content.length <= 0) {
			return false;
		}
		
		//$('#msg_content').append('<b>'+json.user_name+ ':</b> ' + json.content+ '<br>'); 
		chat_msg_add( json.user_name, json.content, false, 'blue');

		 $('#msg_content').scrollTop($('#msg_content').prop('scrollHeight'));
	}
}

</script>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
