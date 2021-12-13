<?php

/* Check connection to MySQL */
// $DBHOST = "technoedu-mysql";
// $DBUSER = "mentorservice";
// $DBPASSWD = "roskfl";
// $DBNAME = "facelink";
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
// $mysqli = new mysqli($DBHOST, $DBUSER, $DBPASSWD, $DBNAME);
// echo 'MySQL host info: ' . $mysqli->host_info . '\n';
// exit();

/* Check PHP is working */
// echo 'short_open_tag: ' . ini_get('short_open_tag') . '\n';
// phpinfo();
// exit();

?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1, minimum-scale=0,maximum-scale=1.0">
<title>i-Mentor Service</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="./css/basic.css">
<link rel="stylesheet" type="text/css" href="./css/index.css">

<script src="./js/config.js" type="text/javascript"></script>
<script src="./js/common.js" type="text/javascript"></script>
<script src="./js/html5shiv.js" type="text/javascript"></script>
<script src="./js/jquery/jquery-1.11.1.min.js" type="text/javascript"></script>

<script>

// <?php

//  $arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC","SAMSUNG","Android","Windows CE");

// for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {

//  if(strpos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){

//    header("Location: ./index_mobile.php");

//    exit;

//  }

// }

// ?>


$(document).ready(function(){

        var floatPosition = parseInt($(".test").css('top'));
        
        console.log(floatPosition);
		//console.log("test");
        $(window).scroll(function(){
            var scrollTop = $(window).scrollTop();
            var newPosition = scrollTop + floatPosition + "px";

            $(".test").css('top',newPosition);

            $(".test").stop().animate({  
                        "top" : newPosition
            },500);
        }).scroll();
});

$(document).ready(function() {
	$('#btn_reserve').click(function(e) {

        if (g_user_id.length <= 0) {
			location.href = './join/login.php?go=../conference/room_list.php';
		} else {
			location.href = './conference/room_list.php';
		}
    });
	
	var ul_start = "<ul class='notice' data-board_id='";
	var ul_start_end = "'>";
	var ul_li_start = "<li class='subject'>";
	var ul_li_end = "</li>";
	var ul_li_date_start = "<li class='date'>";
	var ul_li_date_end = "</li>";
	var ul_end = "</ul>";
	
	var postJsonData = {
		page : 0,
		limit : 4,
		search_val : ""
	};
	$.post( g_apiUrlRoot+"board_notice_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			
			var list = $("#notice")
			if(dataJson.board.length == 0){
				list.append(
					ul_start
					+ ul_start_end
					+ ul_li_start
					+ "게시물이 없습니다"
					+ ul_li_end
					+ ul_li_date_start
					+ ul_li_date_end
					+ ul_end
				);	
			}
			for(var i=0; i<dataJson.board.length;i++){
				var yyyymmdd = dataJson.board[i].reg_datetime;
				yyyymmdd = yyyymmdd.substring(0, 10);
				list.append(
					ul_start
					+ dataJson.board[i].id
					+ ul_start_end
					+ ul_li_start
					+ dataJson.board[i].title
					+ ul_li_end
					+ ul_li_date_start
					+ yyyymmdd
					+ ul_li_date_end
					+ ul_end
				);
			}
			
		} else {
			//alert('공지사항을 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	$("#notice").on("click","ul",function(){
		var bid = $(this).data("board_id");
		if(bid != ""){
			location.href = "./contact/content.php?type=footer&bid=" + bid;
		}
	});

	$("#3-1").click(function(){
		$("#products > li:nth-child(1)").css("display","block");
		$("#products > li:nth-child(2)").css("display","none");
	});	

	$("#3-2").click(function(){
		$("#products > li:nth-child(1)").css("display","none");
		$("#products > li:nth-child(2)").css("display","block");
	});	

});


