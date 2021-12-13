<?
include_once("../include/common.func.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<title>i-Mentor Service</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="../css/basic.css">
<link rel="stylesheet" type="text/css" href="../css/sub.css">

<script src="../js/html5shiv.js" type="text/javascript"></script>
<script src="../js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="../js/underscore/underscore-min.js" type="text/javascript"></script>
<script src="../js/backbone/backbone-min.js" type="text/javascript"></script>

<script src="../js/config.js?v=2" type="text/javascript"></script>
<script src="../js/common.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	// login check
	checkLogin();
	
	$('#btn_reserve').click(function(e) {
        if (g_user_id.length <= 0) {
			location.href = '../join/login.php?go=../conference/room_list.php';
		} else {
			location.href = '../conference/room_list.php';
		}
    });

	$('#btn_imentor').click(function(e) {
        if (g_user_id.length <= 0) {
			location.href = '../join/login.php';
		} else {
				if (g_user_part.length > 0) {
                    if (g_user_part == "038")
					    location.href = "../web200h/index2.html";
                    else if (g_user_part == "livedu")
					    location.href = "../web200h/index_livedu.php";
                    else if (g_user_part == "wsv")
					    location.href = "../web200h/index_wsv.php";
                    else if (g_user_part == "hanbat")
					    location.href = "../web200h/index_hanbat.php";
                    else if (g_user_part == "sejong")
					    location.href = "../web200h/index_sejong.php";
                    else if (g_user_part == "ocean")
					    location.href = "../web200h/index_ocean.php";
                    else if (g_user_part == "wooksung")
					    location.href = "../web200h/index_test.php";
                    else if (g_user_part == "djtp")
					    location.href = "../web200h/index_test.php";
                    else if (g_user_part == "raon")
					    location.href = "../web200h/index_raon.php";
                    else if (g_user_part == "jacklist")
					    location.href = "../web200h/index_jacklist_jpn.php";
                    else if (g_user_part == "flipon")
					    location.href = "../web200h/index_flipon.php";
                    else
					    location.href = "../../company/service.php";
				} else {
					location.href = "../../company/service.php";
				}
		}
    });
});	
</script>
<body>
<div id="wrap">
	<header id="header">
		<ul id="gnb">
			<li class="logo"><a href="/"><img class="sub_logo" src="../images/sub_logo.png"></a></li>
			<li class="main_gnb">
				<ul>
					<!--<li><a href="../web200h/index_test.php"><img src="../images/gnb1.png"></a></li>-->
					<!-- <li><a id="btn_imentor" href="#"><img src="../images/gnb1.png"></a></li>
					<li><a id="btn_reserve" href="#"><img src="../images/gnb2.png"></a></li>
					<li><a href="../company/service.php"><img src="../images/gnb3.png"></a></li>
					<li><a href="../company/contact.php"><img src="../images/gnb4.png"></a></li> -->
					<li><a id="btn_imentor" href="#"><img class="i_mentor_button" src="../images/gnb1.png"></a></li>
					<li><a id="btn_reserve" href="#"><img class="reserve_button"src="../images/gnb2.png"></a></li>
					<li><a href="../company/service.php"><img class="service_button" src="../images/gnb3.png"></a></li>
					<li><a href="../company/contact.php"><img class="contact_button" src="../images/gnb4.png"></a></li>
				</ul>
			</li>
			<li class="top_gnb">
				<ul>
					<!-- <li class="login"><a href="../join/login.php"><img src="../images/med1.png"></a></li>
                    <li class="logout"><a href="javascript:logout();"><img src="../images/logout.png"></a></li>
					<li class="join"><a href="../join/join_step1.php"><img src="../images/med2.png"></a></li>
					<li class="mypage"><a href="../mypage/meeting_list.php"><img src="../images/med3.png"></a></li> -->
					<!--li class="fb"><a href="#" target="_blank"><img src="../images/med4.png"></a></li-->

					<li class="login"><a href="../join/login.php"><img class="login_button" src="../images/med1.png"></a></li>
                    <li class="logout"><a href="javascript:logout();"><img class="logout_button" src="../images/logout.png"></a></li>
					<li class="join"><a href="../join/join_step1.php"><img class="join_button" src="../images/med2.png"></a></li>
					<li class="mypage"><a href="../mypage/meeting_list.php"><img class="mypage_button" src="../images/med3.png"></a></li>
				</ul>
			</li>
		</ul>
	</header>	
