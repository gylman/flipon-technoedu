<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
/* My FaceLink - 나의 회의 부분 */
#mypage .col1 { width:25%; text-align:center; }
#mypage .col2 { width:40%; text-align:left; padding-left:20px; }
#mypage .col3 { width:15%; text-align:center; }
#mypage .col4 { width:20%; text-align:center; }

#ext_room_list { display:inline-block; width:100%; }
#ext_room_list > ul { clear:both; width:100%; height:40px; margin:0px; padding:0px; }
#ext_room_list > ul.title { border-top:1px solid #848586; border-bottom:1px solid #848586; }
#ext_room_list > ul.title > li { font-weight:bold; text-align:center; }
#ext_room_list > ul:nth-child(even) { background:#efeeee; }
#ext_room_list li { display:inline-block; float:left; height:40px; line-height:40px; border-bottom:1px solid #dddcdc; box-sizing:border-box; }

/* 내사이트, 타사이트 탭 설정******************************************************/
#tab { width:100%; overflow:hidden; box-sizing:border-box; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	/*height:330px;*/
	padding:10px 0px;
	box-sizing:border-box;
}

#tab1:checked~#sub1,
#tab2:checked~#sub2,
#tab3:checked~#sub3 { display:block; }

#tab1:checked~#lab1,
#tab2:checked~#lab2,
#tab3:checked~#lab3 {
	background: #ffffff; 

	border-left:3px solid #848586; 
	border-top:3px solid #848586; 
	border-right:3px solid #848586; 
	border-bottom:3px solid #ffffff;
}

#tab label { 
	display:block; 
	float:left; 
	width:50%; 
	height:40px; 
	line-height:40px; 
	font-weight:bold;
	text-align:center;
	cursor:pointer; 
	background:#fafafa;	

	border-top:1px solid #c4c4c4;
	border-left:1px solid #c4c4c4;
	border-right:1px solid #c4c4c4;
	border-bottom:3px solid #848586;

	border-radius:20px 20px 0px 0px;
	box-sizing:border-box;
}
</style>

<script type="text/javascript">
checkLogin(true, true);

var g_alreadyOpenRoomIDs = [];

$(document).on('click', 'input[type="button"][value="참여하기"]', function() {
	//location.href="./meeting_content.php";
	var room_id = $(this).parents('ul').data('room-id');
	var has_pw = $(this).parents('ul').data('has-pw');
	
	// 이미 생성된 방이 있을 경우
	if (has_pw == 0) {
		submitMettingRoom(room_id);
	} else {
		$.post( g_apiUrlRoot+"room_info.php", {rid:room_id}, function(dataJsonRoomInfo) {
			
			var isJoiner = false;
			
			if (dataJsonRoomInfo.user_id == g_user_id) {
				isJoiner = true;
			} else {
				for (var i = 0; i < dataJsonRoomInfo.member.length; i++) {
					if (dataJsonRoomInfo.member[i].user_id == g_user_id) {
						isJoiner = true;
						break;
					}
				}
			}
			
			if (!isJoiner) {
				$('#submit_form_pw').data('room-id', room_id);
				$('#form_pw').show();
			} else {
				$('#submit_form_pw').data('room-id', room_id);
				$('#input_room_pw').val(dataJsonRoomInfo.pw);
				submitMettingRoom($('#submit_form_pw').data('room-id'));
			}
		});
	}
});

$(document).on('click', 'input[type="button"][value="방 삭제"]', function() {
	if ( !confirm("회의중에 회의방을 삭제하게 되면 \n회의가 종료됩니다. \n정말로 삭제하시겠습니까?") != 0 ) return;
	
	var room_id = $(this).parents('ul').data('room-id');
	var did = getMcuDid(room_id);
	$.post('../mcutest/mcucomm.php', {cmd: 'RemoveConferenceByDID', did:did} );
	$.post( g_apiUrlRoot+"room_remove.php", {room_id:room_id} , function() {
		initReserveList();
	});
});

