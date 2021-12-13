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
});	
</script>
<body>
<div id="wrap">
	<header id="header">
		<ul id="gnb">
			<li class="logo"><a href="/"><img class="mentor_sub_logo" src="../images/sub_logo.png"></a></li>
		</ul>
	</header>	
