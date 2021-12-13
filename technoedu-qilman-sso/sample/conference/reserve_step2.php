<? include "../include/header.php"; ?>
<!-- 실시간 회의방 신청 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve > ul { width:100%; margin:0px; padding:0px; }
#reserve > ul > li { padding:10px 0px; color:#404141; line-height:30px; }
#reserve > ul > li > span { display:inline-block; font-size:1.1em; padding-right:30px; font-weight:bold; vertical-align:top; }

#reserve > ul > li div.room_layout1 { display:inline-block; border-radius:15px; background:#d9d7d7; border:1px solid #b7b6b6;}
#reserve > ul > li div.room_layout1 > span { float:left; width:100px; height:70px; line-height:70px; text-align:center; color:#ffffff; font-weight:bold; }
#reserve > ul > li div.room_layout1 > span:nth-child(1) { border-right:1px solid #b7b6b6; border-bottom:1px solid #b7b6b6; }
#reserve > ul > li div.room_layout1 > span:nth-child(2) { border-bottom:1px solid #b7b6b6; }
#reserve > ul > li div.room_layout1 > span:nth-child(3) { clear:both; border-right:1px solid #b7b6b6; }

#reserve > ul > li div.room_layout2 { display:inline-block; border-radius:15px; background:#d9d7d7; border:1px solid #b7b6b6;}
#reserve > ul > li div.room_layout2 > span { float:left; width:70px; height:70px; line-height:70px; text-align:center; color:#ffffff; font-weight:bold; }
#reserve > ul > li div.room_layout2 > span:nth-child(1) { width:210px; border-bottom:1px solid #b7b6b6; }
#reserve > ul > li div.room_layout2 > span:nth-child(2) { clear:both; border-right:1px solid #b7b6b6; }
#reserve > ul > li div.room_layout2 > span:nth-child(3) { border-right:1px solid #b7b6b6; }

#reserve > ul > li input[type=radio] { vertical-align:top; }
#reserve > ul > li input[type=text] { height:30px; }
#reserve > ul > li select { min-width:120px; border:1px solid #d3d3d3; height:30px; }
#reserve > ul > li fieldset { width:250px; height:200px; padding:0px; border:1px solid #d3d3d3; border-radius:5px; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#reserve > ul > li fieldset > span { display:block; height:30px; width:100%; font-size:14px; font-weight:bold; color:#5b5a5a; text-align:center; border-bottom:1px solid #d3d3d3; background:#f5f5f5; }
#reserve > ul > li fieldset > span.add_user { cursor:pointer; }
#reserve > ul > li fieldset > input[type=checkbox]{ margin-left:20px; }

#reserve > ul > li .name { width:600px; }
#reserve > ul > li .user_select { width:300px; height:34px; margin-right:10px; }

#reserve > ul > li .LRbtn { width:78px; vertical-align:middle; }
#reserve > ul > li .LRbtn > input[type=button]{ width:78px; height:50px; margin-top:40px; cursor:pointer; }
#reserve > ul > li .btn_right { border:0px; background:url("../images/Rarrow.png") 0 50% no-repeat; }
#reserve > ul > li .btn_left { border:0px; background:url("../images/Larrow.png") 0 50% no-repeat; }
#reserve > ul > li .msg { width:960px; }

#reserve > ul > li input[type=file] { width:400px; border:1px solid #d3d3d3; height:30px; }
#reserve > ul > li .btn_file { width:100px; height:30px; background:#3388c9; border-radius:5px; border:1px solid #2479ba; margin-left:10px; color:#ffffff; }
#reserve > ul > li .btn_cash { width:100px; height:30px; background:#f7f7f7; border-radius:5px; border:1px solid #d2d2d2; margin-left:30px; color:#9b9b9b; }

/* 재정의 */
#common_btn_area { width:400px; }
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
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2"><a href="./reserve.php" class="sub_select">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><a href="./invited.php">1:1회의초청</a><a href="./meet_room_list">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 회의방 예약</span></li>
			<li class="r3"><span>회의방 예약</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<ul>
				<li><span>일시</span> 2014년 10월 12일 10:00 ~ 11:00</li>
				<li><span>인원</span> 4명</li>
				<li><span>이름</span><input type="text" class="name"></li>
				<li>
					<span>레이아웃</span>
					<span>
						<input type="radio" name="room_layout">
						<div class="room_layout1">
							<span>1</span>
							<span>2</span>
							<span>3</span>
							<span>4</span>
						</div>
					</span>
					<span>
						<input type="radio"name="room_layout">
						<div class="room_layout2">
							<span>1</span>
							<span>2</span>
							<span>3</span>
							<span>4</span>
						</div>
					</span>
				</li>
				<li>
					<span>참가자 선택</span><BR>
					<select class="user_select">
						<option>그룹명</option>
						<option></option>
					</select>
					<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
				</li>
				<li>
					<span>
						<fieldset>
							<? For($i=1; $i<10; $i++) { ?>
							<input type="checkbox"> 이순신<BR>
							<input type="checkbox"> 홍길동<BR>
							<? } ?>
						</fieldset>
					</span>
					<span class="LRbtn"><input type="button" class="btn_right"><input type="button" class="btn_left"></span>
					<span>
						<fieldset>
							<span class="add_user">회의참여자 목록 + </span>
							<input type="checkbox"> 이순신<BR>
							<input type="checkbox"> 홍길동<BR>
						</fieldset>
					</span>
				</li>
				<li>
					<span>
						<fieldset>
							<span>초대메시지</span>
							<input type="checkbox"> 이순신<BR>
							<input type="checkbox"> 홍길동<BR>
						</fieldset>
					</span>
					<span class="LRbtn"></span>
					<span>
						<fieldset>
							<span>초대방법 선택</span>
							<input type="checkbox"> E-mail<BR>
							<input type="checkbox"> 문자메세지<BR>
							<input type="checkbox"> 쪽지<BR>
						</fieldset>
					</span>
				</li>
				<li>
					<span>자료공유</span>
					<input type="file"><input type="button" value="Upload" class="btn_file"> 
				</li>
				<li>
					<span>결제</span>500캐시 차감
					<span style="padding-left:100px;">현재 내 캐시</span>400캐시<input type="button" value="캐시충전" class="btn_cash">
				</li>
				<li id="common_btn_area">
					<input type="button" id="before_step" value="이전단계" class="btn_big darkgray">
					<input type="submit" id="next_step" value="확인" class="btn_big blue">
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>