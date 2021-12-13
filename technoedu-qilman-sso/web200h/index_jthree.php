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
    var serverip="115.68.14.22";
    function connecttomcu(roomnumber,mcuip) {

        var form = document.createElement("form");
        form.setAttribute("charset", "UTF-8");
        form.setAttribute("method", "Post");
        form.setAttribute("action", "../mypage/meeting_mentor.php");

        var formField = document.createElement("input");
        formField.setAttribute("type", "text");
        formField.setAttribute("name", "sipnumber");
        formField.setAttribute("value", roomnumber);
        form.appendChild(formField);
 
        var formField1 = document.createElement("input");
        formField1.setAttribute("type", "text");
        formField1.setAttribute("name", "mcuip");
        formField1.setAttribute("value", mcuip);
        form.appendChild(formField1);
       
        document.body.appendChild(form);

        form.submit();
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
						<li><a href="../index.php" class="button special">로그아웃</a></li>
						<li><a href="../mypage/device_test_mentor.php" class="button special">장치설정</a></li>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>Mentor BOX System</h2>
					<p>실시간 화상회의 시스템</a></p>
					<form name="formcall">
					    <ul class="actions">
                            <li><input type="button" value="1 번" class="button big special" id="bt_14220601" onclick='connecttomcu("14220601",serverip);'></li>
                            <li><input type="button" value="2 번" class="button big special" id="bt_14220602" onclick='connecttomcu("14220602",serverip);'></li>
					    </ul>
					</form>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Mentor BOX 서비스에 오신것을 환영합니다.</h2>
					<p>연결할 방 번호를 선택하세요</p>
				</header>
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
						<li><input type="button" value="Main Url" class="button small special" onclick='javascript:changeUrl();'></li>
						<li><input type="button" value="web on video" class="button small special" onclick='javascript:webUrl();'></li>
						<li><input type="button" value="Local Test" class="button small special" onclick='javascript:calltomcu("100", "2", "mentor", "1", "192.168.0.201");'></li>
                        -->
					</ul>
				</div>
			</footer>

<script type="text/javascript">

var roomList = ["14220601", "14220602"];
var roomNameList = ["1 번", "2 번"];
// get room uid

function updateRoom() {
    $.post('../mcutest/mcucomm.php', {mcuip:serverip ,cmd: 'GetConfList'} )
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
