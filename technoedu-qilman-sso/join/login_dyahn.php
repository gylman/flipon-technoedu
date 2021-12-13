<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>
#join { }
#join > img { display:block; margin:0px auto; }
#join > #login { width:500px; margin:0px auto; color:#747474; }
#login ul { width:100%; }
#login ul li { display:block; line-height:40px; }

#login ul > li { clear:both; padding-top:10px; }
#login ul > li > span { display:block; float:left; }
#login ul > li > span:first-child { width:150px; }
#login ul > li > span:last-child { width:100%; }
#login ul > li > span:last-child > input[type=text],
#login ul > li > span:last-child > input[type=password] { width:100%; }

#btn_area {	width:220px; height:83px; margin:10px auto; }

.id_find {	
	float:left;
	width:220px;
	height:26px;
	border:0px;
	background:url("../../images/b_login_idfind.png") 0 0 no-repeat;	
}

.join {	
	float:right;
	width:220px;
	height:26px;
	border:0px;
	background:url("../../images/b_login_join.png") 0 0 no-repeat;
}

#common_btn_area > #btn_guest { float:left; }
#common_btn_area > #btn_login { float:right; }


/* 팝업창 - 친구관리 : 쪽지 보내기 */
#guest_login { position:absolute; display:none; left:50%; top:50%; margin-left:-200px; margin-top:-260px; width:400px; height:200px; background:white; border:1px solid #454545; }
#guest_login > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#guest_login > p > span { float:right; margin:0px; padding:0px; }
#guest_login > p > span > img { padding-top:6px; cursor:pointer; }
#guest_login > p.input_name { padding:20px; }
#guest_login > p.input_name > .guest_name  { height:30px; margin:0px auto; border:1px solid #c4c4c4; }

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
				if (g_rtUrl.length <= 0) {
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
	<!--div id="sub_top">
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
                <a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > i-Mentor > 로그인</span></li>
			<li class="r3"><span>로그인</span></li>
		</ul>		
	</div-->

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
			<img src="../../images/login_tit.png">
			<form id="login" name="login" method="post">
            <ul>
				<li><span>User ID / E-mail: </span><span><input id="id_email" type="text" maxlength="255"></li>
				<li><span>Password : </span><span><input id="password" type="password" maxlength="16" onkeydown="if (event.keyCode == 13) document.getElementById('step_ok').click()"></li>
				<li>* i-Mentor Service의 모든 기능을 사용하시려면 회원가입이 필요합니다. </li>
				<li id="common_btn_area" style="width:300px;">
					<input type="button" id="btn_idfind" class="btn_small gray" value="아이디/비밀번호 찾기">
					<input type="button" id="btn_join2" class="btn_small gray" value="회원가입">
				</li>
			</ul>
			<div id="common_btn_area" style="width:380px;">
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
