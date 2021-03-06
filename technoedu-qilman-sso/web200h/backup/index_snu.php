<!DOCTYPE HTML>
<html>
	<head>
		<title>Mentor BOX</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
			<link rel="stylesheet" href="css/style2.css" />
		</noscript>
	</head>

<script type="text/javascript" charset='utf-8'>
    function calltomcu(no, mode, id, layout, mcu) {
        var classInfo = new Object();
        classInfo.no = no;
        classInfo.mode = mode;
        classInfo.id = id;
        classInfo.layout = layout;
        classInfo.mcu = mcu;
        var jsonStr = JSON.stringify(classInfo);
        //console.log(jsonStr);
        //alert(jsonStr);
        window.WSMEDIA.startCall(jsonStr);
    }

    function cameratest() {
        window.WSMEDIA.cameraTest();
    }

    function captureCamera() {
        window.WSMEDIA.captureCamera();
    }

    function phoneBook() {
        window.WSMEDIA.phoneBook();
    }

    function changeUrl() {
        window.WSMEDIA.changeUrl();
    }

    function webUrl() {
        window.WSMEDIA.webUrl();
    }

    function captureUrl() {
        window.WSMEDIA.captureUrl();
    }

    function serverSetting() {
        window.WSMEDIA.serverSetting();
    }

    function callconnect() {
        window.WSMEDIA.callconnect();
    }
</script>

	<body id="top">

		<!-- Header -->
			<header id="header" class="skel-layers-fixed">
				<h1><a href="#">Mentor BOX</a></h1>
				<nav id="nav">
					<ul>
                        <!--
						<li><a href="index.html">홈</a></li>
						<li><a href="left-sidebar.html">설정</a></li>
						<li><a href="right-sidebar.html">화상통화</a></li>
						<li><a href="index_en.html">English</a></li>
						<li><a href="#" class="button special">로그인</a></li>
                        -->
						<li><input type="button" value="1:1 Conn." class="button special" onclick='javascript:callconnect();'></li>
						<li><input type="button" value="Contact" class="button special" onclick='javascript:phoneBook();'></li>
						<li><input type="button" value="Check Device" class="button special" onclick='javascript:cameratest();'></li>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>Mentor BOX System</h2>
					<p>Video Service System</a></p>
					<form action="../mypage/meeting_direct.php" method=POST>
					    <ul class="actions">
                            <li><input type="submit" value="0381000" class="button big special" id="bt_0381000" name="sipnumber"></li>
                            <li><input type="submit" value="0382000" class="button big special" id="bt_0382000" name="sipnumber"></li>
                            <li><input type="submit" value="0383000" class="button big special" id="bt_0383000" name="sipnumber"></li>
				    	</ul>
					    <ul class="actions">
                            <li><input type="submit" value="0384000" class="button big special" id="bt_0384000" name="sipnumber"></li>
                            <li><input type="submit" value="0385000" class="button big special" id="bt_0385000" name="sipnumber"></li>
                            <li><input type="button" value="설문" class="button big special" onclick="location.href='https://survey.flip-on.com'"></li>
                            <li><input type="button" value="Flip on" class="button big special" onclick="location.href='https://flip-on.com'"></li>
					    </ul>
					</form>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Mentor BOX Video Service System</h2>
					<p>Mentor BOX. Welcome, press the room button or 1:1 Mode to start service.</p>
				</header>
								
			
                        <!--
				<div class="container">
				<div class="row">
					<div class="4u">
						<section class="special box"> <span class="fa fa-cloud-download fa-3x"></span>
							<p class="box_text"><br>사용자를 추가하거나 정보를 바꿀 수 있습니다. 관리자만 이 기능을 사용할 수 있습니다.</p>
						</section>
					</div>
					<div class="4u">
						<section class="special box"><span class="fa fa-cogs fa-3x"></span>
							<p class="box_text"><br>단말의 세팅값과 환경을 바꿀 수 있습니다. 네트워크, 화면, 코덱 정보등을 설정합니다.</p>
						</section>
					</div>
					<div class="4u">
						<section class="special box"> <span class="fa fa-users fa-3x"></span>
							<p class="box_text"><br>강의 리스트에서 화상회의를 연결할 수 있습니다. 해당 강의 리스트를 검색하거나 확인하세요. </p>
						</section>
					</div>
				</div>
				</div>
                        -->
			</section>
			
		<!-- Footer -->
			<footer id="footer">
				<div class="container">
					<ul class="copyright">
						<li>&copy; WOOKSUNGMEDIA All rights reserved.</li>
                        <!--
						<li>Homepage: <a href="http://wooksungmedia.com">Wooksungmedia.com</a></li>
						<li>Telephone: 82-42-931-5025</li>
						<li><input type="button" value="로컬테스트" class="button small special" onclick='javascript:calltomcu("100", "2", "mentor", "1", "192.168.0.220");'></li>
                        -->
						<li><input type="button" value="Main Url" class="button small special" onclick='javascript:changeUrl();'></li>
						<li><input type="button" value="web on video" class="button small special" onclick='javascript:webUrl();'></li>
						<li><input type="button" value="Local Test" class="button small special" onclick='javascript:calltomcu("100", "2", "mentor", "1", "192.168.0.201");'></li>
					</ul>
				</div>
			</footer>

<script type="text/javascript">

var roomList = ["0381000", "0382000", "0383000", "0384000", "0385000"];
var roomNameList = ["ROOM 1", "ROOM 2", "ROOM 3", "TEST 1", "TEST 2"];
// get room uid

function updateRoom() {
    $.post('./mcucomm/mcucomm_115_68_14_22.php', {cmd: 'GetConfList'} )
        .done(
                function ( data ) {
                    val = eval('(' + data + ')');
                    if ( val == null ) {
                    console.log("Err");
                    return;
                }

                console.log(val);
                for ( var j = 0; j< roomList.length; j++) {
                    var findRoom = false;
                    for ( var i = 0; i < val.conflist.length; i++ ) {
                        if (val.conflist[i].did == roomList[j] && parseInt(val.conflist[i].numpart) > 0) {
                        $("#bt_"+roomList[j]).css("background-color", "#ff6565");       
                        document.getElementById("bt_"+roomList[j]).value = roomNameList[j] + " (" + val.conflist[i].numpart + ")";
                        findRoom = true;
                    }
                }
                if ( findRoom == false ) {
                    $("#bt_"+roomList[j]).css("background-color", "");       
                    document.getElementById("bt_"+roomList[j]).value = roomNameList[j];
                }
           }
        }
    );

    setTimeout(updateRoom, 10000);
}

updateRoom();
</script>
	</body>
</html>
