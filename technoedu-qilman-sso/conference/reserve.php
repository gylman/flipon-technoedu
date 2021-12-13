<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve > ul { width:100%; margin:0px; padding:0px; }
#reserve > ul > li { /*width:48%;*/width:49%; color:#404141; line-height:30px; }

#reserve > ul > li.reserve_list { float:left;  }
#reserve > ul > li.reserve_state { float:right; }

#reserve > ul > li .more { float:right; padding:4px 10px; border:1px solid #cbcbcb; background:#fafafa; border-radius:5px; }
#reserve > ul > li .subject { display:inline-block; margin-bottom:10px; font-size:16px; font-weight:bold; }

/* 회의방 리스트 사이즈 재정의 */
#common_room_list li.room_name { text-overflow:ellipsis; white-space:nowrap; word-wrap:normal; overflow:hidden; }
.common_room_list li.reserve_time { width:20%; text-align: center; }
/*#common_room_list li.room_reader { width:20%; }
#common_room_list li.room_state { width:20%; }*/
.common_room_list li.room_week { width:16%; }
.common_room_list .timeline { width: 100%; height: 200px; overflow: scroll; }

#common_btn_area { position:relative; right:-18%; }
</style>

<script type="text/javascript">
var g_uid = new Array();
var g_selectedRoomID;

localStorage.removeItem("com.facelink.reserve.prev_s_dt");
localStorage.removeItem("com.facelink.reserve.prev_mem_cnt");

