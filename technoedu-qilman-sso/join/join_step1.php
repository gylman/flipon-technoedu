<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>
#join > #content1, #content2 { padding:10px 0px; }
#join h3 { padding:5px 0px; }
#join textarea { display:block; width:98%; height:200px; }

#btn_area {	width:360px; height:83px; margin:10px auto; }

</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#step_ok").click(function(){
		
		if ($("input:checkbox:checked").length != 2) {
			alert('모든 약관에 동의해 주세요');
			return;
		}
		
		localStorage.setItem("com.facelink.join.confirm_terms", "1");
		location.href="./join_step2.php";
	});

	$("#step_cancel").click(function(){
		history.back(-1);
	});
	
	localStorage.removeItem("com.facelink.join.confirm_terms");
	localStorage.removeItem("com.facelink.join.user_name");
	localStorage.removeItem("com.facelink.join.user_birth_year");
	localStorage.removeItem("com.facelink.join.user_birth_month");
	localStorage.removeItem("com.facelink.join.user_birth_day");
	localStorage.removeItem("com.facelink.join.user_sex");
});	
</script>

	<!-- 상단 -->
	<div id="sub_top">
		<ul>
			<li class="r1">i-Mentor 멤버쉽</li>
			<li class="r2"><a href="./login.php">로그인</a><a href="join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php" class="sub_select">회원가입</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 회원가입</span></li>
			<li class="r3"><span>회원가입</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
	<font size=4>
	<p>안녕하세요. 본 서비스는 관리자에 의해서만 회원 가입이 가능합니다.
	<br>
	<br>
	<p> 서비스를 이용하고자 하시는 분은 아래 연락처로 전화주시거나 메일을 보내 주시기 바랍니다. 
	</font>

	<br><br>
		<div id="contact">		
			<ul>				
				<li class="addr">대전광역시 유성구 테크노5로 68 우림빌딩 4층 (관평동 774번지)</li>
				<li><span>Tel</span>:070-8763-5000</li>
				<li><span>Fax</span>:042-931-5026</li>
				<li><span>Mail</span>:info@wooksungmedia.com </li>
				<li><span>Homepage</span>:http://www.wooksungmedia.com </li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
