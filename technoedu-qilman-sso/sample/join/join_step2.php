<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

<style>
#join p { width:100%; margin:0px auto; }
#join > #content1 { display:inline-block; width:100%; padding:30px; margin:10px auto; border-top:1px solid #d9d9d9; border-bottom:1px solid #d9d9d9; }
#join > #content1 > ul { clear:both; width:500px; margin:0px auto; padding:10px 0px; }
#join > #content1 > ul > li { float:left; line-height:40px; }
#join > #content1 > ul > li.q { width:100px; font-weight:bold; }
#join > #content1 > ul > li.a { }
#join > #content1 > ul > li.a > input[type=text] { width:300px; }
#join > #content1 > ul > li.a > select { width:100px; }
#join > #content1 > ul > li.a > span { display:inline-block; width:80px; }

.star { color:red; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#step_ok").click(function(){
		location.href="./join_step3.php";
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
				<li class="step1"></li>
				<li class="step2 selected"></li>
				<li class="step3"></li>
				<li class="step4"></li>
			</ul>
			
			<p><span style="font-weight:bold; font-size:1.3em;">기본정보 입력</span> 회원가입을 위해 아래의 정보를 입력해 주세요.</p>
			<div id="content1">		
				<ul>
					<li class="q">이름 <span class="star">*</span> </li>
					<li class="a"><input type="text" id="user_name"></li>
				</ul>
				<ul>
					<li class="q">생년월일 <span class="star">*</span> </li>
					<li class="a">
						<select>
							<option>년도</option>
						</select>
						<select>
							<option>월</option>
						</select>
						<select>
							<option>일</option>
						</select>
					</li>
				</ul>
				<ul>
					<li class="q">성별 <span class="star">*</span> </li>
					<li class="a"><span><input type="radio" name="sex" value="1"> 남</span><span><input type="radio" name="sex" value="2">여</span></li>
				</ul>
			</div>
			<div id="common_btn_area" style="width:400px;">		
				<input type="submit" id="step_ok" class="btn_big blue" value="다음단계">
				<input type="button" id="step_cancel" class="btn_big darkgray" value="취소">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>