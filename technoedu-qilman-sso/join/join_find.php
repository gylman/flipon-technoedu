<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>
#join p { display:block; width:800px; margin:10px auto; }
#tab { width:800px; margin:0px auto; overflow:hidden; box-sizing:border-box; }
#tab p { padding-top:10px; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	height:330px;
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

	border-left:2px solid #2d91cf; 
	border-top:2px solid #2d91cf; 
	border-right:2px solid #2d91cf; 
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
	border-bottom:2px solid #2d91cf;
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

.find_btn {	
	display:block;
	width:145px;
	height:26px;
	border:0px;
	background:url("../../images/b_idfind.png") 0 0 no-repeat;	
}

.find_pw {	
	display:block;
	width:145px;
	height:26px;
	border:0px;
	background:url("../../images/b_idfind_numsend.png") 0 0 no-repeat;	
}

</style>

<script>
$(document).ready(function() {
	$('#id_email3').change(function(e) {
		$("#id_email3 option:selected").each(function () {
		
			if($(this).val()== '1') {					//직접입력일 경우
				$("#id_email2").val('');                //값 초기화
				$("#id_email2").attr("disabled", false); //활성화
			} else {									//직접입력이 아닐경우
				$("#id_email2").val($(this).text());    //선택값 입력
				$("#id_email2").attr("disabled", true);	//비활성화
			}
		});
    });
	
	$('#pw_email3').change(function(e) {
		$("#pw_email3 option:selected").each(function () {
		
			if($(this).val()== '1') {					//직접입력일 경우
				$("#pw_email2").val('');                //값 초기화
				$("#pw_email2").attr("disabled", false); //활성화
			} else {									//직접입력이 아닐경우
				$("#pw_email2").val($(this).text());    //선택값 입력
				$("#pw_email2").attr("disabled", true);	//비활성화
			}
		});
    });
	
	$('.find_btn').click(function(e) {
        if ($('#id_user_name').val().length <= 0) {
			alert('이름을 입력해 주세요');
			$('#find_pw').focus();
			return false;
		}
		
		if ($('#id_email1').val().length <= 0 || $('#id_email2').val().length <= 0) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var email = $('#id_email1').val() + '@' + $('#id_email2').val();
		var reg_email=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if (!reg_email.test(email)) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var postJsonData = {
			name : $('#id_user_name').val(),
			email : email
		};
		$.post( g_apiUrlRoot+"find_id.php", postJsonData, function(dataJson) {
			if (dataJson.rt_code == 0) {
				alert('아이디를 메일로 전달하였습니다\n메일을 확인해 주세요');
				location.href = 'login.php';
			} else if (dataJson.rt_code == 3000) {
				alert('입력하신 정보와 일치하는 사용자를 찾을 수 없습니다\n다시 확인해 주세요');
			} else {
				alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
			}
		}, "json");
		
		return false;
    });
	
	$('.find_pw').click(function(e) {
		if ($('#pw_user_id').val().length <= 0) {
			alert('아이디를 입력해 주세요');
			$('#pw_user_id').focus();
			return false;
		}
		
        if ($('#pw_user_name').val().length <= 0) {
			alert('이름을 입력해 주세요');
			$('#pw_user_name').focus();
			return false;
		}
		
		if ($('#pw_email1').val().length <= 0 || $('#pw_email2').val().length <= 0) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var email = $('#pw_email1').val() + '@' + $('#pw_email2').val();
		var reg_email=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if (!reg_email.test(email)) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var postJsonData = {
			id : $('#pw_user_id').val(),
			name : $('#pw_user_name').val(),
			email : email
		};
		$.post( g_apiUrlRoot+"find_pw.php", postJsonData, function(dataJson) {
			if (dataJson.rt_code == 0) {
				alert('임시 비밀번호를 메일로 전달하였습니다\n메일을 확인해 주세요');
				location.href = 'login.php';
			} else if (dataJson.rt_code == 3000) {
				alert('입력하신 정보와 일치하는 사용자를 찾을 수 없습니다\n다시 확인해 주세요');
			} else {
				alert('죄송합니다\n서버 정보를 가져오지 못했습니다\n잠시 후 다시 접속해 주세요');
			}
		}, "json");
		
		return false;
    });
});
</script>

	<!-- 상단 -->
	<div id="sub_top">
		<ul>
			<li class="r1">i-Mentor 멤버쉽</li>
			<li class="r2"><a href="./login.php">로그인</a><a href="join_find.php" class="sub_select">아이디/비밀번호찾기</a><a href="./join_step1.php">회원가입</a><a href="./condition.php">이용약관</a><a href="./policy.php">개인정보취급방침</a><span class="path">HOME > FaceLink > 아이디/비밀번호 찾기</span></li>
			<li class="r3"><span>아이디/비밀번호 찾기</span></li>
		</ul>		
	</div>

	<!-- 본문 -->
	<section id="sub_section">

	<font size=4>
	<p>현재 이 사이트의 계정은 관리자의 의해서 관리되고 있습니다. 
	<br>
	<br>
	<p>아래 연락처로 연락을 주시면 친절히 알려드리도록 하겠습니다.		
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
<!--
		<div id="join">
			<p>아이디 찾기/회원가입시 입력했던 정보를 확인해 주세요.</p>
			<form id="find_id" name="find_id_hp" method="post">
			<section id="tab">
				<input type="radio" id="tab1" name="tb" checked />
				<label for="tab2" id="lab1">이메일로 아이디 찾기</label>

				<section id="sub1" style="border-top: 2px solid #2d91cf;">
					<ul class="find_email">
						<li><span>이름 : </span><span><input type="text" id="id_user_name"></span></li>
						<li>
							<span>이메일 : </span>
							<span>
								<input type="text" id="id_email1"> @ <input type="text" id="id_email2">
								<select id="id_email3">
									<option value="1" selected>직접입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="hanmail.net">hanmail.net</option>
                                    <option value="hotmail.com">hotmail.com</option>
                                    <option value="nate.com">nate.com</option>
                                    <option value="yahoo.co.kr">yahoo.co.kr</option>
                                    <option value="empas.com">empas.com</option>
                                    <option value="dreamwiz.com">dreamwiz.com</option>
                                    <option value="freechal.com">freechal.com</option>
                                    <option value="lycos.co.kr">lycos.co.kr</option>
                                    <option value="korea.com">korea.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="hanmir.com">hanmir.com</option>
                                    <option value="paran.com">paran.com</option>						
								</select>
							</span>
						</li>
						<li><input type="submit" value="" class="find_btn"></li>
					</ul>
				</section>			
			</section>
			</form>

			<BR><BR><BR><BR>
			<p>비밀번호 찾기/회원가입시 입력했던 정보를 확인해 주세요.</p>
			<form id="find_pw" name="find_pw" method="post">
			<section id="tab">
				<input type="radio" id="tab3" name="tb" checked />
				<label for="tab4" id="lab3">이메일로 임시비밀번호 발급</label>

				<section id="sub3" style="border-top: 2px solid #2d91cf;">
					<ul class="find_email">
						<li><span>아이디 : </span><span><input type="text" id="pw_user_id"></span></li>
						<li><span>이름 : </span><span><input type="text" id="pw_user_name"></span></li>
						<li>
							<span>이메일 : </span>
							<span>
								<input type="text" id="pw_email1"> @ <input type="text" id="pw_email2">
								<select id="pw_email3">
									<option value="1" selected>직접입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="hanmail.net">hanmail.net</option>
                                    <option value="hotmail.com">hotmail.com</option>
                                    <option value="nate.com">nate.com</option>
                                    <option value="yahoo.co.kr">yahoo.co.kr</option>
                                    <option value="empas.com">empas.com</option>
                                    <option value="dreamwiz.com">dreamwiz.com</option>
                                    <option value="freechal.com">freechal.com</option>
                                    <option value="lycos.co.kr">lycos.co.kr</option>
                                    <option value="korea.com">korea.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="hanmir.com">hanmir.com</option>
                                    <option value="paran.com">paran.com</option>						
								</select>
							</span>
						</li>
						<li><input type="submit" value="" class="find_pw"></li>
					</ul>
				</section>			
			</section>
			</form>
		</div>
-->
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
