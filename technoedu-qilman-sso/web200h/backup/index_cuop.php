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
    function connecttomcu(roomnumber) {

        var form = document.createElement("form");
        form.setAttribute("charset", "UTF-8");
        form.setAttribute("method", "Post");
        form.setAttribute("action", "../mypage/meeting_mentor.php");

        var formField = document.createElement("input");
        formField.setAttribute("type", "text");
        formField.setAttribute("name", "sipnumber");
        formField.setAttribute("value", roomnumber);
        form.appendChild(formField);
        
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
						<li><a href="../index.php" class="button special">????????????</a></li>
						<li><a href="../mypage/device_test_mentor.php" class="button special">????????????</a></li>
					</ul>
				</nav>
			</header>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h2>Mentor BOX System</h2>
					<p>Video Service System</a></p>
					<form name="formcall">
					    <ul class="actions">
                            <li><input type="button" value="1 ???" class="button big special" id="bt_0301000" onclick='connecttomcu("0301000");'></li>
                            <li><input type="button" value="2 ???" class="button big special" id="bt_0302000" onclick='connecttomcu("0302000");'></li>
                            <li><input type="button" value="3 ???" class="button big special" id="bt_0303000" onclick='connecttomcu("0303000");'></li>
					    </ul>
					    <ul class="actions">
                            <li><input type="button" value="4 ???" class="button big special" id="bt_0301000" onclick='connecttomcu("0304000");'></li>
                            <li><input type="button" value="5 ???" class="button big special" id="bt_0302000" onclick='connecttomcu("0305000");'></li>
                            <li><input type="button" value="6 ???" class="button big special" id="bt_0303000" onclick='connecttomcu("0306000");'></li>
					    </ul>
					    <ul class="actions">
                            <li><input type="button" value="7 ???" class="button big special" id="bt_0301000" onclick='connecttomcu("0307000");'></li>
                            <li><input type="button" value="8 ???" class="button big special" id="bt_0302000" onclick='connecttomcu("0308000");'></li>
                            <li><input type="button" value="9 ???" class="button big special" id="bt_0303000" onclick='connecttomcu("0309000");'></li>
					    </ul>
					</form>
				</div>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1">
				<header class="major">
					<h2>Mentor BOX ???????????? ???????????? ???????????????.</h2>
					<p>????????? ??? ????????? ???????????????</p>
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
						<li><input type="button" value="???????????????" class="button small special" onclick='javascript:calltomcu("100", "2", "mentor", "1", "192.168.0.220");'></li>
						<li><input type="button" value="Main Url" class="button small special" onclick='javascript:changeUrl();'></li>
						<li><input type="button" value="web on video" class="button small special" onclick='javascript:webUrl();'></li>
						<li><input type="button" value="Local Test" class="button small special" onclick='javascript:calltomcu("100", "2", "mentor", "1", "192.168.0.201");'></li>
                        -->
					</ul>
				</div>
			</footer>

<script type="text/javascript">

var roomList = ["0301000", "0302000", "0303000", "0304000", "0305000", "0306000", "0307000", "0308000", "0309000"];
var roomNameList = ["1 ???", "2 ???", "3 ???", "4 ???", "5 ???", "6 ???", "7 ???", "8 ???", "9 ???"];
// get room uid

function updateRoom() {
    $.post('./mcucomm/mcucomm_121_159_74_222.php', {cmd: 'GetConfList'} )
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
