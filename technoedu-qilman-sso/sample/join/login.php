<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

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
</style>

<script type="text/javascript">
$(document).ready(function() {
	$('#btn_idfind').click(function() {
		location.href="../join/join_find.php";	
	});

	$('#btn_join').click(function() {
		location.href="../join/join_step1.php"; 
	});
});
</script>
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 멤버쉽</li>
			<li class="r2"><a href="./login.php" class="sub_select">로그인</a><a href="./join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a><a href="./join_edit.php">회원정보</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 로그인</span></li>
			<li class="r3"><span>로그인</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
			<img src="../images/login_tit.png">
			<form id="login" name="login" method="post">
			<ul>
				<li><span>Email/Username : </span><span><input type="text"></li>
				<li><span>Password : </span><span><input type="password"></li>
				<li><input type="checkbox">Keep me signed in </li>
				<li id="common_btn_area" style="width:300px;">
					<input type="button" id="btn_idfind" class="btn_small gray" value="아이디/비밀번호 찾기">
					<input type="button" id="btn_join" class="btn_small gray" value="회원가입">
				</li>
			</ul>
			<div id="common_btn_area" style="width:200px;">	
				<input type="submit" class="btn_big blue" value="Sign in">
			</div>
			</form>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>