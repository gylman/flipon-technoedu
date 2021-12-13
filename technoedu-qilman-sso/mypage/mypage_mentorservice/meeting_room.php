<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
	div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
	div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
	div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }
</style>

<script type="text/javascript">

$.ajaxSetup({async:false});

<?
if (!empty($_POST["rid"])) {
	echo "var g_rid = ".$_POST["rid"].";\n";
}

if (!empty($_POST["rpw"])) {
	echo "var g_rpw = '".$_POST["rpw"]."';\n";
}
?>

if (g_rid.length <= 0) {
	alert('회의방 번호가 없습니다\n다시 확인해 주세요');
	history.back(-1);
}

var g_did = getMcuDid(g_rid);
var g_uid = '';

var bIsAudioMute = false;
var bIsVideoMute = false;

$(document).ready(function() {
	
	$('#room_remove').click(function(e) {
		
		document.getElementById('sipml5').contentWindow.sipHangUp();
		
        if (g_uid.length > 0) {
			$.post('../mcutest/mcucomm.php', {cmd: 'RemoveConference', uid: g_uid});
		}
		
		setTimeout( function() {
			location.href = "/";
		}, 500);
		return false;
    });
	
	$('#room_exit').click(function(e) {
        document.getElementById('sipml5').contentWindow.sipHangUp();
		location.href = "/";
		return false;
    });
	
	$('#btn_fullscreen').click(function(e) {
        document.getElementById('sipml5').contentWindow.toggleFullScreen();
		return false;
    });
	
	$('#btn_mute_sound').click(function(e) {
		if (!bIsAudioMute) {
	        $.post('../mcutest/mcucomm.php', {cmd: 'setAudioMute', uid: g_uid, partId: g_user_id+'@mentorservice.co.kr', flag: 1} );
		} else {
			$.post('../mcutest/mcucomm.php', {cmd: 'setAudioMute', uid: g_uid, partId: g_user_id+'@mentorservice.co.kr', flag: 0} );
		}
		
		bIsAudioMute = !bIsAudioMute;
    });
	
	$('#btn_mute_video').click(function(e) {
		if (!bIsVideoMute) {
	        $.post('../mcutest/mcucomm.php', {cmd: 'setVideoMute', uid: g_uid, partId: g_user_id+'@mentorservice.co.kr', flag: 1} );
		} else {
			$.post('../mcutest/mcucomm.php', {cmd: 'setVideoMute', uid: g_uid, partId: g_user_id+'@mentorservice.co.kr', flag: 0} );
		}
		
		bIsVideoMute = !bIsVideoMute;
    });
});	