$(document).ready(function() {
	$(".more").click(function(){ location.href="./room_list.php"; });
	$("#btn_go_realtime").click(function(){ location.href="./realtime.php"; });
	$("#btn_go_invited").click(function(){ location.href="./invited.php"; });
	$("#btn_go_reserve").click(function(){ location.href="./reserve_step1.php"; });
	
	$('body').on('click', 'span.state2', function() {
		
		if (g_user_id.length <= 0) {
			alert('회의방에 입장하시려면 먼저 로그인해 주세요');
			return false;
		}
		
		if ($(this).data('room-pw') == '1') {
			
			g_selectedRoomID = $(this).data('room-id');
			
			$('html,body').scrollTop(0);
			disableScroll();
			$('#input_room_pw').val('');
			$('#form_pw').show();
		}
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
		$.ajaxSetup({async:false});
        $.post( g_apiUrlRoot+"room_info.php", {rid:g_selectedRoomID}, function(dataJson) {
			if (dataJson.rt_code == 0) {
				if (dataJson.pw == $('#input_room_pw').val()) {
					//var url = '../mypage/meeting_room.php';
					var url = '../mypage/meeting_layout.php';
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
	
	$('.btn_search').click(function(e) {
        if ($('#input_search').val().length <= 0) {
			alert('검색어를 입력해 주세요');
			$('#input_search').focus();
		}
		
		refreshRoomList();
    });
	
	$('#reserve_count').change(function(e) {
        refreshRoomList();
    });
	
	$(document).on('click', '.btn_reserve', function() {
		localStorage.setItem("com.facelink.reserve.prev_s_dt", $(this).data('reserve-datetime'));
		localStorage.setItem("com.facelink.reserve.prev_mem_cnt", $('#reserve_count').val());
		
		location.href = './reserve_step1.php';
	});
	
	refreshRoomList();
	setInterval(function() {
		refreshRoomList();
	}, 30000);
});

function refreshRoomList() {
	// 실시간 회의방 정보
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
	
	var postJsonData = {
		search_val : $('#input_search').val(),
		search_day : "today"	
	};
	$.post( g_apiUrlRoot+"room_list.php", postJsonData, function(dataJson) {
		
		_.each(dataJson.room_list, function(room, idx) {
			
			// 회의방 예약 화면에서는 목록을 3개까지만 보여줌
			if (idx > 4) {
				return;
			}
			
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
							console.log("currMenter:"+currMember);
							
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
			
			$('#common_room_list').append('<ul>\
				<li class="room_name">'+room.title+'</li>\
				<li class="room_time">'+room.start_datetime.substr(11, 5)+' ~ '+room.end_datetime.substr(11, 5)+'</li>\
				<li class="room_reader">'+room.user_name.substring(0,4)+'</li>\
				<li class="room_personcnt">'+currMember+'/'+room.max_number+'</li>\
				<li class="room_state"><span class="'+state+'" data-room-id="'+room.id+'" data-room-pw="'+((room.pw.length > 0) ? 1 : 0)+'">'+stateLabel+'</span></li>\
			</ul>');
		}); // each
	}, 'json');

	$.ajaxSetup({async:true});
	
	// 예약현황 정보
	var postJsonData = {
		date : new Date().format('yyyy-MM-dd'),
		limit : 5
	};
	$.post( g_apiUrlRoot+"reserve_list.php", postJsonData, function(dataJson) {
		if (dataJson.rt_code == 0) {
			$('#reserve_room_list .timeline').empty();
			
			var dtToday = new Date();
			var tToday = dtToday.getTime();
			var dt1DayAfter = new Date((tToday + (86400*1000)));
			var dt2DaysAfter = new Date((tToday + 86400*2*1000));
			var dt3DaysAfter = new Date((tToday + 86400*3*1000));
			var dt4DaysAfter = new Date((tToday + (86400*4*1000)));
			
			var cntUserPerTimeline0 = new Array();
			var cntUserPerTimeline1 = new Array();
			var cntUserPerTimeline2 = new Array();
			var cntUserPerTimeline3 = new Array();
			var cntUserPerTimeline4 = new Array();
			
			$('.title .reserve_time').text(dtToday.format('MM월'));
			
			var maxMem = g_idMCU.length * g_maxMemPerMCU;
			
			_.each(dataJson.room_list, function(room) {
				var dtCurrStart = new Date(room.start_datetime);
				var dtCurrEnd = new Date(room.end_datetime);
				
				if (dtToday.format('dd') == dtCurrStart.format('dd')) {
					while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
						if (cntUserPerTimeline0[dtCurrStart.format('hh:mm')] == null) {
							cntUserPerTimeline0[dtCurrStart.format('hh:mm')] = 0;
						}
						cntUserPerTimeline0[dtCurrStart.format('hh:mm')] += parseInt(room.max_member, 10);
						dtCurrStart = new Date(dtCurrStart.getTime() + 3600000); // 3600000(1시간) = 60초 * 60분 * 1000ms
					}
				} else if (dt1DayAfter.format('dd') == dtCurrStart.format('dd')) {
					while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
						if (cntUserPerTimeline1[dtCurrStart.format('hh:mm')] == null) {
							cntUserPerTimeline1[dtCurrStart.format('hh:mm')] = 0;
						}
						cntUserPerTimeline1[dtCurrStart.format('hh:mm')] += parseInt(room.max_member, 10);
						dtCurrStart = new Date(dtCurrStart.getTime() + 3600000); // 3600000(1시간) = 60초 * 60분 * 1000ms
					}
				} else if (dt2DaysAfter.format('dd') == dtCurrStart.format('dd')) {
					while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
						if (cntUserPerTimeline2[dtCurrStart.format('hh:mm')] == null) {
							cntUserPerTimeline2[dtCurrStart.format('hh:mm')] = 0;
						}
						cntUserPerTimeline2[dtCurrStart.format('hh:mm')] += parseInt(room.max_member, 10);
						dtCurrStart = new Date(dtCurrStart.getTime() + 3600000); // 3600000(1시간) = 60초 * 60분 * 1000ms
					}
				} else if (dt3DaysAfter.format('dd') == dtCurrStart.format('dd')) {
					while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
						if (cntUserPerTimeline3[dtCurrStart.format('hh:mm')] == null) {
							cntUserPerTimeline3[dtCurrStart.format('hh:mm')] = 0;
						}
						cntUserPerTimeline3[dtCurrStart.format('hh:mm')] += parseInt(room.max_member, 10);
						dtCurrStart = new Date(dtCurrStart.getTime() + 3600000); // 3600000(1시간) = 60초 * 60분 * 1000ms
					}
				} else if (dt4DaysAfter.format('dd') == dtCurrStart.format('dd')) {
					while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
						if (cntUserPerTimeline4[dtCurrStart.format('hh:mm')] == null) {
							cntUserPerTimeline4[dtCurrStart.format('hh:mm')] = 0;
						}
						cntUserPerTimeline4[dtCurrStart.format('hh:mm')] += parseInt(room.max_member, 10);
						dtCurrStart = new Date(dtCurrStart.getTime() + 3600000); // 3600000(1시간) = 60초 * 60분 * 1000ms
					}
				}
			});
			
			var now = new Date();
			var hour = 0;
			var minute = 0;
			var preReserveCount = $('#reserve_count').val();
			for (var j = 0; j < 24; j++) {
				
				var formHourMinute = formatNumberLength(hour, 2)+':'+formatNumberLength(minute, 2);
				
				dtToday = new Date(dtToday.format('yyyy-MM-dd')+' '+formHourMinute);
				dt1DayAfter = new Date(dt1DayAfter.format('yyyy-MM-dd')+' '+formHourMinute);
				dt2DaysAfter = new Date(dt2DaysAfter.format('yyyy-MM-dd')+' '+formHourMinute);
				dt3DaysAfter = new Date(dt3DaysAfter.format('yyyy-MM-dd')+' '+formHourMinute);
				dt4DaysAfter = new Date(dt4DaysAfter.format('yyyy-MM-dd')+' '+formHourMinute);
				
				var dataDatetime0 = dtToday.format('yyyy-MM-dd hh:mm');
				var dataDatetime1 = dt1DayAfter.format('yyyy-MM-dd hh:mm');
				var dataDatetime2 = dt2DaysAfter.format('yyyy-MM-dd hh:mm');
				var dataDatetime3 = dt3DaysAfter.format('yyyy-MM-dd hh:mm');
				var dataDatetime4 = dt4DaysAfter.format('yyyy-MM-dd hh:mm');
				
				if (hour == 0) { // 최초 한번만 설정함
					$('#day_title_0').text(dtToday.getDate()+"일");
					$('#day_title_1').text(dt1DayAfter.getDate()+"일");
					$('#day_title_2').text(dt2DaysAfter.getDate()+"일");
					$('#day_title_3').text(dt3DaysAfter.getDate()+"일");
					$('#day_title_4').text(dt4DaysAfter.getDate()+"일");
				}
				
				var btnSel0 = '완료';
				var btnSel1 = '완료';
				var btnSel2 = '완료';
				var btnSel3 = '완료';
				var btnSel4 = '완료';
				
				if (cntUserPerTimeline0[formHourMinute] != null) {
					if ((maxMem - cntUserPerTimeline0[formHourMinute]) >= preReserveCount) {
						btnSel0 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime0+'">+</a>';
					} else {
						btnSel0 = '완료';
					}
				} else {
					btnSel0 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime0+'">+</a>';
				}
				
				if (cntUserPerTimeline1[formHourMinute] != null) {
					if ((maxMem - cntUserPerTimeline1[formHourMinute]) >= preReserveCount) {
						btnSel1 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime1+'">+</a>';
					} else {
						btnSel1 = '완료';
					}
				} else {
					btnSel1 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime1+'">+</a>';
				}
				
				if (cntUserPerTimeline2[formHourMinute] != null) {
					if ((maxMem - cntUserPerTimeline2[formHourMinute]) >= preReserveCount) {
						btnSel2 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime2+'">+</a>';
					} else {
						btnSel2 = '완료';
					}
				} else {
					btnSel2 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime2+'">+</a>';
				}
				
				if (cntUserPerTimeline3[formHourMinute] != null) {
					if ((maxMem - cntUserPerTimeline3[formHourMinute]) >= preReserveCount) {
						btnSel3 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime3+'">+</a>';
					} else {
						btnSel3 = '완료';
					}
				} else {
					btnSel3 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime3+'">+</a>';
				}
				
				if (cntUserPerTimeline4[formHourMinute] != null) {
					if ((maxMem - cntUserPerTimeline4[formHourMinute]) >= preReserveCount) {
						btnSel4 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime4+'">+</a>';
					} else {
						btnSel4 = '완료';
					}
				} else {
					btnSel4 = '<a class="btn_reserve" href="#" data-reserve-datetime="'+dataDatetime4+'">+</a>';
				}
				
				// 일요일 제외
				/*
				if (dtToday.format('e') == "일" || dtToday.getTime() < now.getTime()) {
					btnSel0 = "--";
					dataDatetime0 = "";
				}
				if (dt1DayAfter.format('e') == "일" || dt1DayAfter.getTime() < now.getTime()) {
					btnSel1 = "--";
					dataDatetime1 = "";
				}
				if (dt2DaysAfter.format('e') == "일" || dt2DaysAfter.getTime() < now.getTime()) {
					btnSel2 = "--";
					dataDatetime2 = "";
				}
				if (dt3DaysAfter.format('e') == "일" || dt3DaysAfter.getTime() < now.getTime()) {
					btnSel3 = "--";
					dataDatetime3 = "";
				}
				if (dt4DaysAfter.format('e') == "일" || dt4DaysAfter.getTime() < now.getTime()) {
					btnSel4 = "--";
					dataDatetime4 = "";
				}*/
				
				// 지난 시간 제외
				if (dtToday.getTime() < now.getTime()) {
					btnSel0 = "--";
					dataDatetime0 = "";
				}
				if (dt1DayAfter.getTime() < now.getTime()) {
					btnSel1 = "--";
					dataDatetime1 = "";
				}
				if (dt2DaysAfter.getTime() < now.getTime()) {
					btnSel2 = "--";
					dataDatetime2 = "";
				}
				if (dt3DaysAfter.getTime() < now.getTime()) {
					btnSel3 = "--";
					dataDatetime3 = "";
				}
				if (dt4DaysAfter.getTime() < now.getTime()) {
					btnSel4 = "--";
					dataDatetime4 = "";
				}
				
				$('#reserve_room_list > .timeline').append('<ul>\
									<li class="reserve_time">'+formHourMinute+'</li>\
									<li class="room_week today" data-datetime="'+dataDatetime0+'">'+btnSel0+'</li>\
									<li class="room_week" data-datetime="'+dataDatetime1+'">'+btnSel1+'</li>\
									<li class="room_week" data-datetime="'+dataDatetime2+'">'+btnSel2+'</li>\
									<li class="room_week" data-datetime="'+dataDatetime3+'">'+btnSel3+'</li>\
									<li class="room_week" data-datetime="'+dataDatetime4+'">'+btnSel4+'</li>\
								</ul>');
				
				hour++;
			}
		} else {
			alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
		}
	}, 'json');
}
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의 등록/정보</li>
			<li class="r2">
			<a href="./reserve.php" class="sub_select">회의 등록/정보</a>
			<a href="./realtime.php">실시간 회의 등록</a>
			<!--a href="./invited.php">1:1회의초청</a-->
			<a href="./room_list.php">공개 회의 목록</a>
			<span class="path">HOME > 회의 등록/정보 > 회의등록/정보</span></li>
			<li class="r3"><span>회의 예약/등록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<ul>
				<li class="reserve_list">
					<span class="subject">공개 회의 목록(금일)</span>
					<input type="button" value="+ 더보기" class="more">
					<div id="common_room_list" class="common_room_list">
						<ul class="title">
                            <li class="room_name">회의 이름</li>
                            <li class="room_time">시간</li>
                            <li class="room_reader">방장</li>
                            <li class="room_personcnt">참여인원</li>
                            <li class="room_state">상태/입장</li>
                        </ul>
					</div>
					<div id="common_reserve_search">
                    	<input id="input_search" type="text" class="input_search"><input type="button" class="btn_search">
                    </div>
				</li>
				<li class="reserve_state">
					<span class="subject">예약현황(예약기준 인원 : 
					<select id="reserve_count">
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4" selected>4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
					</select> 명
					)</span>
					<div id="reserve_room_list" class="common_room_list">
						<ul class="title">
							<li class="reserve_time">시간</li>
							<li class="room_week" id="day_title_0">월</li>
							<li class="room_week" id="day_title_1">화</li>
							<li class="room_week" id="day_title_2">수</li>
							<li class="room_week" id="day_title_3">목</li>
							<li class="room_week" id="day_title_4">금</li>
						</ul>
                        <div class="timeline">
                            <!--ul>
                                <li class="reserve_time">09:00</li>
                                <li class="room_week">완료</li>
                                <li class="room_week">12</li>
                                <li class="room_week">12</li>
                                <li class="room_week">12</li>
                                <li class="room_week">12</li>
                            </ul-->
                        </div>
					</div>
					<div id="common_btn_area">
						<input type="button" id="btn_go_realtime" class="btn_small blue" value="실시간 회의 등록">
						<input type="button" id="btn_go_reserve" class="btn_small blue" value="회의 예약">
					</div>
				</li>
			</ul>
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
