<? include "../include/header.php";?>
<!-- 공개 회의방 목록 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<style>
</style>
<?php 
	session_start(); $userids = $_SESSION["user_id"];
	$conn = mysqli_connect("localhost", "mentorservice", "roskfl");
    mysqli_select_db($conn, "facelink");
	$query = "SELECT id FROM emailCheck WHERE email = '".$_SESSION['userEmail']."'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	if(isset($row['id'])) {
		$query = "SELECT * FROM emailCheck WHERE id = '".$row['id']."'";
		$result = mysqli_query($conn, $query);
		$checkEnterRoom = mysqli_fetch_assoc($result);
	}
?>

<script type="text/javascript">

$.ajaxSetup({async:false});

var g_uid = new Array();
var g_selectedRoomID;
$(document).ready(function() {
	$("#btn_go_realtime").click(function(){ location.href="./realtime.php"; });
	$("#btn_go_reserve").click(function(){ location.href="./reserve_step1.php"; });
	$("#btn_go_direct").click(function(){ location.href="./directcomm.php"; });
	$('body').on('click', 'span.state2', function() {					
		if (g_user_id.length <= 0) {
			alert('회의에 입장하시려면 먼저 로그인해 주세요');
			return false;
		}
		if ($(this).data('room-pw') == '1') {																						
		var roomNumber = "<? echo $_SESSION["roomNumber"];?>";
		if(roomNumber == $(this).data('room-id')){
			g_selectedRoomID = $(this).data('room-id');
    		$('html,body').scrollTop(0);
	    	disableScroll();                
		    $('#input_room_pw').val('');    
			$.post( g_apiUrlRoot+"room_info.php", {rid:g_selectedRoomID}, function(dataJson) {
				var url = '../mypage/meeting_layout.php';
				var form = $('<form action="' + url + '" method="post">' +
				'<input type="text" name="rid" value="' + g_selectedRoomID + '" />' +
				'<input type="text" name="rpw" value="' + dataJson.pw + '" />' +
				'</form>');
				$('body').append(form);                                                                                form.submit();
				},
			'json');
		}else{
				g_selectedRoomID = $(this).data('room-id');
				$('html,body').scrollTop(0);
				disableScroll();                
				$('#input_room_pw').val('');    
				$('#form_pw').show();
			}
		}
});
$('body').on('click', 'span.broadcast', function() {	
		if (g_user_id.length <= 0) {
			alert('회의에 입장하시려면 먼저 로그인해 주세요');
			return false;
		}
		g_selectedRoomID = $(this).data('room-id');
		var selectedUid= $(this).data('room-uid');
		
		var url = '../mypage/broadcast_layout.php';
		var form = $('<form action="' + url + '" method="post">' +
			'<input type="text" name="uid" value="' + selectedUid + '" />' +
			'<input type="text" name="rid" value="' + g_selectedRoomID+ '" />' +
			'</form>');
		$('body').append(form);
		form.submit();
	});
	
	$('#close_form_pw').click(function(e) {
		$('#form_pw').hide();
		enableScroll();
    });
	
	$('#close_form_pw2').click(function(e) {
		$('#form_pw').hide();
		enableScroll();
    });
	
	$('#submit_form_pw').click(function(e) {
       $.post( g_apiUrlRoot+"room_info.php", {rid:g_selectedRoomID}, function(dataJson) {
			if (dataJson.rt_code == 0) {
				if (dataJson.pw == $('#input_room_pw').val()) {
					//var url = '../mypage/meeting_room.php';
					var url = '../mypage/meeting_layout.php';
					if ( g_user_level >= 20 ) url = '../mypage/meeting_layout.php';
					var form = $('<form action="' + url + '" method="post">' +
					  '<input type="text" name="rid" value="' + g_selectedRoomID + '" />' +
					  '<input type="text" name="rpw" value="' + $('#input_room_pw').val() + '" />' +
					  '</form>');
					$('body').append(form);
					form.submit();
				} else {
					alert('회의방의 비밀번호가 맞지 않습니다\n확인 후 다시 입장해 주세요');
				}
			}
		},
		'json');
    });
	
	refreshRoomList();
	setInterval(function() {
		refreshRoomList();
	}, 30000);
});

