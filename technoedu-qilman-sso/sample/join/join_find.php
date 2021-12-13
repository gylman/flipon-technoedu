<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../include/css/join.css">

<style>
#join p { display:block; width:800px; margin:10px auto; font-size:15px; font-weight:bold; }
#tab { width:800px; margin:0px auto; overflow:hidden; box-sizing:border-box; }
#tab p { padding-top:10px; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	/*height:300px;*/
	padding-top:20px;
	border-left:2px solid #2d91cf;
	border-right:2px solid #2d91cf;
	border-bottom:2px solid #2d91cf;

	box-sizing:border-box;
}

#tab1:checked~#sub1,
#tab2:checked~#sub2,
#tab3:checked~#sub3,
#tab4:checked~#sub4 { display:block; }

#tab1:checked~#lab1,
#tab2:checked~#lab2,
#tab3:checked~#lab3,
#tab4:checked~#lab4 { 
	background: #ffffff; 

	border-left:2px solid #2389c8; 
	border-top:2px solid #2389c8; 
	border-right:2px solid #2389c8; 
	border-bottom:2px solid #ffffff;

	color:#2d91cf;
	font-weight:bold;
}

#tab label { 
	display:block; 
	float:left; 
	width:50%; 
	height:40px; 
	line-height:40px; 
	text-align:center; 
	cursor:pointer; 
	background:#fafafa;	

	border-top:1px solid #c4c4c4;
	border-left:1px solid #c4c4c4;
	border-right:1px solid #c4c4c4;
	border-bottom:2px solid #2389c8;
	box-sizing:border-box;
}

.find_hp { display:block; width:500px; margin:0px auto; padding:10px 0px; }
.find_hp > li { display:inline-block; *zoom:1;  width:100%; padding:10px 0px;  }
.find_hp > li > span { display:block; float:left; }
.find_hp > li > span:first-child { width:80px; }
.find_hp > li > span:last-child { width:80%; }


.find_email { display:block; width:500px; margin:0px auto; padding:10px 0px; }
.find_email > li { display:inline-block; *zoom:1;  width:100%; padding:10px 0px;  }
.find_email > li > span { display:block; float:left; }
.find_email > li > span:first-child { width:80px; }
.find_email > li > span:last-child { width:80%; }


form span { font-weight:bold; }
form input[type=text] { width:300px; }

form #tel1,
form #tel2,
form #tel3 { width:90px; }

form #email1,
form #email2 { width:200px; }
form select { width:100px; }

form #addr1,
form #addr2 { width:300px; }
</style>
	<!-- 상단 -->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 멤버쉽</li>
			<li class="r2"><a href="./login.php">로그인</a><a href="join_find.php" class="sub_select">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a><a href="./join_edit.php">회원정보</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 아이디비밀번호 찾기</span></li>
			<li class="r3"><span>아이디비밀번호 찾기</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">

		<div id="join">
			<!-- 아이디 찾기 -->
			<img src="../images/join_find_tit.png">
			<p>아이디 찾기/회원가입시 입력했던 정보를 확인해 주세요.</p>
			<form id="find_id" name="find_id_hp" method="post">
			<section id="tab">
				<input type="radio" id="tab1" name="tb" checked />
				<input type="radio" id="tab2" name="tb" />
				<label for="tab1" id="lab1">핸드폰으로 아이디 찾기</label>
				<label for="tab2" id="lab2">이메일로 아이디 찾기</label>

				<!-- 서브1 영역 -->
				<section id="sub1">
					<ul class="find_hp">
						<li><span>이름 </span><input type="text" id="user_name"></li>
						<li><span>핸드폰</span><input type="text" id="tel1"> - <input type="text" id="tel2"> - <input type="text" id="tel3"></li>			
						<li id="common_btn_area" style="width:100px;"><input type="submit" value="아이디찾기" class="btn_small darkgray"></li>
					</ul>
				</section>

				<!-- 서브2 영역 -->			
				<section id="sub2">
					<ul class="find_email">
						<li><span>이름</span><input type="text" id="user_name"></li>
						<li>
							<span>이메일</span>
							<span>
								<input type="text" id="email1"> @ <BR>
								<input type="text" id="email2">
								<select id="email3">
									<option>선택하세요</option>					
								</select>
							</span>
						</li>
						<li id="common_btn_area" style="width:120px;"><input type="submit" value="아이디찾기" class="btn_small darkgray"></li>
					</ul>
				</section>			
			</section>
			</form>
			<!-- 비밀번호 찾기 -->
			<BR><BR><BR><BR>
			<p>비밀번호 찾기/회원가입시 입력했던 정보를 확인해 주세요.</p>
			<form id="find_pw" name="find_pw" method="post">
			<section id="tab">
				<input type="radio" id="tab3" name="tb" checked />
				<input type="radio" id="tab4" name="tb" />
				<label for="tab3" id="lab3">핸드폰으로 임시밀번호 발급</label>
				<label for="tab4" id="lab4">이메일로 임시비밀번호 발급</label>

				<!-- 서브1 영역 -->
				<section id="sub3">
					<ul class="find_hp">
						<li><span>아이디</span><input type="text" id="user_id"></li>
						<li><span>이름</span><input type="text" id="user_name"></li>
						<li><span>핸드폰</span><input type="text" id="tel1"> - <input type="text" id="tel2"> - <input type="text" id="tel3"></li>			
						<li id="common_btn_area" style="width:120px;"><input type="submit" value="임시 비밀번호 발송" class="btn_small darkgray"></li>
					</ul>
				</section>

				<!-- 서브2 영역 -->			
				<section id="sub4">
					<ul class="find_email">
						<li><span>아이디</span><input type="text" id="user_id"></li>
						<li><span>이름</span><input type="text" id="user_name"></li>
						<li>
							<span>이메일</span>
							<span>
								<input type="text" id="email1"> @ <input type="text" id="email2">
								<select id="email3">
									<option>선택하세요</option>					
								</select>
							</span>
						</li>
						<li id="common_btn_area" style="width:120px;"><input type="submit" value="임시 비밀번호 발송" class="btn_small darkgray"></li>
					</ul>
				</section>			
			</section>
			</form>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>