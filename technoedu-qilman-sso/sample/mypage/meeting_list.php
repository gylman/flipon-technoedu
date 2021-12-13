<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<link rel="stylesheet" type="text/css" href="../include/css/mypage.css">

<style>
/* My FaceLink - 나의 회의 부분 */
#mypage .col1 { width:25%; text-align:center; }
#mypage .col2 { width:40%; text-align:left; padding-left:20px; }
#mypage .col3 { width:15%; text-align:center; }
#mypage .col4 { width:20%; text-align:center; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#enter_room").click(function(){
		location.href="./meeting_content.php";
	});
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My FaceLink > 나의 회의</span></li>
			<li class="r3"><span>나의 회의 목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<div id="common_room_list">
				<ul class="title">
					<li class="col1">일자</li>
					<li class="col2">회의명</li>					
					<li class="col3">회의 참여</li>
					<li class="col4">회의 방 제어</li>
				</ul>
				<ul>
					<li class="col1">2014년 10월 22일&nbsp;&nbsp;09:00~11:00</li>
					<li class="col2">○○○ 주간회의</li>					
					<li class="col3"><input type="button" id="enter_room" class="btn_small blue" value="참여하기"></li>
					<li class="col4">
						<input type="button" class="btn_small lightgray" value="방 생성">
						<input type="button" class="btn_small lightgray" value="방 제어">
					</li>
				</ul>
				<ul>
					<li class="col1">2014년 10월 22일&nbsp;&nbsp;09:00~11:00</li>
					<li class="col2">○○○ 주간회의</li>					
					<li class="col3">대기중</li>
					<li class="col4"></li>
				</ul>
			</div>			
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>