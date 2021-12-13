<? include "../include/header.php"; ?>
<!-- 공개 회의방 목록 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<script type="text/javascript">
$(document).ready(function() {
	$("#common_room_list > ul").click(function(){
		window.open("./chk_pw.php", "", "width=380, height=200");
	});
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2"><a href="./reserve.php">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><a href="./invited.php">1:1회의초청</a><a href="./room_list.php" class="sub_select">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 공개 회의방 목록</span></li>
			<li class="r3"><span>공개 회의방 목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="common_room_list">
			<ul class="title">
				<li class="room_name">회의방 이름</li>
				<li class="room_time">시간</li>
				<li class="room_reader">방장</li>
				<li class="room_personcnt">참여인원</li>
				<li class="room_state">상태/입장</li>
			</ul>
			<ul>
				<li class="room_name">욱성기획팀 회의</li>
				<li class="room_time">09:00</li>
				<li class="room_reader">최성철</li>
				<li class="room_personcnt">3/4</li>
				<li class="room_state"><span class="state1">대기중</span></li>
			</ul>
			<ul>
				<li class="room_name">욱성기획팀 회의</li>
				<li class="room_time">09:00</li>
				<li class="room_reader">최성철</li>
				<li class="room_personcnt">3/4</li>
				<li class="room_state"><span class="state2">입장</span></li>
			</ul>
			<ul>
				<li class="room_name">욱성기획팀 회의</li>
				<li class="room_time">09:00</li>
				<li class="room_reader">최성철</li>
				<li class="room_personcnt">3/4</li>
				<li class="room_state"><span class="state1">대기중</span></li>
			</ul>
		</div>
		<div id="common_reserve_page">
			<div class="page_group">
				<span class="page_left">◀</span>
				<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
				<span class="page_right">▶</span>
			</div>
		</div>
		<div id="common_reserve_search">
			<input type="text" class="input_search"><input type="button" class="btn_search">
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>