function iframe_init() {
	$.post( g_apiUrlRoot+"room_info.php", {rid:g_rid}, function(dataJson) {
		
		$('.title').text(dataJson.title);
		
		if (dataJson.pw != g_rpw) {
			alert('회의방의 비밀번호가 맞지 않습니다\n확인 후 다시 입장해 주세요');
			history.back(-1);
			return false;
		}
		
		// get room uid
		$.post('../mcutest/mcucomm.php', {cmd: 'GetConfList'} )
		.done( 
			function ( data ) {
				val = eval('(' + data + ')');
				if ( val == null ) {
					alert("error:"+data);
					return;
				}
				
				for ( var i = 0; i < val.conflist.length; i++ ) {
					if (val.conflist[i].did == g_did) {
						g_uid = val.conflist[i].uid;
						break;
					}
				}
			}
		);
		
		if (g_user_id == dataJson.user_id) { // 방장
		
			$('.mem_func').hide();
			$('.room_func').show();
		
			if (g_uid.length <= 0) {
				$.post('../mcutest/mcucomm.php', {cmd: 'RemoveConference', uid: g_uid});
				$.post('../mcutest/mcucomm.php', {
					cmd: 'CreateConference',
					name: g_rid,
					did: g_did,
					mixerId: 'mixer',
					profileId: 'HD',
					compType: dataJson.layout_type,
					vad: 0,
					size: 6,
					} 
				);
			}
		} else { // 참여자
		
			$('.mem_func').show();
			$('.room_func').hide();
		
			if (g_uid.length <= 0) {
				alert('회의방이 존재하지 않습니다\n확인 후 다시 참여해 주세요');
				history.back(-1);
				return false;
			}
		}
		
		setTimeout( function() {
			document.getElementById('sipml5').contentWindow.setMCUInfo(g_did, g_user_id, g_user_id, dataJson.pw);
			document.getElementById('sipml5').contentWindow.sipRegister();
		}, 500);
	},
	'json'
	);
}
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My FaceLink > 나의 회의</span></li>
			<li class="r3"><span>나의 회의</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<p class="title">영업부 주간회의</p>
			<!-- 회의방(일반) -->
			<ul id="chat">
				<li id="movie">
					<!--video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video-->
                    <iframe id="sipml5" frameborder="0" width="710" height="340" src="../sipml5/call_custom.htm" scrolling="no" style="overflow:hidden;"></iframe>
				</li>
                <!-- 회의방(일반) -->
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input id="btn_fullscreen" type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input id="btn_mute_sound" type="button" class="btn_small blue" value="음성 소거"><input id="btn_mute_video" type="button" class="btn_small blue" value="영상 중지">
							<input id="room_exit" type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
                    
                    <ul class="room_func">
						<li>방 제어 기능(방장)</li>
						<li>
							<input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small blue" value="화면 레이아웃 설정">
							<input type="button" class="btn_small blue" value="화면 위치 변경"><input type="button" class="btn_small blue" value="음성/영상">
							<input id="room_remove" type="button" class="btn_small darkgray" value="퇴장">
						</li>
					</ul>
                    
                    <ul class="invited_func" style="display:none;">
						<li>초대하기</li>
						<li>
							<span style="inline-block; float:left; width:45%; padding:10px 0px 5px 0px; text-align:center; "><input type="radio"> 회원초대</span>
							<span style="inline-block; float:left; width:45%; padding:10px 0px 5px 0px; text-align:center; "><input type="radio"> SIP 단말 초대</span>
							<input type="text" value="회원 ID/단말 번호" style="width:300px; height:30px; line-height:30px; margin:5px 20px;">
							<span style="display:block; width:220px; margin:5px auto; "><input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small gray" value="취소"></span>
						</li>
					</ul>
                    
                    <!-- 화면 레이아웃 설정 -->
					<ul class="screen_layout_func" style="display:none;">
						<li>화면 레이아웃 설정</li>
						<li>
							<span>종류<BR>
								<select>
									<option>2X2</option>
									<option>4X4</option>
									<option>1+PIP1</option>
									<option>1+PIP3</option>
									<option>1+5</option>
									<option>1+7</option>
								</select>
							</span>
							<span><img src="../images/screen4.png"></span>							
							<span><input type="button" class="btn_small blue" value="변경"><BR><input type="button" class="btn_small gray" value="취소"></span>
						</li>
					</ul>

					<!-- 화면 위치 변경 -->
					<ul class="screen_position_func" style="display:none;">
						<li>화면 위치 변경</li>
						<li>
							<span><img src="../images/screen4.png"></span>							
							<span>
								위치1
								<select>
									<option>자동</option>
									<option>이사님</option>
									<option>사장님</option>
									<option>잠금</option>
								</select>
								<BR>								
								위치2
								<select>
									<option>이사님</option>
								</select>
								<BR>
								위치3
								<select>
									<option>사장님</option>
								</select>
								<BR>
								위치4
								<select>
									<option>잠금</option>
								</select>
							</span>
						</li>
					</ul>

					<!-- 음성 및 영상 제어 -->
					<ul class="voice_func" style="display:none;">
						<li>음성 및 영상 제어</li>
						<li>
							<ul>
								<li>번호</li>
								<li>이름</li>
								<li>음성 제어</li>
								<li>영상 제어</li>
							</ul>
							<ul>
								<li>1</li>
								<li>홍길동</li>
								<li><img src="../images/voice_on.png"></li>
								<li><img src="../images/video_off.png"></li>
							</ul>
							<ul>
								<li>2</li>
								<li>이사님</li>
								<li><img src="../images/voice_off.png"></li>
								<li><img src="../images/video_on.png"></li>
							</ul>
							<ul>
								<li>3</li>
								<li>홍길순</li>
								<li><img src="../images/voice_on.png"></li>
								<li><img src="../images/video_off.png"></li>
							</ul>
						</li>
					</ul>

					<!-- 사용자 리스트 -->
					<ul class="user_list" style="display:none;">
						<li>사용자 리스트</li>
						<li>
							<ul>
								<li>번호</li>
								<li>이름</li>
								<li>강제퇴장</li>
							</ul>
							<ul>
								<li>1</li>
								<li>홍길동</li>
								<li><input type="button" value="퇴장"></li>
							</ul>
							<ul>
								<li>2</li>
								<li>이사님</li>
								<li><input type="button" value="퇴장"></li>
							</ul>
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
                
                <!-- 회의방(방장) - 자료공유 -->
                <li id="pdf_area" style="display:none;">
					<div class="pdf_btn">
						<input type="button" title="처음">
						<input type="button" title="이전">
						<input type="button" title="다음">
						<input type="button" title="끝">
						<input type="button" value="지우기" title="지우기">
					</div>
					<div class="pdf_color">
						<span class="color1"></span>
						<span class="color2"></span>
						<span class="color3"></span>
						<span class="color4"></span>
						<span class="color5"></span>
						<span class="color6"></span>
					</div>
					<div class="pdf_file"></div>
				</li>
				<li id="movie_func" style="display:none;">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<ul class="room_func">
						<li>방 제어 기능(방장)</li>
						<li>
							<input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small blue" value="화면 레이아웃 설정">
							<input type="button" class="btn_small blue" value="화면 위치 변경"><input type="button" class="btn_small blue" value="음성/영상">
							<input type="button" class="btn_small darkgray" value="퇴장">
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>