$(document).on('click', 'input[type="button"][value="방 생성"]', function() {
	var room_id = $(this).parents('ul').data('room-id');
	var has_pw = $(this).parents('ul').data('has-pw');
	var btnSel = $(this);
	
	for (var i = 0; i < g_alreadyOpenRoomIDs.length; i++) {
		if (g_alreadyOpenRoomIDs[i] == room_id) {
			alert('회의방이 이미 생성되었습니다');
			return false;
		}
	}
	
	$.post( g_apiUrlRoot+"room_info.php", {rid:dataJson.room_id}, function(dataJsonRoomInfo) {
		if (dataJsonRoomInfo.rt_code == 0) {
			
			$.post('../mcutest/mcucomm.php', {cmd: 'GetConfList'} )
			.done( 
				function ( data ) {
					val = eval('(' + data + ')');
					if ( val == null ) {
						alert("error:"+data);
						return;
					}
					
					var did = getMcuDid(dataJsonRoomInfo.id);
					for ( var i = 0; i < val.conflist.length; i++ ) {
						if (val.conflist[i].did == did) {
							alert('회의방이 이미 생성되었습니다');
							return false;
						}
					}
					
					var dtClose = new Date(dataJsonRoomInfo.end_datetime);
					
					$.post('../mcutest/mcucomm.php', {
						cmd: 'CreateConference',
						name: dataJsonRoomInfo.id,
						did: getMcuDid(dataJsonRoomInfo.id),
						mixerId: 'mixer',
						profileId: 'HD',
						compType: dataJsonRoomInfo.layout_type,
						vad: 0,
						size: dataJsonRoomInfo.resolution, // XGA
						closeTimerUse: true,
						closeTime: dtClose.format('yyyy-MM-dd hh:mm:ss'),
						recordUse: (dataJsonRoomInfo.record == '1') ? true : false,
						autoCloseUse: false
						} 
					).done ( function ( data ) {
						val = eval('(' + data + ')');
						if ( val == null ) {
							alert("error:"+data);
							return;
						}
						$.post( g_apiUrlRoot+"room_set_record_url.php", {rid:g_rid, record_url:val.recordUrl}, function(dataJson) {});
						alert('회의방이 생성되었습니다');
					});
				}
			);
		} else {
			alert('죄송합니다\n회의방 정보를 찾을 수 없습니다');
		}
	}, 'json');
});

$(document).on('click', 'input[type="button"][value="방 제어"]', function() {
	var room_id = $(this).parents('ul').data('room-id');
	
	var isRoomAlreadyOpen = false;
	for (var i = 0; i < g_alreadyOpenRoomIDs.length; i++) {
		if (g_alreadyOpenRoomIDs[i] == room_id) {
			isRoomAlreadyOpen = true;
		}
	}
	
	submitMettingRoom(room_id, 1);
});

$(document).ready(function() {
	
	$('#submit_form_pw').click(function(e) {
        if ($('#input_room_pw').val().length <= 0) {
			alert('비밀번호를 입력해주세요');
			return false;
		}
		
		submitMettingRoom($('#submit_form_pw').data('room-id'));
    });
	
	$('#close_form_pw2').click(function(e) {
		$('#input_room_pw').val('');
        $('#form_pw').hide();
    });
	
	initReserveList();
	initExtRoomList();

	setInterval(function() { initReserveList(); }, 30000);
	setInterval(function() { initExtRoomList(); }, 30000);
});

Date.createFromMysql = function(mysql_string)
{ 
   if(typeof mysql_string === 'string')
   {
      var t = mysql_string.split(/[- :]/);

      //when t[3], t[4] and t[5] are missing they defaults to zero
      return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
   }

   return null;   
}

function initReserveList() {
	$.post( g_apiUrlRoot+"reserve_user_list.php", {user_id:g_user_id}, function(dataJson) {
		if (dataJson.rt_code == 0) {
			$('#common_room_list ul').not('.title').remove();
			$('#facelink_list_cnt').html(dataJson.room_list.length);
			
			_.each(dataJson.room_list, function(room) {
				var dtStart = Date.createFromMysql(room.start_datetime);
				var dtEnd = Date.createFromMysql(room.end_datetime);
				
				var btnJoin = '대기중';
				var bHasPW = (room.pw.length > 0) ? 1 : 0;
				
				if (room.is_open == '1') {
					g_alreadyOpenRoomIDs.push(room.id);
				}
				
				if ( room.is_opentime == "1" ) {
					btnJoin = '<input type="button" class="btn_small blue" value="참여하기">';
				}
				
				// 방장일 경우
				var roomControl = '';
				if (room.user_id == g_user_id) {
					if ( room.is_opentime == "1" ) {
						roomControl = '<input type="button" class="btn_small lightgray" value="방 제어">';
					}
					roomControl +='<input type="button" class="btn_small lightgray" value="방 삭제">';
				}
				
				$('#common_room_list').append('<ul data-room-id="'+room.id+'" data-has-pw="'+bHasPW+'">\
					<li class="col1">'+dtStart.format('yyyy년 MM월 dd일')+'&nbsp;&nbsp;'+dtStart.format('hh:mm')+'~'+dtEnd.format('hh:mm')+'</li>\
					<li class="col2">'+room.title+'</li>\
					<li class="col3">'+btnJoin+'</li>\
					<li class="col4">'+roomControl+'</li>\
				</ul>');
			});
		}
	},
	'json');
}

var ext_room_list = null;

