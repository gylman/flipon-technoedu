<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#meeting_room").click(function(){ location.href="./meeting_room.php"; });
	$("#meeting_list").click(function(){ location.href="./meeting_list.php"; });
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My i-Mentor> 나의 회의</span></li>
			<li class="r3"><span>나의 회의</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<ul id="common_room_content">
				<li><span>일시</span>2014년 10월 28일 13:00 15:00</li>
				<li><span>제목</span>(주)○○○ 주간회의</li>
				<li><span>방장</span>홍길동</li>
				<li><span>참여자</span>김과장, 이부장, 최주임</li>
			</ul>
			<div id="common_btn_area">
				<span style="float:left; width:30%; "><input type="button" class="btn_small gray" value="회의 취소하기"></span>
				<span style="width:30%; ">
					<input type="button" id="meeting_room" class="btn_small blue" value="참여하기">
					<input type="button" class="btn_small gray" value="방 생성">
					<input type="button" class="btn_small gray" value="방 제어">					
				</span>
				<span style="float:right; width:30%; text-align:right; ">
					<input type="button" id="meeting_list" class="btn_small gray" value="목록보기">
				</span>
			</div>
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
