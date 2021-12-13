<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<script type="text/javascript">
checkLogin(true, true);
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php" >나의 회의</a><a href="./recording_list.php">지난회의목록</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="../join/join_edit.php">회원정보</a><a href="../mypage/device_test.php" class="sub_select">장치설정</a><span class="path">HOME > My i-Mentor> 장치 설정</span></li>
			<li class="r3"><span>장치 설정</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<section id="sub1">

<table border=0><tr><td>
<video width=320 height=240 muted autoplay></video>
</td>
<td>&nbsp;</td>
<td>
<canvas id="meter" width="50" height="240" style="float:left;"></canvas>
</td></tr></table>
  <div class="select">
    <label for="audioSource">오디오 장치: </label><select id="audioSource" style="width:250px;"></select>
  </div>

  <div class="select">
    <label for="videoSource">비디오 장치: </label><select id="videoSource" style="width:250px;"></select>
  </div>
<br> <input id="saveDevice" type="button" value="저장" class="btn_small blue" style="margin-left:110px;">
			</section>
		</div>
	</section>
<script src="./js/adapter.js"></script>
<script src="./js/device.js?v=2"></script>
<script src="./js/volume-meter.js"></script>

<script type="text/javascript">
$('#saveDevice').click( function() {
	window.localStorage.setItem('wsmedia.audio_src_id', $('#audioSource').val());
	window.localStorage.setItem('wsmedia.video_src_id', $('#videoSource').val());
	alert("디바이스 설정이 저장되었습니다.");
});
</script>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