$(document).ready(function() {
	$('#btn_imentor').click(function(e) {
		
        if (g_user_id.length <= 0) {
			location.href = './join/login.php';
		} else {
				if (g_user_part.length > 0) {
                    if (g_user_part == "038")
					    location.href = "web200h/index2.html";
                    else if (g_user_part == "livedu")
					    location.href = "web200h/index_livedu.php";
                    else if (g_user_part == "cuop")
					    location.href = "web200h/index_cuop.php";
                    else if (g_user_part == "wsv")
					    location.href = "web200h/index_wsv.php";
                    else if (g_user_part == "hanbat")
					    location.href = "web200h/index_hanbat.php";
                    else if (g_user_part == "sejong")
					    location.href = "web200h/index_sejong.php";
                    else if (g_user_part == "ocean")
					    location.href = "web200h/index_ocean.php";
                    else if (g_user_part == "wooksung")
					    location.href = "web200h/index_test.php";
                    else if (g_user_part == "djtp")
					    location.href = "web200h/index_test.php";
                    else if (g_user_part == "raon")
					    location.href = "web200h/index_raon.php";
                    else if (g_user_part == "jacklist")
					    location.href = "web200h/index_jacklist_jpn.php";
                    else if (g_user_part == "flipon")
					    location.href = "web200h/index_snu.php";
                    else if (g_user_part == "yuseong")
					    location.href = "../web200h/index_yuseong.php";
                    else if (g_user_part == "demo")
					    location.href = "../web200h/index_demo.php";
                    else if (g_user_part == "technoangel")
					    location.href = "../web200h/index_technoangel.php";
                    else if (g_user_part == "mginnovation")
					    location.href = "../web200h/index_mg.php";
                    else if (g_user_part == "koreaoptron")
					    location.href = "../web200h/index_koreaoptron.php";
                    else if (g_user_part == "ddoruroo")
					    location.href = "../web200h/index_ddoruroo.php";
                    else if (g_user_part == "numero")
					    location.href = "../web200h/index_numero.php";
                    else if (g_user_part == "saenal")
					    location.href = "../web200h/index_saenaltt.php";
                    else if (g_user_part == "jjgg")
					    location.href = "../web200h/index_jjgg.php";
                    else if (g_user_part == "dyrnt")
					    location.href = "../web200h/index_dyrnt.php";
                    else if (g_user_part == "feelie")
					    location.href = "../web200h/index_feelie.php";
                    else if (g_user_part == "djcoffee")
					    location.href = "../web200h/index_djcoffee.php";
                    else if (g_user_part == "rodeo")
					    location.href = "../web200h/index_rodeo.php";
                    else if (g_user_part == "somfic")
					    location.href = "../web200h/index_somfic.php";
                    else if (g_user_part == "djttoo")
					    location.href = "../web200h/index_djttoo.php";
                    else if (g_user_part == "cbinnobiz")
					    location.href = "../web200h/index_cbinnobiz.php";
                    else if (g_user_part == "knrea")
					    location.href = "../web200h/index_knrea.php";
                    else if (g_user_part == "kchinese")
					    location.href = "../web200h/index_kchinese.php";
                    else if (g_user_part == "kmpc")
					    location.href = "../web200h/index_kmpc.php";
                    else if (g_user_part == "sw")
					    location.href = "../web200h/index_sw.php";
                    else if (g_user_part == "eirlab")
					    location.href = "../web200h/index_eirlab.php";
                    else if (g_user_part == "apexint")
					    location.href = "../web200h/index_apexint.php";
                    else if (g_user_part == "ms")
					    location.href = "../web200h/index_ms.php";
                    else if (g_user_part == "dankook")
					    location.href = "../web200h/index_dankook.php";
                    else if (g_user_part == "dju")
					    location.href = "../web200h/index_dju.php";
                    else if (g_user_part == "zeniton")
					    location.href = "../web200h/index_zeniton.php";
                    else if (g_user_part == "samin")
					    location.href = "../web200h/index_samin.php";
                    else if (g_user_part == "softtool")
					    location.href = "../web200h/index_softtool.php";
                    else if (g_user_part == "kongju")
					    location.href = "../web200h/index_kongju.php";
                    else if (g_user_part == "joongbu")
					    location.href = "../web200h/index_joongbu.php";
                    else if (g_user_part == "wbiz")
					    location.href = "../web200h/index_wbiz.php";
                    else if (g_user_part == "ksca")
					    location.href = "../web200h/index_ksca.php";
                    else if (g_user_part == "hanbatlinc")
					    location.href = "../web200h/index_hanbatlinc.php";
                    else if (g_user_part == "kca")
					    location.href = "../web200h/index_kca.php";
                    else if (g_user_part == "jteceng")
					    location.href = "../web200h/index_jteceng.php";
                    else if (g_user_part == "softonnet")
					    location.href = "../web200h/index_softonnet.php";
                    else if (g_user_part == "bizstrategy")
					    location.href = "../web200h/index_bizstrategy.php";
                    else if (g_user_part == "baraq")
					    location.href = "../web200h/index_baraq.php";
                    else if (g_user_part == "furim")
					    location.href = "../web200h/index_furim.php";
                    else if (g_user_part == "djba")
					    location.href = "../web200h/index_djba.php";
                    else if (g_user_part == "diva")
					    location.href = "../web200h/index_diva.php";
                    else if (g_user_part == "hihip")
					    location.href = "../web200h/index_hihip.php";
                    else if (g_user_part == "environ")
					    location.href = "../web200h/index_environ.php";
                    else if (g_user_part == "hanjin")
					    location.href = "../web200h/index_hanjin.php";
                    else if (g_user_part == "worlde")
					    location.href = "../web200h/index_worlde.php";
                    else if (g_user_part == "floor")
					    location.href = "../web200h/index_floor.php";
                    else if (g_user_part == "gaon")
					    location.href = "../web200h/index_gaon.php";
                    else if (g_user_part == "ecobio")
					    location.href = "../web200h/index_ecobio.php";
                    else if (g_user_part == "hoon")
					    location.href = "../web200h/index_hoon.php";
                    else if (g_user_part == "arte")
					    location.href = "../web200h/index_arte.php";
                    else if (g_user_part == "seiga")
					    location.href = "../web200h/index_seiga.php";
                    else if (g_user_part == "modutech")
					    location.href = "../web200h/index_modutech.php";
                    else if (g_user_part == "cure")
					    location.href = "../web200h/index_cure.php";
                    else if (g_user_part == "icurebnp")
					    location.href = "../web200h/index_icurebnp.php";
                    else if (g_user_part == "ondam")
					    location.href = "../web200h/index_ondam.php";
                    else if (g_user_part == "amore")
					    location.href = "../web200h/index_amore.php";
                    else if (g_user_part == "semicolon")
					    location.href = "../web200h/index_semicolon.php";
                    else if (g_user_part == "sungyi")
					    location.href = "../web200h/index_sungyi.php";
                    else if (g_user_part == "dasoleng")
					    location.href = "../web200h/index_dasoleng.php";
                    else if (g_user_part == "jthree")
					    location.href = "../web200h/index_jthree.php";
                    else if (g_user_part == "wdb")
					    location.href = "../web200h/index_wdb.php";
                    else if (g_user_part == "uni")
					    location.href = "../web200h/index_uni.php";
                    else if (g_user_part == "mirtech")
					    location.href = "../web200h/index_mirtech.php";
                    else if (g_user_part == "woomin")
					    location.href = "../web200h/index_woomin.php";
                    else if (g_user_part == "ideaplant")
					    location.href = "../web200h/index_ideaplant.php";
                    else if (g_user_part == "mysis")
					    location.href = "../web200h/index_mysis.php";
                    else if (g_user_part == "market")
					    location.href = "../web200h/index_market.php";
                    else if (g_user_part == "djpshs")
					    location.href = "../web200h/index_djpshs.php";
                    else if (g_user_part == "krdhs")
					    location.href = "../web200h/index_krdhs.php";
                    else if (g_user_part == "plant")
					    location.href = "../web200h/index_plant.php";
                    else if (g_user_part == "plastic")
					    location.href = "../web200h/index_plastic.php";
                    else if (g_user_part == "ksa")
					    location.href = "../web200h/index_ksa.php";
                    else if (g_user_part == "hanbatiucf")
					    location.href = "../web200h/index_hanbatiucf.php";
                    else if (g_user_part == "sejongcenter")
					    location.href = "../web200h/index_sejongcenter.php";
                    else if (g_user_part == "induk")
					    location.href = "../web200h/index_induk.php";
                    else if (g_user_part == "aromahands")
					    location.href = "../web200h/index_aromahands.php";
                    else
					    location.href = "../company/service.php";
				} else {
					location.href = "../company/service.php";
				}
		}
    });
});