function initExtRoomList() {
	$.post( g_apiUrlRoot+"ext_room_list.php", {user_id:g_user_id}, function(dataJson) {
		$('#ext_room_list ul').not('.title').remove();
		if (dataJson.rt_code == 0) {
			//console.log(dataJson);
			ext_room_list = dataJson.room_list;
			$('#extsite_list_cnt').html(dataJson.room_list.length);
			
			for ( var i = 0; i<ext_room_list.length; i++ )
			{
				var dtCall = Date.createFromMysql(ext_room_list[i].datetime);
				call_info = eval("("+ext_room_list[i].call_info+")");
				
				$('#ext_room_list').append('<ul data-room-id="'+ext_room_list[i].id+'">' +
					'<li class="col1">'+call_info.caller.name+'('+dtCall.format('yyyy년 MM월 dd일')+'&nbsp;&nbsp;'+dtCall.format('hh시mm분')+')</li>' +
					'<li class="col2">'+call_info.conf_title+'</li>'+
					'<li class="col3">'+call_info.service_id+'</li>'+
					'<li class="col4"><input type="submit" class="btn_small blue" value="참가하기" onclick="extRoomEnter('+i+')"><input type="submit" class="btn_small lightgray" value="삭제" onclick="extRoomRemove('+i+')"></li>'+
				'</ul>');
			}
		}
		else {
			$('#extsite_list_cnt').html('0');
		}
	},
	'json');
}

function extRoomEnter(idx)
{
	if ( ext_room_list == null ) return;

	call_info = eval("("+ext_room_list[idx].call_info+")");

	var url = '../mypage/meeting_intercomm.php';
	var form = $('<form action="' + url + '" method="post">' +
				'<input type="hidden" name="extrid" value="' + ext_room_list[idx].id+ '" />' +
				'<input type="text" name="title" value="' + call_info.conf_title + '" />' +
				'<input type="text" name="caller_name" value="' + call_info.caller.name + '" />' +
				'<input type="text" name="caller_email" value="' + call_info.caller.email + '" />' +
				'<input type="text" name="service_id" value="' + call_info.service_id + '" />' +
				'<input type="text" name="sip_to_uri" value="' + call_info.sip_to_uri+ '" />' +
				'<input type="text" name="sip_from_uri" value="' + call_info.sip_from_uri+ '" />' +
				'</form>');
	$('body').append(form);
	form.submit();
}

function extRoomRemove(idx)
{
	if ( ext_room_list == null ) { 
		initExtRoomList();
		return;
	}
	$.post( g_apiUrlRoot+"ext_room_remove.php", {room_id:ext_room_list[idx].id}, function(dataJson) {
		initExtRoomList();
	});
}

function submitMettingRoom(room_id, room_control)
{
	if (typeof room_control == "undefined") {
		room_control = 0;
	}
	
	//var url = '../mypage/meeting_room.php';
	var url = '../mypage/meeting_layout.php';
	var form = $('<form action="' + url + '" method="post">' +
				'<input type="text" name="rid" value="' + room_id + '" />' +
				'<input type="text" name="rpw" value="' + $('#input_room_pw').val() + '" />' +
				'<input type="hidden" name="control" value="' + room_control + '" />' +
				'</form>');
	$('body').append(form);
	form.submit();
	
	$('#input_room_pw').val('');
}
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording_list.php">지난회의목록</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="../join/join_edit.php">회원정보</a><a href="./device_test.php">장치설정</a><span class="path">HOME > My i-Mentor> 나의 회의</span></li>
			<li class="r3"><span>나의 회의 목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<section id="sub1">
				<div id="common_room_list">
					<ul class="title">
						<li class="col1">일자</li>
						<li class="col2">회의명</li>					
						<li class="col3">회의 참여</li>
						<li class="col4">회의 방 제어</li>
					</ul>
				</div>			
			</section>
		</div>
	</section>

<div id="form_pw" style="position:absolute; top:0; left:0; width:100%; height:100%;background-color: lightgray;z-index: 1000;opacity: 0.97;padding-top: 200px; display:none;">
    <div id="wrap_room_pw" style="margin: 0 auto; padding:0px; border:1px solid #000000;background-color: white;width: 300px;">
        <p style="height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white;">입장 비밀번호 입력<span id="close_form_pw" style="display:block; float:right; width:27px; height:27px; cursor:pointer;"><img src="../images/close.png"></span></p>
        <div style="padding:10px;">		
            <input id="input_room_pw" type="password" style="width:90%; padding:10px; color:#828181; margin-top:30px;">
            <div id="common_btn_area" style="padding:10px; width:180px;">
                <input id="submit_form_pw" type="button" value="확인" class="btn_small blue">
                <input id="close_form_pw2" type="button" value="취소" class="btn_small darkgray">	
            </div>
        </div>
    </div>
</div>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
