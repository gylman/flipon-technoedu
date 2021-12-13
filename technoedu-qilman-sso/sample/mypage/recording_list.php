<? include "../include/header.php"; ?>
<!-- 녹화리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<link rel="stylesheet" type="text/css" href="../include/css/mypage.css">

<style>
/* 재정의 */
#common_room_list li.room_time { width:40%; }
#common_room_list li.room_name { width:60%; }

#common_room_list ul~ul { cursor:pointer; }



</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#common_room_list > ul~ul").click(function(){ location.href="./recording_content.php"; });
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
			<div id="common_room_list">
				<ul class="title">
					<li class="room_time">일자</li>
					<li class="room_name">회의명</li>
				</ul>
				<ul>
					<li class="room_time">2014년 10월 22일 06:00 ~ 11:00</li>
					<li class="room_name">○○○ 주간회의</li>
				</ul>
				<ul>
					<li class="room_time">2014년 10월 22일 13:00 ~ 14:00</li>
					<li class="room_name">영업팀 보고</li>
				</ul>
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>