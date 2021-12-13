<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

<style>
#join p { width:100%; margin:0px auto; }
#join > #content1 { display:inline-block; width:100%; padding:30px; margin:10px auto; border-top:1px solid #d9d9d9; border-bottom:1px solid #d9d9d9; }
#join > #content1 > ul { clear:both; width:600px; margin:0px auto; padding:10px 0px; }
#join > #content1 > ul > li { float:left; line-height:40px; }
#join > #content1 > ul > li.q { width:120px; font-weight:bold; }
#join > #content1 > ul > li.a { }
#join > #content1 > ul > li.a > input[type=text] { width:300px; }

#join > #content1 > ul > li.a > #tel1,
#join > #content1 > ul > li.a > #tel2,
#join > #content1 > ul > li.a > #tel3 { width:90px; }

#join > #content1 > ul > li.a > #email1,
#join > #content1 > ul > li.a > #email2 { width:200px; }
#join > #content1 > ul > li.a > select { width:100px; }

#join > #content1 > ul > li.a > #addr1,
#join > #content1 > ul > li.a > #addr2 { width:300px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#step_ok").click(function(){
		//location.href="./join_edit_ok.php";
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
			<li class="r2"><a href="./login.php">로그인</a><a href="join_find.php">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a><a href="./join_edit.php" class="sub_select">회원정보</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 회원정보수정</span></li>
			<li class="r3"><span>회원정보수정</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">
		<div id="join">
			<p><span style="font-weight:bold; font-size:1.3em;">정보 입력</span> *표시된 부분은 필수 항목입니다.</p>
			<div id="content1">		
				<ul>
					<li class="q">이름 </li>
					<li class="a">홍길동</li>
				</ul>
				<ul>
					<li class="q">생년월일</li>
					<li class="a">1990년 01월 01일</li>
				</ul>
				<ul>
					<li class="q">성별</li>
					<li class="a">남</li>
				</ul>
				<ul>
					<li class="q">아이디 <span class="star">*</span> </li>
					<li class="a"><B>honghong</B></li>
				</ul>
				<ul>
					<li class="q">비밀번호 <span class="star">*</span> </li>
					<li class="a"><input type="password" id="user_pw"></li>
				</ul>
				<ul>
					<li class="q">비밀번호 확인 <span class="star">*</span> </li>
					<li class="a"><input type="text" id="user_repw"></li>
				</ul>
				<ul>
					<li class="q">소속</li>
					<li class="a"><input type="text" id="user_group"></li>
				</ul>
				<ul>
					<li class="q">핸드폰 <span class="star">*</span> </li>
					<li class="a">
						<input type="text" id="tel1"> - <input type="text" id="tel2"> - <input type="text" id="tel3">
					</li>
				</ul>
				<ul>
					<li class="q">이메일 <span class="star">*</span></li>
					<li class="a">
						<input type="text" id="email1"> @ <BR><input type="text" id="email2">
						<select id="email3">
							<option>선택하세요</option>					
						</select><BR>
						<input type="checkbox"> FaceLink의 메일링 허용
					</li>
				</ul>
				<ul>
					<li class="q">주소 <span class="star">*</span> </li>
					<li class="a"><input type="text" id="user_addr"><input type="button" class="btn_basic lightgray" value="우편번호 검색"></li>
				</ul>
			</div>
			<div id="common_btn_area" style="width:400px;">		
				<input type="submit" id="step_ok" class="btn_big blue" value="확인">
				<input type="button" id="step_cancel" class="btn_big darkgray" value="취소">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>