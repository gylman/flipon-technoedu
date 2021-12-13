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
#invited > ul > li:last-child ul > li #name { width:80%; }
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
			<li class="r2"><a href="./reserve.php">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><a href="./invited.php" class="sub_select">1:1회의초청</a><a href="./room_list.php">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 1:1회의초청</span></li>
			<li class="r3"><span>1:1회의초청</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="invited">
			<ul>
				<li><p style="font-family:'Nanum Myeongjo'; font-size:27px; line-height:40px; color:#949292;"><span style="font-size:32px; color:#6f6c6c">1:1 회의 초청</span>은<BR>시간에 관계없이 무료로<BR>이용할 수 있습니다.</p>
				<img src="../images/invited.png" style="padding-top:50px; ">
				</li>
				<li>
					<form>
					<ul>
						<li><span>이름</span> <input type="text" id="name"></li>
						<li><span>참가자 선택</span><BR>
							<select id="user_select1">
								<option>그룹명</option>
								<option></option>
							</select>
							<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
						</li>
						<li><textarea></textarea></li>
						<li>
							<span>초대메세지<span style="font-size:13px; color:#686969; ">(초대메세지는 문자메세지로 발송됩니다.)</span></span><BR>
							<input type="text" id="msg">
						</li>
						<li id="common_btn_area">
							<input type="button" value="취소" class="btn_big blue">
							<input type="submit" value="회의방 생성 및 입장" class="btn_big blue">
						</li>
					</ul>
					</form>
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>