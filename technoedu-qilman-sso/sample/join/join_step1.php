<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

<style>
#join > #content1, #content2 { padding:10px 0px; }
#join h3 { padding:5px 0px; }
#join textarea { display:block; width:98%; height:200px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#step_ok").click(function(){
		location.href="./join_step2.php";
	});

	$("#step_cancel").click(function(){
		history.back(-1);
	});
});	
</script>

	<!-- 상단 -->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 멤버쉽</li>
			<li class="r2"><a href="./login.php">로그인</a><a href="join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php" class="sub_select">회원가입</a><a href="./join_edit.php">회원정보</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 회원가입</span></li>
			<li class="r3"><span>회원가입</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
			<ul id="join_step">
				<li class="step1 selected"></li>
				<li class="step2"></li>
				<li class="step3"></li>
				<li class="step4"></li>
			</ul>

			<div id="content1">
				<h3>페이스링크 이용약관</h3>
				<textarea readonly></textarea>
				<input type="checkbox" id="agree"> 이용약관을 확인하였으며, 이용약관에 동의합니다.
			</div>

			<div id="content2">
				<h3>개인정보 수집 이용안내</h3>
				<textarea readonly></textarea>
				<input type="checkbox" id="agree1"> 개인정보 수집 이용 안내를 확인하였으며, 이에 동의합니다.
			</div>
			<div id="common_btn_area" style="width:400px;">		
				<input type="submit" id="step_ok" class="btn_big blue" value="다음단계">
				<input type="button" id="step_cancel" class="btn_big darkgray" value="취소">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>