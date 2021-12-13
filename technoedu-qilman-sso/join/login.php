<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>

body,html{
	margin:0;
	padding:0;
	width:100%;
	height:100%;
}


</style>

<script type="text/javascript">

var g_rtUrl = '';

$(document).ready(function() {
	
	$('#btn_idfind').click(function() {
		location.href="./join_find.php";	
	});

	$('#btn_join').click(function() {
		location.href="./join_step1.php"; 
	});
	$('#btn_join2').click(function() {
		location.href="./join_step1.php"; 
	});
	
	$('#step_ok').click(function(e) {
        var postJsonData = {
			id_email : $('#id_email').val(),
			user_pw : $('#password').val(),
			keep : $('#keep').is(':checked') == true ? 1 : 0
		};
		
		$.post( g_apiUrlRoot+"login.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {

                /*
				if (g_rtUrl.length <= 0) {
					location.href = "/";
				} else {
					location.href = g_rtUrl;
				}
                */
            
				if (g_rtUrl.length <= 0) {
                
                    if (dataJson.part == "038")
					    location.href = "../web200h/index2.html";
                    else if (dataJson.part == "livedu")
					    location.href = "../web200h/index_livedu.php";
                    else if (dataJson.part == "wsv")
					    location.href = "../web200h/index_wsv.php";
                    else if (dataJson.part == "cuop")
					    location.href = "../web200h/index_cuop.php";
                    else if (dataJson.part == "hanbat")
					    location.href = "../web200h/index_hanbat.php";
                    else if (dataJson.part == "sejong")
					    location.href = "../web200h/index_sejong.php";
                    else if (dataJson.part == "ocean")
					    location.href = "../web200h/index_ocean.php";
                    else if (dataJson.part == "wooksung")
					    location.href = "../web200h/index_test.php";
                    else if (dataJson.part == "raon")
					    location.href = "../web200h/index_raon.php";
                    else if (dataJson.part == "jacklist")
					    location.href = "../web200h/index_jacklist_jpn.php";
                    else if (dataJson.part == "flipon")
					    location.href = "../web200h/index_snu.php";
                    else if (dataJson.part == "dst")
					    location.href = "../web200h/index_test.php";
                    else if (dataJson.part == "azwell")
					    location.href = "../web200h/index_azwell.php";
                    else if (dataJson.part == "demo")
					    location.href = "../web200h/index_demo.php";
                    else if (dataJson.part == "technoangel")
					    location.href = "../web200h/index_technoangel.php";
                    else if (dataJson.part == "mginnovation")
					    location.href = "../web200h/index_mg.php";
                    else if (dataJson.part == "koreaoptron")
					    location.href = "../web200h/index_koreaoptron.php";
                    else if (dataJson.part == "ddoruroo")
					    location.href = "../web200h/index_ddoruroo.php";
                    else if (dataJson.part == "numero")
					    location.href = "../web200h/index_numero.php";
                    else if (dataJson.part == "saenal")
					    location.href = "../web200h/index_saenaltt.php";
                    else if (dataJson.part == "jjgg")
					    location.href = "../web200h/index_jjgg.php";
                    else if (dataJson.part == "dyrnt")
					    location.href = "../web200h/index_dyrnt.php";
                    else if (dataJson.part == "feelie")
					    location.href = "../web200h/index_feelie.php";
                    else if (dataJson.part == "djcoffee")
					    location.href = "../web200h/index_djcoffee.php";
                    else if (dataJson.part == "rodeo")
					    location.href = "../web200h/index_rodeo.php";
                    else if (dataJson.part == "somfic")
					    location.href = "../web200h/index_somfic.php";
                    else if (dataJson.part == "djttoo")
					    location.href = "../web200h/index_djttoo.php";
                    else if (dataJson.part == "cbinnobiz")
					    location.href = "../web200h/index_cbinnobiz.php";
                    else if (dataJson.part == "knrea")
					    location.href = "../web200h/index_knrea.php";
                    else if (dataJson.part == "kchinese")
					    location.href = "../web200h/index_kchinese.php";
                    else if (dataJson.part == "kmpc")
					    location.href = "../web200h/index_kmpc.php";
                    else if (dataJson.part == "sw")
					    location.href = "../web200h/index_sw.php";
                    else if (dataJson.part == "eirlab")
					    location.href = "../web200h/index_eirlab.php";
                    else if (dataJson.part == "apexint")
					    location.href = "../web200h/index_apexint.php";
                    else if (dataJson.part == "ms")
					    location.href = "../web200h/index_ms.php";
                    else if (dataJson.part == "dankook")
					    location.href = "../web200h/index_dankook.php";
                    else if (dataJson.part == "dju")
					    location.href = "../web200h/index_dju.php";
                    else if (dataJson.part == "zeniton")
					    location.href = "../web200h/index_zeniton.php";
                    else if (dataJson.part == "samin")
					    location.href = "../web200h/index_samin.php";
                    else if (dataJson.part == "softtool")
					    location.href = "../web200h/index_softtool.php";
                    else if (dataJson.part == "kongju")
					    location.href = "../web200h/index_kongju.php";
                    else if (dataJson.part == "joongbu")
					    location.href = "../web200h/index_joongbu.php";
                    else if (dataJson.part == "wbiz")
					    location.href = "../web200h/index_wbiz.php";
                    else if (dataJson.part == "ksca")
					    location.href = "../web200h/index_ksca.php";
                    else if (dataJson.part == "hanbatlinc")
					    location.href = "../web200h/index_hanbatlinc.php";
                    else if (dataJson.part == "kca")
					    location.href = "../web200h/index_kca.php";
                    else if (dataJson.part == "jteceng")
					    location.href = "../web200h/index_jteceng.php";
                    else if (dataJson.part == "softonnet")
					    location.href = "../web200h/index_softonnet.php";
                    else if (dataJson.part == "bizstrategy")
					    location.href = "../web200h/index_bizstrategy.php";
                    else if (dataJson.part == "baraq")
					    location.href = "../web200h/index_baraq.php";
                    else if (dataJson.part == "furim")
					    location.href = "../web200h/index_furim.php";
                    else if (dataJson.part == "djba")
					    location.href = "../web200h/index_djba.php";
                    else if (dataJson.part == "diva")
					    location.href = "../web200h/index_diva.php";
                    else if (dataJson.part == "hihip")
					    location.href = "../web200h/index_hihip.php";
                    else if (dataJson.part == "environ")
					    location.href = "../web200h/index_environ.php";
                    else if (dataJson.part == "hanjin")
					    location.href = "../web200h/index_hanjin.php";
                    else if (dataJson.part == "worlde")
					    location.href = "../web200h/index_worlde.php";
                    else if (dataJson.part == "floor")
					    location.href = "../web200h/index_floor.php";
                    else if (dataJson.part == "gaon")
					    location.href = "../web200h/index_gaon.php";
                    else if (dataJson.part == "ecobio")
					    location.href = "../web200h/index_ecobio.php";
                    else if (dataJson.part == "hoon")
					    location.href = "../web200h/index_hoon.php";
                    else if (dataJson.part == "arte")
					    location.href = "../web200h/index_arte.php";
                    else if (dataJson.part == "seiga")
					    location.href = "../web200h/index_seiga.php";
                    else if (dataJson.part == "modutech")
					    location.href = "../web200h/index_modutech.php";
                    else if (dataJson.part == "cure")
					    location.href = "../web200h/index_cure.php";
                    else if (dataJson.part == "icurebnp")
					    location.href = "../web200h/index_icurebnp.php";
                    else if (dataJson.part == "ondam")
					    location.href = "../web200h/index_ondam.php";
                    else if (dataJson.part == "amore")
					    location.href = "../web200h/index_amore.php";
                    else if (dataJson.part == "semicolon")
					    location.href = "../web200h/index_semicolon.php";
                    else if (dataJson.part == "sungyi")
					    location.href = "../web200h/index_sungyi.php";
                    else if (dataJson.part == "dasoleng")
					    location.href = "../web200h/index_dasoleng.php";
                    else if (dataJson.part == "jthree")
					    location.href = "../web200h/index_jthree.php";
                    else if (dataJson.part == "wdb")
					    location.href = "../web200h/index_wdb.php";
                    else if (dataJson.part == "uni")
					    location.href = "../web200h/index_uni.php";
                    else if (dataJson.part == "mirtech")
					    location.href = "../web200h/index_mirtech.php";
                    else if (dataJson.part == "woomin")
					    location.href = "../web200h/index_woomin.php";
                    else if (dataJson.part == "ideaplant")
					    location.href = "../web200h/index_ideaplant.php";
                    else if (dataJson.part == "mysis")
					    location.href = "../web200h/index_mysis.php";
                    else if (dataJson.part == "market")
					    location.href = "../web200h/index_market.php";
                    else if (dataJson.part == "djpshs")
					    location.href = "../web200h/index_djpshs.php";
                    else if (dataJson.part == "krdhs")
					    location.href = "../web200h/index_krdhs.php";
                    else if (dataJson.part == "plant")
					    location.href = "../web200h/index_plant.php";
                    else if (dataJson.part == "plastic")
					    location.href = "../web200h/index_plastic.php";
                    else if (dataJson.part == "ksa")
					    location.href = "../web200h/index_ksa.php";
                    else if (dataJson.part == "hanbatiucf")
					    location.href = "../web200h/index_hanbatiucf.php";
                    else if (dataJson.part == "sejongcenter")
					    location.href = "../web200h/index_sejongcenter.php";
                    else if (dataJson.part == "induk")
					    location.href = "../web200h/index_induk.php";
                    else if (dataJson.part == "aromahands")
					    location.href = "../web200h/index_aromahands.php";
                    else
                        location.href = "/";


				} else {
					location.href = g_rtUrl;
				}

			} else {
				alert('죄송합니다\n로그인하지 못했습니다\n정보를 확인 후 다시 로그인해 주세요');
			}
		}, "json");
		
		return false;
    });
	
	/* Guest login */
	$("#btn_guest").click(function(){ $("#guest_login").show(); });
	$("#guest_login #close").click(function(){ $("#guest_login").hide(); });
	
	$('#btn_guest_login_ok').click(function(e) {
		
		if ($('#input_guest_name').val().length <= 0) {
			alert('이름을 입력해주세요');
			return false;
		}
		
		var postJsonData = {
			guest_name : $('#input_guest_name').val()
		};
        $.post( g_apiUrlRoot+"login.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				if (g_rtUrl.length <= 0) {
					location.href = "/";
				} else {
					location.href = g_rtUrl;
				}
			} else {
				alert('죄송합니다\n로그인하지 못했습니다\n정보를 확인 후 다시 로그인해 주세요');
			}
		}, "json");
    });
	
	g_rtUrl = getParameter('go');
});
</script>
	<div id="sub_top">
		<ul>
			<li class="r1">i-Mentor 멤버쉽</li>
			<li class="r2">
