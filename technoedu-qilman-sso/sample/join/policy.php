<? include "../include/header.php"; ?>
<!-- 이용약관 -->
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

<style>
#join { }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('.id_find').click(function() {
		location.href="../join/join_find.php";	
	});

	$('.join').click(function() {
		location.href="../join/join_step1.php"; 
	});
});
</script>
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 멤버쉽</li>
			<li class="r2"><a href="./login.php">로그인</a><a href="./join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a><a href="./join_edit.php">회원정보</a><a href="./condition.php">이용약관</a><a href="./policy.php" class="sub_select">개인정보취급방침</a><span class="path">HOME > FaceLink > 개인정보취급방침</span></li>
			<li class="r3"><span>개인정보취급방침</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>