<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve > ul { width:100%; margin:0px; padding:0px; }
#reserve > ul > li { padding:10px 0px; color:#404141; line-height:30px; }
#reserve > ul > li > span { display:inline-block; width:150px; font-size:1.1em; font-weight:bold; vertical-align:top; }
#reserve > ul > li select { width:150px; height:30px; padding-left:5px; border:1px solid #d3d3d3; }
#reserve > ul > li #datepicker { width:200px; height:30px; padding:0px 5px; border:1px solid #d3d3d3;  background:url("../images/calendar.png") 97% 50% no-repeat; }
#reserve > ul .subject { display:inline-block; margin:20px 0 10px 0px; font-size:16px; font-weight:bold; }
#reserve > ul p.rev_time { width:100%; height:30px; margin:10px; }
#reserve > ul p.rev_time > select { height:30px; padding-left:10px; margin:0px 5px; }

div.reserve_list { width:100%; height:120px; border:1px solid #cccccc; border-radius:10px; padding:20px; margin-bottom:30px; overflow:auto; overflow-y:hidden;}
div.reserve_list > ul { min-width:2800px; }
div.reserve_list > ul > li { float:left; border:1px solid #cccccc; }
div.reserve_list > ul > li > p { width:100%; height:30px; line-height:30px; text-align:center; }
div.reserve_list > ul > li > a { display:block; float:left; height:30px; line-height:30px; padding:0px 5px; border-top:1px solid #cccccc; border-right:1px solid #cccccc; cursor:pointer; }
div.reserve_list > ul > li > a:last-child {border-right:0px;}

div.reserve_list > ul > li > a.state1 { color:#bbbbbb; border:1px solid #cccccc; } /* 예약된 상태 */
div.reserve_list > ul > li > a.state2 { background:#2577b8; color:#ffffff; } /* 선택 */

#common_btn_area { width:178px; }
</style>

<!-- 달력 -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script type="text/javascript">
checkLogin(true, true);

var g_dtToday = new Date();

$(document).ready(function() {
	if ( g_user_level <= 1 )
	{
		alert("회의 개설 권한이 있지 않습니다.\n관리자에게 연락하세요");
        	history.back(-1);
		return false;
	}
	/* 달력 */
	$("#datepicker").datepicker({
		onSelect: function(date) {
			g_dtToday = new Date(date);
			initTimeline();
    	},
		minDate: new Date()
	});
	$("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#datepicker").datepicker("setDate", g_dtToday.format("yyyy-MM-dd"));

	/* 시간선택 */
	var select_time = $("div.reserve_list > ul > li > a");
	select_time.click(function(){ $(this).toggleClass("state2"); });
	
	$('#mem_cnt').change(function(e) {
        initTimeline();
		alert('사용자 수가 바뀌어 시간이 초기화되었습니다\n회의 시간을 다시 선택해주세요');
    });
	
	/* 다음단계 */
	$("#next_step").click(function() {
		if (g_is_guest == true) {
			alert('Guest는 회의방을 생성할 수 없습니다');
			return false;
		}
		
		if ($('#mem_cnt').val() == null || $('#mem_cnt').val() == '') {
			alert('회의인원을 선택해 주세요');
			return;
		}
		
		var selTimelineCount = $('.room_week[data-sel="true"]').length;
		
		if (selTimelineCount <= 0) {
			alert('회의 시간을 선택해 주세요');
			return;
		}
		
		var firstElement = $('.room_week[data-sel="true"]').first();
		var lastElement = $('.room_week[data-sel="true"]').last();
		
		localStorage.setItem("com.facelink.reserve.mem_cnt", $('#mem_cnt').val());
		localStorage.setItem("com.facelink.reserve.s_dt", firstElement.data('datetime'));
		localStorage.setItem("com.facelink.reserve.e_dt", lastElement.data('datetime'));
		
		location.href="./reserve_step2.php";
	});

	function getNextRoomWeekInfo( obj )
	{
		if (obj.text() == "23:30") {
			if (obj.parent('li').next('li').length > 0) {
				return obj.parent('li').next('li').children('a').first();
			}
		}

		return obj.next();
	}

	function getPrevRoomWeekInfo( obj )
	{
		if (obj.text() == "00:00") {
			if (obj.parent('li').prev('li').length > 0) {
				return obj.parent('li').prev('li').children('a').last();
			}
		}

		return obj.prev();
	}
	
	$('body').on('click', '.room_week', function(e) {
		
		if ($(this).data('datetime') == '') { // 에약이 완료된 슬롯
			return false;
		}
		
		if ($(this).attr('data-sel') != 'true') {
			if ($('.room_week[data-sel="true"]').length >= 4) {
				alert('회의방은 2시간 이상 예약할 수 없습니다');
				return false;
			}
			
			var selInvalid = false;
		
			if ($('.room_week[data-sel="true"]').length > 0) {

				var prev = getPrevRoomWeekInfo($(this)).attr('data-sel');
				var next = getNextRoomWeekInfo($(this)).attr('data-sel');

				if ( (prev == 'false' && next == 'false') || 
					 (prev == undefined && next == 'false') || 
					 (prev == 'false' && next == undefined ) ) {
						selInvalid = true;
				}
			}
			
			if (selInvalid) {
				alert('시간은 연속적으로 선택할 수 있습니다');
				return false;
			}
			
			$(this).attr('data-sel', 'true');
			$(this).css('background-color', '#FF7F00');
		} else {
			$(this).css('background-color', '#FFFFFF');
			$(this).nextAll('a').css('background-color', '#FFFFFF');
			$(this).attr('data-sel', 'false');
			$(this).nextAll('a').attr('data-sel', 'false');
			
			if ($(this).parent('li').next('li').length > 0) {
				$(this).parent('li').next('li').children('a').css('background-color', '#FFFFFF');
				$(this).parent('li').next('li').children('a').nextAll('a').css('background-color', '#FFFFFF');
				$(this).parent('li').next('li').children('a').attr('data-sel', 'false');
				$(this).parent('li').next('li').children('a').nextAll('a').attr('data-sel', 'false');
			}
		}
		
		if ($('.room_week[data-sel="true"]').length > 0) {
			var dtStart = new Date($('.room_week[data-sel="true"]').first().data('datetime'));
			var dtEnd = new Date($('.room_week[data-sel="true"]').last().data('datetime'));
			dtEnd = new Date(dtEnd.getTime() + 1800000); // 30분 후에 종료되기 때문에
			var strDuration = '30분';
			
			switch($('.room_week[data-sel="true"]').length) {
				case 1:
					strDuration = '30분';
					break;
				case 2:
					strDuration = '1시간';
					break;
				case 3:
					strDuration = '1시간 30분';
					break;
				case 4:
					strDuration = '2시간';
					break;
			}
			$('.rev_time').html('예약시간 : <b>'+dtStart.format('yyyy년 MM월 dd일 hh시 mm분')+'</b>부터 <b>'+dtEnd.format('yyyy년 MM월 dd일 hh시 mm분')+'</b>까지 ('+strDuration+')');
		} else {
			$('.rev_time').html('예약시간 : ');
		}
	});
	
	localStorage.removeItem("com.facelink.reserve.mem_cnt", '');
	localStorage.removeItem("com.facelink.reserve.s_dt", '');
	localStorage.removeItem("com.facelink.reserve.e_dt", '');
	
	// prev setting data(reserve.php) init
	g_prevStartDatetime = localStorage.getItem("com.facelink.reserve.prev_s_dt");
	g_prevMemberCount = localStorage.getItem("com.facelink.reserve.prev_mem_cnt");
	
	if (!_.isUndefined(g_prevStartDatetime) && !_.isNaN(g_prevStartDatetime) && !_.isNull(g_prevStartDatetime)) {
		g_dtToday = new Date(g_prevStartDatetime);
		
		$("#datepicker").datepicker("setDate", g_dtToday.format("yyyy-MM-dd"));
		$('#mem_cnt').val(g_prevMemberCount);
	}
	
	initTimeline();
});

function initTimeline() {
	
	// init day
	$('.reserve_list ul li').remove();
	
	var liTimeline = '';
	var dtNow = new Date();
	var tToday = g_dtToday.getTime();
	
	// 예약현황 정보
	var postJsonData = {
		date : g_dtToday.format('yyyy-MM-dd'),
		limit : 2
	};
	$.post( g_apiUrlRoot+"reserve_list.php", postJsonData, function(dataJson) {
		if (dataJson.rt_code == 0) {
			var cntUserPerTimeline = new Array();
			var maxMem = g_idMCU.length * g_maxMemPerMCU;
			var cntMem = $('#mem_cnt').val();
			
			_.each(dataJson.room_list, function(room) {
				var dtCurrStart = new Date(room.start_datetime);
				var dtCurrEnd = new Date(room.end_datetime);
				
				while(dtCurrStart.getTime() <= dtCurrEnd.getTime()) {
					if (cntUserPerTimeline[dtCurrStart.format('yyyy-MM-dd hh:mm')] == null) {
						cntUserPerTimeline[dtCurrStart.format('yyyy-MM-dd hh:mm')] = 0;
					}
					cntUserPerTimeline[dtCurrStart.format('yyyy-MM-dd hh:mm')] += parseInt(room.max_member, 10);
					dtCurrStart = new Date(dtCurrStart.getTime() + 1800000); // 1800000(30분) = 60초 * 30분 * 1000ms
				}
			});
			
			for (var i = 0; i < 2; i++) {
		
				var dateCurr = new Date((tToday + (86400*1000) * i));
				
				liTimeline += '<li><p>'+dateCurr.format('dd일')+'</p>';
				
				var hour = 0;
				var minute = 0;
				for (var j = 0; j < 48; j++) {
					
					if (i == 1 && j == 8) {
						break;
					}
					
					var formHourMinute = formatNumberLength(hour, 2)+':'+formatNumberLength(minute, 2);
					var datetimeCurr = new Date(dateCurr.format('yyyy-MM-dd')+' '+formatNumberLength(hour, 2)+':'+formatNumberLength(minute, 2));
					
					if (datetimeCurr.getTime() < dtNow.getTime()) {
						liTimeline += '<a class="room_week" data-datetime="" data-sel="false" href="#">&nbsp;&nbsp;&nbsp;-:-&nbsp;&nbsp;&nbsp;</a>';
					} else {
						if (cntUserPerTimeline[datetimeCurr.format('yyyy-MM-dd hh:mm')] != null) {
							if ((maxMem - cntUserPerTimeline[datetimeCurr.format('yyyy-MM-dd hh:mm')]) >= cntMem) {
								liTimeline += '<a class="room_week" data-datetime="'+datetimeCurr.format('yyyy-MM-dd hh:mm')+'" data-sel="false">'+formHourMinute+'</a>';
							} else {
								liTimeline += '<a class="room_week" data-datetime="" data-sel="false" href="#">&nbsp;&nbsp;완료&nbsp;&nbsp;</a>';
							}
						} else {
							liTimeline += '<a class="room_week" data-datetime="'+datetimeCurr.format('yyyy-MM-dd hh:mm')+'" data-sel="false">'+formHourMinute+'</a>';
						}
					}
					
					if (minute == 0) {
						minute += 30;
					} else {
						hour++;
						minute = 0;
					}
				}
				
				liTimeline += '</li>';
			}
			
			$('.rev_time').html('예약시간 : ');
			$('.reserve_list ul').append(liTimeline);
			
			if (!_.isUndefined(g_prevStartDatetime) && !_.isNaN(g_prevStartDatetime) && !_.isNull(g_prevStartDatetime)) {
				var dtTmp = new Date(g_prevStartDatetime);
				$('.room_week[data-datetime="'+dtTmp.format('yyyy-MM-dd hh:mm')+'"]').click();

				// 자동 스크롤을 한다.(선택된곳까지)
				sliceNum = dtTmp.getHours()*2;
				if ( sliceNum > 11 ) {
					 document.getElementById('reserve_list').scrollLeft += 20+47*(sliceNum-11);
				}
			}
			else {
				// 선택되어 있지 않고 오늘인 경우에는 현재 시간 만큼 스크롤
				if ( g_dtToday.getFullYear() == dtNow.getFullYear() && g_dtToday.getMonth() == dtNow.getMonth() && g_dtToday.getDate() == dtNow.getDate() ) {
					// 자동 스크롤을 한다.(선택된곳까지)
					sliceNum = dtNow.getHours()*2;
					if ( sliceNum > 11 ) {
						 document.getElementById('reserve_list').scrollLeft += 20+47*(sliceNum-8);
					}
				}
			}
		}
	});
}
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의 등록/예약</li>
			<li class="r2"><a href="./reserve.php" class="sub_select">회의 등록/예약</a><a href="./realtime.php">실시간 회의 등록</a><a href="./room_list.php">공개 회의 목록</a><span class="path">HOME > 회의등록/예약 > 회의 예약</span></li>
			<li class="r3"><span>회의 예약</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<ul>
				<li><span>수업 인원 선택</span>
					<select id="mem_cnt">
						<option selected value="">인원선택</option>
						<option value="1">1명</option>
						<option value="2">2명</option>
						<option value="3">3명</option>
						<option value="4">4명</option>
                        <option value="5">5명</option>
                        <option value="6">6명</option>
                        <option value="7">7명</option>
                        <option value="8">8명</option>
                        <option value="9">9명</option>
                        <option value="10">10명</option>
                        <option value="11">11명</option>
                        <option value="12">12명</option>
                        <option value="13">13명</option>
                        <option value="14">14명</option>
                        <option value="15">15명</option>
                        <option value="16">16명</option>
					</select>
				</li>
				<li>
					<span>회의 일자</span>
					<input type="text" id="datepicker">
				</li>
				<span class="subject">시간선택</span>
				<p class="rev_time">예약시간 : </p>
				<div class="reserve_list" id="reserve_list">
					<ul>
					</ul>
				</div>				
			</ul>
			<div id="common_btn_area">
				<input type="button" id="next_step" class="btn_big blue" value="다음단계">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