<?
if (!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])) {
?>
            	<a href="./login.php" class="sub_select">로그인</a><a href="./join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a>
<?
} else {
?>
                <a href="./join_edit.php">회원정보</a>
<?
}
?>
                <a href="./condition.php">이용약관</a><a class="policy" href="./policy.php">개인정보취급방침</a><span class="path">HOME > i-Mentor > 로그인</span></li>
			<li class="r3"><span>로그인</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
			<img class="login_tit" src="../../images/login_tit.png">
			<form id="login" name="login" method="post">
            <ul>
				<li><span>User ID / E-mail: </span><span><input id="id_email" type="text" maxlength="255"></li>
				<li><span>Password : </span><span><input id="password" type="password" maxlength="16" onkeydown="if (event.keyCode == 13) document.getElementById('step_ok').click()"></li>
				<li class="login_text">* i-Mentor Service의 모든 기능을 사용하시려면 회원가입이 필요합니다. </li>
				<li id="common_btn_area">
					<input type="button" id="btn_idfind" class="btn_small gray" value="아이디/비밀번호 찾기">
					<input type="button" id="btn_join2" class="btn_small gray" value="회원가입">
				</li>
			</ul>
			<div id="common_btn_area" >
            	<!--<input type="button" value="Guest 로그인" id="btn_guest" class="btn_big blue">-->
				<input id="btn_join" type="button" class="btn_big blue" value="회원가입">
				<input id="step_ok" type="button" class="btn_big blue" value="로그인">
			</div>
            
            <!-- 팝업창 : Guest 로그인 -->
			<div id="guest_login">
				<p class="subject">Guest 로그인<span><img src="../images/close.png" id="close"></span></p>
				<p class="input_name"><input id="input_guest_name" type="text" size="50" placeholder="이름을 입력해 주세요." class="guest_name"></p>
					<p id="common_btn_area" style="width:200px; ">
						<input id="btn_guest_login_ok" type="button" value="확인" class="btn_small blue">
						<input type="button" value="취소" id="close" class="btn_small darkgray">
					</p>
				</ul>
			</div>
			<!-- 팝업창 : Guest 로그인 -->
			</form>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
