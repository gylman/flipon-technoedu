

<?
include_once("../include/common.func.php");
?>


<!-- css -->
<link rel="stylesheet" type="text/css" href="../css/sub.css">
<link rel="stylesheet" type="text/css" href="../web200h/css/skel.css" />
<link rel="stylesheet" type="text/css" href="../web200h/css/style-xlarge.css" />
<link rel="stylesheet" type="text/css" href="../web200h/css/style2.css" />

<script src="../js/html5shiv.js" type="text/javascript"></script>
<script src="../js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="../js/underscore/underscore-min.js" type="text/javascript"></script>
<script src="../js/backbone/backbone-min.js" type="text/javascript"></script>

<script src="../js/config.js?v=2" type="text/javascript"></script>
<script src="../js/common.js" type="text/javascript"></script>





	<head>
		<title>Mentor BOX</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="../web200h/js/jquery.min.js"></script>
		<script src="../web200h/js/skel.min.js"></script>
		<script src="../web200h/js/skel-layers.min.js"></script>
		<script src="../web200h/js/init.js"></script>
	</head>
		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">Mentor BOX</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="../index.php" class="button special">Log Out</a></li>
						<li><input type="button" value="Home" class="button special" onclick="goBack()"></li>
					</ul>
				</nav>
			</header>










<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<script type="text/javascript">
checkLogin(true, true);

function goBack() {
    window.history.back();
}
</script>

<section id="sub_section">
	<div id="mypage">
		<section id="sub1">
            <table border=0><tr><td>
            <video width=320 height=240 muted autoplay></video>
            <canvas id="meter" width="50" height="240"></canvas>
            </td></tr></table>
            <div class="select">
            <label for="audioSource">오디오 장치: </label><select id="audioSource" style="width:450px;"></select>
            </div>

            <div class="select">
            <label for="videoSource" style="margin-top:30px;">비디오 장치: </label><select id="videoSource" style="width:450px"></select>
            </div>
            <br> <input id="saveDevice" type="button" value="저장" class="button special">
			</section>
		</div>
	</section>

<script src="./js/adapter.js"></script>
<script src="./js/device.js?v=1"></script>
<script src="./js/volume-meter.js"></script>

<script type="text/javascript">
$('#saveDevice').click( function() {
	window.localStorage.setItem('wsmedia.audio_src_id', $('#audioSource').val());
	window.localStorage.setItem('wsmedia.video_src_id', $('#videoSource').val());
    //alert("Audio: "+$('#audioSource').val()+" Video: "+$('#videoSource').val());
	alert("디바이스 설정이 저장되었습니다.");
});
</script>

	<!-- 하단 -->
			<footer id="footer">
				<div class="container">
					<ul class="copyright">
						<li>&copy; WOOKSUNGMEDIA All rights reserved.</li>
					</ul>
				</div>
			</footer>