</script>

</head>
<body>

<div id="wrap">
	<header id="header">
		<ul id="gnb">
			<li class="logo"><a href="/"><img class="sub_logo" src="../images/sub_logo.png"></a></li>
			<li class="main_gnb">
				<ul>
					<!--<li><a href="../web200h/index_test.php"><img src="../images/gnb1.png"></a></li>-->
					<li><a id="btn_imentor" href="#"><img class="i_mentor_button" src="../images/gnb1.png"></a></li>
					<li><a id="btn_reserve" href="#"><img class="reserve_button"src="../images/gnb2.png"></a></li>
					<li><a href="../company/service.php"><img class="service_button" src="../images/gnb3.png"></a></li>
					<li><a href="../company/contact.php"><img class="contact_button" src="../images/gnb4.png"></a></li>
				</ul>
			</li>
			<li class="top_gnb">
				<ul>
					<li class="login"><a href="../join/login.php"><img class="login_button" src="../images/med1.png"></a></li>
                    <li class="logout"><a href="javascript:logout();"><img class="logout_button" src="../images/logout.png"></a></li>
					<li class="join"><a href="../join/join_step1.php"><img class="join_button" src="../images/med2.png"></a></li>
					<li class="mypage"><a href="../mypage/meeting_list.php"><img class="mypage_button" src="../images/med3.png"></a></li>
					<!--li class="fb"><a href="#" target="_blank"><img src="../images/med4.png"></a></li-->
				</ul>
			</li>
		</ul>
		<div class="banner">
			<ul class="banner-list">
				<li class="list-1"><img src="./images/banner1.jpg"></li>
				<!-- <li class="list-2" style="display:none;"><img src="./images/banner1.jpg"></li>
				<li class="list-3" style="display:none;"><img src="./images/banner1.jpg"></li> -->
			</ul>
		</div>
        <div class="test">
			<!-- <li class="logo1"><img src="../images/wooksung4_banner.png" onclick="javascript:newin=window.open('about:blank'); newin.location.href='https://www.k-voucher.kr/search.html?input-search=%EC%9A%B1%EC%84%B1%EB%AF%B8%EB%94%94%EC%96%B4';"></li> -->
			<li class="logo2"><img src="../images/wooriyo_banner3.png" onclick="javascript:newin=window.open('about:blank'); newin.location.href='http://www.pinpl.biz/voucher.jsp';"></li>
        </div>
	</header>	
	<section id="container">
	<div  id="margin">i</div>
		<div id="company">
			<ul id="pyo">
				<li class="r1">i-Mentor Service</li>
				<li class="r2"><a href="./company/service.php">서비스 소개</a><a href="./company/aboutus.php">회사소개</a><a href="./company/contact.php">Contact</a></li>
				<li class="r3">
					<p id="text0">“i-Mentor는 언제 어디서나 우리를 하나로 이어줍니다.”</p>
					<p id="text1">i-Mentor Service는 HTML5기반 영상협업 솔루션으로 욱성미디어가 개발한 다자간 화상 교육 시스템을 통하여 PC, 타블렛, 스마트 폰의 HTML5를 지원하는 웹 브라우저에서 아무런 플러그인 설치 없이 교육이 가능합니다. </p>
					<p id="text2">또한 i-Mentor H/W 단말과 표준 영상회의 장비와 호환 가능한 제품으로 고화질의 영상과 고품질의 음성으로 언제, 어디서나 온라인 화상 교육이 가능합니다. . i-Mentor Service는 여러분들이 다자간 교육시 필요한 시간과 비용을 줄여드리고, 생산성과 효율성 증대에 많은 도움을 줄 것입니다.</p>
				</li>				
			</ul>
			<div id="pyo_img"><img class="facelink1" src="./images/facelink1.png" width=380 height=250 ></div>
		</div>
		<ul id="products">
		<li>
			<ul id="pyo">
				<li class="r1">PRODUCTS</li>
				<li class="r2"><a class="select_menu">화상교육서비스소개</a><a id="3-2">화상단말기소개</a></li>
				<li class="r3">
					<p id="text3">"HTML5 Based Video Education Service"</p>
					<p id="text4">오늘날 정보통신산업의 비약적인 발전에 따라 네트워크에 연결하여 사용할 수 있는 기기들이 PC뿐 아니라 스마트 패드, 스마트 폰, DID, 스마트 카 등으로 여러 종류의 제품들이 출시되고 있습니다.</p> <p id="text4_1">이러한 기기들을 하나의 협업 시스템으로 묶어서 동작 시키기에는 사용자가 일일이 어플리케이션을 설치하고 세팅을 해야 하는 등의 불편함과 사용하기 까지 의 시간이 오래 걸리는 문제가 있습니다. <BR><BR></p>
     <p id="text5">욱성미디어의 i-Mentor Service는 HTML5 기반의 환경에서 동작할 수 있는 환경을 제공하여 이러한 문제점들을 해결하는 차세대 영상 협업 서비스입니다. i-Mentor Service는 HTML5기반의 환경에서 실행되어 플러그인 프로그램이나 기타 어플리케이션이 필요하지 않고 현재 나와 있는 수 많은 스마트 디바이스 환경을 지원합니다. 또한 웹 환경의 서비스를 통하여 가장 간편하고 신속하게 협업 공간을 만들고 사람들을 연결하여 화상 교육을 진행 할 수 있으며 기존 영상회의 시스템과도 연결이 가능합니다.<BR><BR>
     i-Mentor 제품은 기업, 관공서, 학교 등에서 스마트워크, 다자간 회의, 스마트 교육등에 활용될 수 있으며 이 외에 다양한 분야에 활용할 수 있습니다. 이제 여러분들은 i-Mentor Service를 활용하여 다양한 분야에서 여러 사람들과 온라인으로 쉽고 빠르게 만날 수 있습니다. </p>
				</li>				
			</ul>
			<p id="pyo_img"><img class="products1" src="../images/products1.png"></p>
		</li>
		<li>
			<ul id="pyo">
				<li class="r1">PRODUCTS</li>
				<li class="r2"><a id="3-1">화상교육서비스소개</a><a class="select_menu">화상단말기소개</a></li>
				<li class="r3_1">							
					<p id="text3">"iMentor WEB-100"</p>
					<p id="text6">(주)욱성 미디어에서는 보다 전문적인 화상 회의와 교육을 위해 화상 회의 전용 단말기인 
					iMentor  WEB-100을 제공합니다. 이 단말기는 HD급의 고화질 영상을 제공하며 고감도 
					마이크를 이용하여 큰 회의실이나 강의실에서 사용할 때 화자가 멀리 떨어져 있어도 고품질의 
					음성을 전달 할 수 있습니다.<BR></p>
					<p id="text7">또한 외부입력으로 PC입력 사용하여 영상을 전송하여 프리젠테이션을 할 수 있고 고성능 
					PTZ카메라 등에 연결 하여 사용 할 수 있습니다. 이 단말기를 통하여 쉽게 영상 회의에 참여
					할 수 있을 뿐 아니라 타 장비와 영상 통화를 할 수 있습니다. </p>
					
					<p id="text8">iMentor WEB-100은 기업의 
					다자간 회의, 세미나 및 강연, 원격 교육 등 다양한 분야에서 활용 가능합니다. 
					
					<BR><BR>
					- 모델 : iMentor WEB-100<BR>
					- 구성: H/W 코덱박스, HD카메라, 고감도 마이크, 리모컨<BR>
					- 국제표준규격 SIP 프로토콜 (RFC3261) 지원<BR>
					- 비디오 : H.264 코덱, 30fps/720P<BR>
					- 오디오 : G.711-A, G.711-u, G.722, Full Duplex <BR></p>
				</li>				
			</ul>
			<p id="pyo_img"><img class="products4" src="../images/products2.png"></p>

		</li>
	</ul>		
	</section>
	<footer id="footer">
		<ul>
			<li id="footer_blk">&nbsp; </li>
			<li id="contact">
				<P class="tit">CONTACT INFORMATION</P>
				<p class="add">305-509<BR>
				
				대전광역시 유성구 테크노2로 340 2층<BR>
				Tel : 042-931-5025 (직통:070-7729-7034)<BR>
				Fax : 042-931-5026<BR></p>
			</li>
			<li id="cs">
				<P class="tit">CS CENTER</P>
				<P class="tel">042-931-5025</P>
				<p class="time">월요일~금요일 AM 09:00~PM 06:00<BR>
				(토,일요일 및 공휴일은 휴무입니다.)<p>
			</li>
			<li id="notice">
				<P class="tit">NOTICE</P>
			</li>
			<li class="icon"><a></a><a></a><a></a><a></a></li>
		</ul>
		<p> COPYRIGHT(C) WOOKSUNG MEDIA CO., LTD. ALL RIGHTS RESERVED.</p>
	</footer>