function refreshRoomList() {
	
	$('#common_room_list > ul').not('.title').remove();
	
	$.ajaxSetup({async:false});

	$.post('../mcutest/mcucomm.php', {cmd: 'GetConfList'} )
	.done( 
		function ( data ) {
			val = eval('(' + data + ')');
			if ( val == null ) {
				alert("error:"+data);
				return;
			}
			
			var roomUID = '';
			for ( var i = 0; i < val.conflist.length; i++ ) {
				g_uid[val.conflist[i].did] = val.conflist[i].uid;
			}
		}
	);
	
	$.post( g_apiUrlRoot+"room_list.php", function(dataJson) {
		_.each(dataJson.room_list, function(room) {
			var currMember = 0;
			var state = "state1";
			var stateLabel = "대기중";
			
			if ( room.is_starttime == '1' ) {
				if (room.user_id = g_user_id) { // 방장
					state = "state2";
					stateLabel = "입장";
					
					if (!_.isUndefined(g_uid[getMcuDid(room.id)])) {
						$.post('../mcutest/mcucomm.php', {
								cmd: 'GetConfPartList',
								uid: g_uid[getMcuDid(room.id)]
								}
						)
						.done( 
							function ( data )
							{	
								//alert(data);
								val = eval('(' + data + ')');
								if ( val == null ) 
								{
									alert("error:"+data);
									return;
								}
								
								currMember = val.partlist.length;
								state = "state2";
								stateLabel = "입장";
								
								for ( var i = 0; i < val.partlist.length; i++ ) {
									if (val.partlist[i].devName.indexOf(g_user_id+"@") == 0) {
										state = "state1";
										stateLabel = "참여중";
										break;
									}
								}
							}
						);
					}
				} else if (!_.isUndefined(g_uid[getMcuDid(room.id)])) { // 참가자
					$.post('../mcutest/mcucomm.php', {
							cmd: 'GetConfPartList',
							uid: g_uid[getMcuDid(room.id)]
							}
					)
					.done( 
						function ( data )
						{	
							//alert(data);
							val = eval('(' + data + ')');
							if ( val == null ) 
							{
								alert("error:"+data);
								return;
							}
							
							currMember = val.partlist.length;
							state = "state2";
							stateLabel = "입장";
							
							for ( var i = 0; i < val.partlist.length; i++ ) {
								if (val.partlist[i].devName.indexOf(g_user_id+"@") == 0) {
									state = "state1";
									stateLabel = "참여중";
									break;
								}
							}
							
							if (currMember == room.max_number) {
								state = "state1";
								stateLabel = "대기중";
							}
						}
					);
				}
			}

			var roomStateStr = '<span class="'+state+'" data-room-id="'+room.id+'" data-room-pw="'+((room.pw.length > 0) ? 1 : 0)+'">'+stateLabel+'</span>';
			
			if ( room.is_broadcast == 1 )
			{
				if (!_.isUndefined(g_uid[getMcuDid(room.id)])) {
					roomStateStr += ' <span class="broadcast" data-room-id="'+room.id+'" data-room-uid="'+g_uid[getMcuDid(room.id)]+'">방송보기</span>';
				}
			}
			
			$('#common_room_list').append('<ul>\
				<li class="room_name">'+room.title+' [<b>'+getMcuDid(room.id)+'</b>]</li>\
				<li class="room_time">'+room.start_datetime+' ~ '+room.end_datetime.substr(11, 5)+'</li>\
				<li class="room_reader">'+room.user_name+'</li>\
				<li class="room_personcnt">'+currMember+'/'+room.max_number+'</li>\
				<li class="room_state">'+roomStateStr+'</li>\
			</ul>');
		}); // each
	},
	'json');

	$.ajaxSetup({async:true});
}
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의 등록/정보</li>
			<li class="r2">
			<a href="./reserve.php">회의 등록/정보</a>
			<a href="./realtime.php">실시간 회의 등록</a>
			<a href="./room_list.php" class="sub_select">공개 회의 목록</a>
			<a href="./directcomm.php">번호 연결 서비스</a>
			<span class="path">HOME > 회의 등록/정보> 공개 회의 목록</span></li>
			<li class="r3"><span>공개 회의 목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="common_room_list">
			<ul class="title">
				<li class="room_name">회의 이름 [방번호]</li>
				<li class="room_time">시간</li>
				<li class="room_reader">방장</li>
				<li class="room_personcnt">참여인원</li>
				<li class="room_state">상태/입장</li>
			</ul>
		</div>
		<div id="common_reserve_page">
			<div class="page_group">
				<span class="page_left">◀</span>
				<span class="page_num">1</span><!--span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span-->
				<span class="page_right">▶</span>
			</div>
		</div>
		<div align="right"><input type="button" id="btn_go_realtime" class="btn_small blue" value="실시간 회의 등록">
				<input type="button" id="btn_go_direct" class="btn_small blue" value="번호 연결 서비스">
				<input type="button" id="btn_go_reserve" class="btn_small blue" value="회의 예약">
				</div>
	</section>

<div id="form_pw" style="position:absolute; top:0; left:0; width:100%; height:100%;background-color: lightgray;z-index: 1000;opacity: 0.97;padding-top: 200px; display:none;">
    <div id="wrap_room_pw" style="margin: 0 auto; padding:0px; border:1px solid #000000;background-color: white;width: 300px;">
        <p style="height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white;">입장 비밀번호 입력<span id="close_form_pw" style="display:block; float:right; width:27px; height:27px; cursor:pointer;"><img src="../images/close.png"></span></p>
        <div style="padding:10px;">		
            <input id="input_room_pw" type="password" style="width:90%; padding:10px; color:#828181; margin-top:30px;" onkeydown="if (event.keyCode == 13) document.getElementById('submit_form_pw').click()">
            <div id="common_btn_area" style="padding:10px; width:180px;">
                <input id="submit_form_pw" type="button" value="확인" class="btn_small blue">
                <input id="close_form_pw2" type="button" value="취소" class="btn_small darkgray">	
            </div>
        </div>
    </div>
</div>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
