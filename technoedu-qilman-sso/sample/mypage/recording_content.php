<? include "../include/header.php"; ?>
<!-- 녹화리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<link rel="stylesheet" type="text/css" href="../include/css/mypage.css">

<style>
#movie { width:1100px; margin-top:20px; }
#movie > video { width:100%; }

/* 재정의 */
#common_btn_area {
	width:100px;
	float:right;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#recording_list").click(function(){ location.href="./recording_list.php"; });
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php" class="sub_select">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My FaceLink > 녹화리스트</span></li>
			<li class="r3"><span>녹화리스트</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<ul id="common_room_content">
				<li><span>회의일시</span>2014년 10월 28일 13:00 15:00</li>
				<li><span>회의명</span>(주)○○○ 주간회의</li>
			</ul>
			<div id="movie">
				<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
			</div>
			<div id="common_btn_area"><input type="button" id="recording_list" class="btn_small gray" value="목록보기"></div>
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>