</div>
</body>


<script type="text/javascript">
var quickName = '.quick';

$(document).ready(function() {
	/*
	$('body').attr({
		"data-spy": "scroll",
		"data-target": "#scroll-spy"
	});
	
	
    var menuYloc = parseInt($(quickName).css("top").substring(0,$(quickName).css("top").indexOf("px")));
    var menuYlocBottom = $(document).height() - 770;
    var scrollSkipTop = menuYloc - $(window).height() * 0.6;
    var scrollSkipBottom = menuYlocBottom+scrollSkipTop - 840;
    //alert(windowHeight);
    $(window).scroll(function () { 
        var scrollTop = $(document).scrollTop();
        if ((scrollSkipTop < scrollTop) && (scrollSkipBottom > scrollTop)) {
	    	var offset = menuYloc+scrollTop-scrollSkipTop+"px";
	        
	        $(quickName).animate({top:offset},{duration:500,queue:false});
        } else if (scrollSkipTop >= scrollTop) {
        	$(quickName).animate({top:menuYloc},{duration:500,queue:false});
        } else {
        	$(quickName).animate({top:menuYlocBottom},{duration:500,queue:false});
        }
    });

	$('#_iosDown').click(function(e) {
		window.open("https://itunes.apple.com/kr/app/yeoldusi-neibeokupon/id660982546?l=ko&ls=1&mt=8");
		
		e.preventDefault();
	});
	$('#_androidDown').click(function(e) {
		window.open("https://play.google.com/store/apps/details?id=com.campmobile.noon");
		
		e.preventDefault();
	});
	*/

    


	var $slidings = $('ul.slidings');
	var $banners = $('ul.banner-list');
	
	//var slidingsSize = $slidings.children().outerWidth();
	var slidingsLen =  $slidings.children().length;
	var bannersLen =  $banners.children().length;
	var speed = 4000;
	var auto = true;
	
	var slidingsTimer = null;
	var bannersTimer = null;
	var slidingsCnt = 1;
	var bannersCnt = 1;

	//$slidings.css('width',slidingsLen*slidingsSize);

	if(auto) {
		slidingsTimer = setInterval(autoSlide, speed);
		bannersTimer = setInterval(autoSlideBanners, speed);
	}

	$slidings.children().bind({
		'mouseenter': function(){
			if(!auto) return false;
			clearInterval(slidingsTimer);
			auto = false;
		},
		'mouseleave': function(){
			slidingsTimer = setInterval(autoSlide, speed);
			auto = true;
		}
	});
	
	$('.preview .pagenation').children().bind({
		'click': function(e){
			var idx = $('.preview .pagenation').children().index(this);
			slidingsCnt = idx;
			autoSlide();
			e.preventDefault();
		},
		'mouseenter': function(){
			if(!auto) return false;
			clearInterval(slidingsTimer);
			auto = false;
		},
		'mouseleave': function(){
			slidingsTimer = setInterval(autoSlide, speed);
			auto = true;
		}
	});
	$('.banner .pagenation').children().bind({
		'click': function(e){
			var idx = $('.banner .pagenation').children().index(this);
			bannersCnt = idx;
			autoSlideBanners();
			e.preventDefault();
		},
		'mouseenter': function(){
			if(!auto) return false;
			clearInterval(bannersTimer);
			auto = false;
		},
		'mouseleave': function(){
			bannersTimer = setInterval(autoSlideBanners, speed);
			auto = true;
		}
	});

	function autoSlide(){
		if(slidingsCnt>slidingsLen-1){
			slidingsCnt = 0;
		}

		$('.preview .pagenation').children().removeClass('on');
		$('.preview .pagenation').children().eq(slidingsCnt).addClass('on');

		$slidings.children().eq(slidingsCnt).show();
		$slidings.children().not(":eq(" + slidingsCnt + ")").hide();
		slidingsCnt++;
	}

	function autoSlideBanners(){
		if(bannersCnt>bannersLen-1){
			bannersCnt = 0;
		}

		$('.banner .pagenation').children().removeClass('on');
		$('.banner .pagenation').children().eq(bannersCnt).addClass('on');

		$banners.children().eq(bannersCnt).show();
		$banners.children().not(":eq(" + bannersCnt + ")").hide();
		bannersCnt++;
	}
	
	// login check
	checkLogin();
});
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42792218-2', 'auto');
  ga('send', 'pageview');

</script>
</html> 
