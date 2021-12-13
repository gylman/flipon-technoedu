<? include "../include/header.php"; ?>
<!-- 회의방 입장-일반 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve .video { width:70%; float:left; border:1px solid red; }
#reserve .room_fun { width:30%; float:right; border:1px solid green; }

</style>

<script type="text/javascript">
$(document).ready(function() {
	/* 회의참여자 목록 + */
	$(".add_user").click(function(){
		window.open("./add_user.php","","width=400, height=400");
	});
	
	/* 이전단계 */
	$("#before_step").click(function(){
		location.href="./reserve_step1.php";
	});

	/* 확인 */
	$("#next_step").click(function(){
		//location.href="./reserve_step3.php";
	});
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2"><a href="./reserve.php" class="sub_select">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><!--a href="./invited.php">1:1회의초청</a--><a href="./room_list.php">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 회의방 예약</span></li>
			<li class="r3"><span>회의방 예약</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<div class="video">
				<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video> 
			</div>
			<div class="room_fun">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>