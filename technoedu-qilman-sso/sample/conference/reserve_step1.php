<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#reserve { display:inline-block; *zoom:1; width:100%; }
#reserve > ul { width:100%; margin:0px; padding:0px; }
#reserve > ul > li { padding:10px 0px; color:#404141; line-height:30px; }
#reserve > ul > li.reserve_list { width:100%; height:530px; border:1px solid #cccccc; border-radius:10px; padding:20px 30px 30px 30px; margin-bottom:30px; overflow-x:hidden; overflow-y:scroll; }
#reserve > ul > li.reserve_list > ul { width:16.66%; float:left; border:1px solid #cccccc; box-sizing:border-box; }
#reserve > ul > li.reserve_list > ul:hover { border:3px solid #2577b8; }
.reserve_list > ul > li { height:40px; text-align:center; }
.reserve_list > ul > li:nth-child(even) { background:#efefef; }
.reserve_list > ul > li > span { display:inline-block; width:60px; height:30px; margin:5px auto; border-radius:5px; cursor:pointer; }
.reserve_list > ul > li > span.state1 { /*background:#efefef;*/ color:#bbbbbb; border:1px solid #cccccc; } /* 완료 */
.reserve_list > ul > li > span.state2 { background:#2577b8; color:#ffffff; border:1px solid #cccccc; } /* 선택 */
.reserve_list > ul > li > span.state3 { background:orange; border:1px solid #cccccc; } /* 해제 */

#reserve > ul > li > span { display:inline-block; width:150px; font-size:1.1em; font-weight:bold; vertical-align:top; }
#reserve > ul > li select { width:150px; height:30px; padding-left:5px; border:1px solid #d3d3d3; }
#reserve > ul > li #datepicker { width:200px; height:30px; padding:0px 5px; border:1px solid #d3d3d3;  background:url("../images/calendar.png") 97% 50% no-repeat; }
#reserve > ul .subject { display:inline-block; margin:20px 0 10px 0px; font-size:16px; font-weight:bold; }

/* 회의방 리스트 사이즈 재정의 */
#common_room_list li.room_time { width:20%; }
#common_room_list li.room_week { width:13.33%; }

#common_btn_area { width:178px; }
</style>

<!-- 달력 -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	/* 달력 */
	$("#datepicker").datepicker();
	$("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd");
	$('#datepicker').val($.datepicker.formatDate('yy-mm-dd', new Date()));

	$(".state2").click(function(){ $(this).toggleClass("state3"); });
	
	/* 다음단계 */
	$("#next_step").click(function(){
		location.href="./reserve_step2.php";
	});
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">회의방 예약</li>
			<li class="r2"><a href="./reserve.php" class="sub_select">회의방 예약</a><a href="./realtime.php">실시간 회의방 신청</a><a href="./invited.php">1:1회의초청</a><a href="./room_list.php">공개 회의방 목록</a><span class="path">HOME > 회의방 예약 > 회의방 예약</span></li>
			<li class="r3"><span>회의방 예약</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="reserve">
			<ul>
				<li><span>회의인원 선택</span>
					<select>
						<option>인원선택</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
					</select>
				</li>
				<li>
					<span>회의 일자</span>
					<input type="text" id="datepicker">
				</li>
				<span class="subject">시간선택</span>
				<li class="reserve_list">
					<!-- 시간 30분단위 -->
					<ul>
						<li>시간</li>
						<? 
						for ($i=1; $i<=12; $i++) { 
							$hour = sprintf("%02d", $i).":00"; 
							$hour30 = sprintf("%02d", $i).":30"; 
							echo "<li>$hour</li><li>$hour30</li>";  
						} 
						?>
					</ul>
					<!-- 회의일자 앞뒤 2일을 배치하도록 한다. -->
					<? for($col=1; $col<6; $col++){ ?>
					<ul>
						<li>날짜</li>
						<? 
						for($row=1; $row<25; $row++){ 
							if($row % 2 == 0) { ?>
							<!-- 완료 -->
							<li><span class="state1">완료</span></li>
						<? } else if ($row % 2 == 1) { ?>
							<!-- 선택 -->
							<li><span class="state2">선택</span></li>
						<? }
						} ?>
					</ul>
					<? } ?>									
				</li>				
			</ul>
			<div id="common_btn_area">
				<input type="button" id="next_step" class="btn_big blue" value="다음단계">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>