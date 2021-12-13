<? include "../include/header.php"; ?>
<!-- 공개 회의방 목록 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">

<style>
#invited { display:inline-block; *zoom:1; width:100%; }
#invited > ul { width:100%; margin:0px; padding:0px; }
#invited > ul > li { float:left; display:inline-block; padding:10px; }
#invited > ul > li:first-child { width:40%; }
#invited > ul > li:last-child { width:60%; font-size:15px; color:#404141; }
#invited > ul > li:last-child ul > li { padding:10px 0px; }
#invited > ul > li:last-child ul > li > span { display:inline-block; margin:auto 0px; padding:0px; height:25px; font-size:1.1em; padding-right:20px; }
#invited > ul > li:last-child ul > li > input[type=text],
#invited > ul > li:last-child ul > li > select
{ border:1px solid #d3d3d3; height:30px; }
#invited > ul > li:last-child ul > li #name { width:300px; }
#invited > ul > li:last-child ul > li #user_select1 { width:48%; height:34px; margin-right:10px; }

#invited > ul > li:last-child ul > li textarea { width:98%; height:200px; border:1px solid #d3d3d3;}
#invited > ul > li:last-child ul > li #msg { width:98%; }

/* 재정의 */
#common_btn_area { width:370px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2">
			<a href="./reserve.php">회의방 예약</a>
			<a href="./realtime.php" >실시간 회의방 신청</a>
			<!--a href="./invited.php">1:1회의초청</a-->
			<a href="./room_list.php">공개 회의방 목록</a>
			<a href="./directcomm.php" class="sub_select">번호 연결 서비스</a>
			<span class="path">HOME > 회의방 예약 > 번호연결</span></li>
			<li class="r3"><span>번호 연결 서비스</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="invited">
			<ul>
				<li><p style="font-size:25px; line-height:40px; color:#949292;"><span style="font-size:32px; color:#6f6c6c">번호 연결 서비스</span>는<BR>회의방 번호 또는 연결되어 있는<br> 장비의 번호로 직접 연결을 지원하는 <br>기능을 제공합니다.</p>
				<img src="../images/invited.png" style="padding-top:50px; ">
				</li>
				<li>
					<form action="../mypage/meeting_direct.php" method=POST>
					<ul>
						<li><b>연결할 번호를 입력하세요</b></li>
						<li><b>번호 : </b><input type="text" id="name" name="sipnumber">
						<input type="submit" value="연결 시작" class="btn_small blue">
						</li>
						<li><font color=gray>* 연동되는 서비스는 WebRTC 미디어 형식을 지원해야 합니다.
						<br>* 앞에 "sip:" 로 시작하는 형식은 입력하지 않습니다.</font></li>
					</ul>
					</form>
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
