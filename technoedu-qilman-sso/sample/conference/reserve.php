<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve > ul { width:100%; margin:0px; padding:0px; }
#reserve > ul > li { width:48%; color:#404141; line-height:30px; }

#reserve > ul > li.reserve_list { float:left;  }
#reserve > ul > li.reserve_state { float:right; }

#reserve > ul > li .more { float:right; padding:4px 10px; border:1px solid #cbcbcb; background:#fafafa; border-radius:5px; cursor:pointer; }
#reserve > ul > li .subject { display:inline-block; margin-bottom:10px; font-size:16px; font-weight:bold; }

/* 회의방 리스트 사이즈 재정의 */
#common_room_list li.room_name { width:40%; }
#common_room_list li.room_time { width:20%; }
#common_room_list li.room_reader { width:20%; }
#common_room_list li.room_state { width:20%; }
#common_room_list li.room_week { width:13.33%; }

#common_btn_area { width:430px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$(".more").click(function(){ location.href="./room_list.php"; });
	$("#btn_realtime").click(function(){ location.href="./realtime.php"; });
	$("#btn_invited").click(function(){ location.href="./invited.php"; });
	$("#btn_reserve").click(function(){ location.href="./reserve_step1.php"; });
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2"><a href="./reserve.php" class="sub_select">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><a href="./invited.php">1:1회의초청</a><a href="./room_list.php">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 회의방 예약</span></li>
			<li class="r3"><span>회의방 예약</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<ul>
				<li class="reserve_list">
					<span class="subject">공개회의방 목록</span>
					<input type="button" class="more" value="+ 더보기">
					<div id="common_room_list">
						<ul class="title">
							<li class="room_name">회의방 이름</li>
							<li class="room_time">시간</li>
							<li class="room_reader">방장</li>
							<li class="room_state">상태/입장</li>
						</ul>
						<ul>
							<li class="room_name">욱성기획팀 회의</li>
							<li class="room_time">09:00</li>
							<li class="room_reader">최성철</li>
							<li class="room_state"><span class="state1">대기중</span></li>
						</ul>
						<ul>
							<li class="room_name">욱성기획팀 회의</li>
							<li class="room_time">09:00</li>
							<li class="room_reader">최성철</li>
							<li class="room_state"><span class="state2">입장</span></li>
						</ul>
						<ul>
							<li class="room_name">욱성기획팀 회의</li>
							<li class="room_time">09:00</li>
							<li class="room_reader">최성철</li>
							<li class="room_state"><span class="state1">대기중</span></li>
						</ul>
					</div>
					<div id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></div>
				</li>
				<li class="reserve_state">
					<span class="subject">예약현황</span>
					<div id="common_room_list">
						<ul class="title">
							<li class="room_time">시간</li>
							<li class="room_week">월</li>
							<li class="room_week">화</li>
							<li class="room_week">수</li>
							<li class="room_week">목</li>
							<li class="room_week">금</li>
							<li class="room_week">토</li>
						</ul>
						<ul>
							<li class="room_time">09:00</li>
							<li class="room_week">완료</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
						</ul>
						<ul>
							<li class="room_time">09:00</li>
							<li class="room_week">완료</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
							<li class="room_week">12</li>
						</ul>
					</div>
					<div id="common_btn_area">
						<input type="button" id="btn_realtime" class="btn_small blue" value="실시간 회의방 신청">
						<input type="button" id="btn_invited" class="btn_small darkgray" value="1:1 회의 초청">
						<input type="button" id="btn_reserve" class="btn_small darkgray" value="회의방 예약">
					</div>
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>