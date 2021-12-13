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

//    var mainserverip="115.68.14.22";
var serverip="121.159.74.222";

var roomList = ["0321000", "0322000", "0323000"];
var roomNameList = ["1 번", "2 번", "3 번"];

// for load balancing
var roomMixerList = ["mixer", "mixer", "mixer"];
var roomPartList = [0, 0, 0];

// for mixer
var mixerList = [];
var sumOfPart = [];

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

            for (j = 0; j< roomList.length; j++) {
                document.getElementById("bt_"+j).disabled = false;
            }

            for ( var j = 0; j< roomList.length; j++) {
                var findRoom = false;
                for ( var i = 0; i < val.conflist.length; i++ ) {
                    if ( val.conflist[i].did == roomList[j] && parseInt(val.conflist[i].numpart) > 0) {
                        $("#bt_"+j).css("background-color", "#ff6565");       
                        document.getElementById("bt_"+j).value = roomNameList[j] + " (" + val.conflist[i].numpart + 
                            ", " + val.conflist[i].mixer + ")";
                        findRoom = true;
                        
                        roomMixerList[j] = val.conflist[i].mixer;
                        roomPartList[j] = parseInt(val.conflist[i].numpart);
                        break;
                    }
                }
                if ( findRoom == false ) {
                    $("#bt_"+j).css("background-color", "");       
                    document.getElementById("bt_"+j).value = roomNameList[j];
                }

            }

            console.log(roomMixerList);
            console.log(roomPartList);
        }
    );

    setTimeout(() => updateRoom(), 10000);
}

function getMixerList() {
    $.post('../mcutest/mcucomm.php', {mcuip:serverip ,cmd: 'GetMixList'} )
    .done(
        function ( data ) {
            val = eval('(' + data + ')');
            if ( val == null ) {
                console.log("Err");
                return;
            }

            for(var j=0; j<val.mixlist.length; j++) {
                mixerList.push(val.mixlist[j].name);
                sumOfPart[j] = 0;
            }
        }
    );

    console.log("Mixer : ", mixerList);
}

function indexOfSmallest(arr) {
    var lowest = 0;

    if(arr.length == 1)
        return 0;

    for(var i=1; i<arr.length; i++) {
        if(arr[i] < arr[lowest]) lowest = i;
    }
    return lowest;
}

function selectServerForLB(rn) {
    var findroom = false;

    $.post('../mcutest/mcucomm.php', {mcuip:serverip ,cmd: 'GetConfList'} )
    .done(
        function ( data ) {
            val = eval('(' + data + ')');
            if ( val == null ) {
                console.log("Err");
                return;
            }

            console.log(val);

            // init
            for(var j=0; j<sumOfPart.length; j++) {
                sumOfPart[j] = 0;
            }

            // calculate
            for( j=0; j<val.conflist.length; j++) {
                sumOfPart[mixerList.indexOf(val.conflist[j].mixer)] += parseInt(val.conflist[j].numpart);

                if ( val.conflist[j].did == roomList[rn]) {
                    roomMixerList[rn] = val.conflist[j].mixer;   
                    findroom = true;
                }
            }

        }
    );

    setTimeout(function choicesvr() {

        if(findroom == false) {
            roomMixerList[rn] = mixerList[indexOfSmallest(sumOfPart)];
        }

        console.log("Sum of participant : ", sumOfPart);

    }, 1000);
}

function connecttomcu(roomnumber) {
    var form = document.createElement("form");
    form.setAttribute("charset", "UTF-8");
    form.setAttribute("method", "Post");
    form.setAttribute("action", "../mypage/meeting_mentor.php");

    var formField = document.createElement("input");
    formField.setAttribute("type", "text");
    formField.setAttribute("name", "sipnumber");
    formField.setAttribute("value", roomList[roomnumber]);
    form.appendChild(formField);

    var formField1 = document.createElement("input");
    formField1.setAttribute("type", "text");
    formField1.setAttribute("name", "mcuip");
    formField1.setAttribute("value", serverip);
    form.appendChild(formField1);
    
    var formField2 = document.createElement("input");
    formField2.setAttribute("type", "text");
    formField2.setAttribute("name", "servername");

    if(roomPartList[roomnumber] == 0) {
        selectServerForLB(roomnumber);

        setTimeout(function selectsvr() {
                console.log(roomMixerList[roomnumber]);

                formField2.setAttribute("value", roomMixerList[roomnumber]);
                form.appendChild(formField2);

                document.body.appendChild(form);

                form.submit();
            }
        , 1200);
    } else {

        formField2.setAttribute("value", roomMixerList[roomnumber]);
        form.appendChild(formField2);

        document.body.appendChild(form);

        form.submit();
    }
    
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
                        <!--<li><input type"text" id="text_for_debug" value="" style="text-align:right;border:none" readonly></li>-->
						<li><a href="../index.php" class="button special">로그아웃</a></li>
						<li><a href="../mypage/device_test_mentor.php" class="button special">장치설정</a></li>
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
                            <li><input type="button" value="1 번" class="button big special" id="bt_0" disabled="true" onclick='connecttomcu(0);'></li>
                            <li><input type="button" value="2 번" class="button big special" id="bt_1" disabled="true" onclick='connecttomcu(1);'></li>
                            <li><input type="button" value="3 번" class="button big special" id="bt_2" disabled="true" onclick='connecttomcu(2);'></li>
				    	</ul>
					    <ul class="actions">
                            <li><input type="button" value="설문" class="button big special" onclick="location.href='https://survey.flip-on.com'"></li>
                            <li><input type="button" value="Flip on" class="button big special" onclick="location.href='https://flip-on.com'"></li>
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



// sykim 2021.7.22 - MCU load balance
getMixerList();
//setTimeout(() => selectServerForLB(), 500);

setTimeout(() => updateRoom(), 1000);

</script>
	</body>
