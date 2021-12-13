<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
#mypage { display:inline-block; *zoom:1; width:100%; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	/*
	$("#next_step").click(function(){
		location.href="./reserve_step1.php";
	});
	*/
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My i-Mentor> 나의 회의</span></li>
			<li class="r3"><span>나의 회의</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
