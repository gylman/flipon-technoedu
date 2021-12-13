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
                        <!--
						<li><a href="index.html">홈</a></li>
						<li><a href="left-sidebar.html">설정</a></li>
						<li><a href="right-sidebar.html">화상통화</a></li>
						<li><a href="index_en.html">English</a></li>
						<li><a href="#" class="button special">로그인</a></li>
                        -->
						<li><a href="index_jacklist.php">한국어</a></li>
						<li><a href="../index.php" class="button special">Log Out</a></li>
						<li><a href="../mypage/device_test_mentor.php" class="button special">設定</a></li>

                        <!--
						<li><input type="button" value="1対1モード" class="button special" onclick='javascript:callconnect();'></li>
						<li><input type="button" value="連絡先" class="button special" onclick='javascript:phoneBook();'></li>
						<li><input type="button" value="設定" class="button special" onclick='javascript:cameratest();'></li>
                        -->
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>Mentor BOX System</h2>
					<p>リアルタイム・リモート会議/授業システム</a></p>
					<form name="formcall">
					    <ul class="actions">
                            <li><input type="button" value="No.1、" class="button big special" id="bt_0411000" onclick='connecttomcu("0411000",serverip);'></li>
                            <li><input type="button" value="No.2、" class="button big special" id="bt_0412000" onclick='connecttomcu("0412000",serverip);'></li>
                            <li><input type="button" value="No.3、" class="button big special" id="bt_0413000" onclick='connecttomcu("0413000",serverip);'></li>
				    	</ul>
					    <ul class="actions">
                            <li><input type="button" value="テスト" class="button big special" id="bt_0414000" onclick='connecttomcu("0414000",serverip);'></li>
                            <li><input type="button" value="HOME" class="button big special" onclick="location.href='http://jacklist.co.jp'"></li>
					    </ul>
					</form>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
                    <!--
					<h2>Mentor BOX Video Service System</h2>
					<p>Mentor BOX 서비스에 오신것을 환영합니다. 연결 화면을 선택하세요.</p>
                    -->
					<h3>Mentor BOXサービスをご利用いただきありがとうございます。
						接続する画面を選択してください。</h3>
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

var roomList = ["0411000", "0412000", "0413000", "0414000"];
var roomNameList = ["No.1、", "No.2、", "No.3、", "テスト"];
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
</html>