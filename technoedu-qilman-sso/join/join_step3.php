<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>
#join p { width:100%; margin:0px auto; padding:5px 0px; }
#join > #content1 { display:inline-block; width:100%; padding:30px; margin:10px auto; border-top:1px solid #d9d9d9; border-bottom:1px solid #d9d9d9; }
#join > #content1 > ul { clear:both; width:600px; padding:5px 0px; margin:0px auto; margin-bottom:10px; display:block; }
#join > #content1 > ul > li { display:inline-block; float:left; }
#join > #content1 > ul > li.q { width:100px; height:30px; }
#join > #content1 > ul > li.a { width:70%; }

#btn_area {	width:360px; height:83px; margin:10px auto; }
</style>

<script type="text/javascript">
var g_chkID = false;

$(document).ready(function() {
	
	if (localStorage.getItem("com.facelink.join.confirm_terms") != "1") {
		history.back(-2);
		return;
	}
	
	if (_.isUndefined(localStorage.getItem("com.facelink.join.user_name")) || localStorage.getItem("com.facelink.join.user_name").length <= 0 ||
		_.isUndefined(localStorage.getItem("com.facelink.join.user_birth_year")) || localStorage.getItem("com.facelink.join.user_birth_year").length <= 0 ||
		_.isUndefined(localStorage.getItem("com.facelink.join.user_birth_month")) || localStorage.getItem("com.facelink.join.user_birth_month").length <= 0 ||
		_.isUndefined(localStorage.getItem("com.facelink.join.user_birth_day")) || localStorage.getItem("com.facelink.join.user_birth_day").length <= 0 ||
		_.isUndefined(localStorage.getItem("com.facelink.join.user_sex")) || localStorage.getItem("com.facelink.join.user_sex").length <= 0) {
		history.back(-1);
		return;
	}
	
	$("#step_ok").click(function() {
		// 필수항목 확인
		// id check
		if ($('#user_id').val().length <= 2 || $('#user_id').val().length > 12) {
			alert('아이디를 정확히 입력해 주세요\n아이디는 3자 이상 12자 이하로만 가능합니다');
			$('#user_name').focus();
			return;
		}
		
		var reg_id = /^[A-Za-z0-9_+]{3,12}$/;
		if (!reg_id.test($('#user_id').val())) {
			alert("아이디는 영문대소문자, 숫자로만 입력하실 수 있습니다");
			return;
		}
		
		if (!g_chkID) {
			alert("아이디 중복확인해 주세요");
			return;
		}
		
		// pw check
		if ($('#user_pw').val().length < 4 || $('#user_pw').val().length > 16) {
			alert("비밀번호는 4이상 16자 이하로 입력해 주세요");
			return false;
		}
		
		if ($('#user_pw').val() != $('#user_repw').val()) {
			alert("비밀번호와 비밀번호 확인이 서로 맞지 않습니다\n다시 입력해 주세요");
			return false;
		}
		
		//var reg_pw = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{6,16}$/;
		//var reg_pw = /^(?=.*[a-zA-Z])(?=.*[0-9]).{4,16}$/;
		var reg_pw = /^(?=.*[a-zA-Z])|(?=.*[0-9]).{4,16}$/;
		if (!reg_pw.test($('#user_pw').val()))     {
			alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 입력해 주세요");
			return false;
		}
		
		// cellphone check
		var reg_num = /^[0-9]*$/;
		if ($('#tel').val().length < 9) {
			alert("핸드폰 번호를 정확히 입력해 주세요");
			return false;
		}
		
		if (!reg_num.test($('#tel').val())) {
			alert("핸드폰 번호는 숫자로만 입력해 주세요");
			return false;
		}
		
		// email check
		if ($('#email1').val().length <= 0 || $('#email2').val().length <= 0) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var email = $('#email1').val() + '@' + $('#email2').val();
		var reg_email=/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
		if (!reg_email.test(email)) {
			alert("이메일 주소를 정확히 입력해 주세요");
			return false;
		}
		
		var postJsonData = {
			user_name : localStorage.getItem("com.facelink.join.user_name"),
			user_byear : localStorage.getItem("com.facelink.join.user_birth_year"),
			user_bmonth : localStorage.getItem("com.facelink.join.user_birth_month"),
			user_bday : localStorage.getItem("com.facelink.join.user_birth_day"),
			user_sex : localStorage.getItem("com.facelink.join.user_sex"),
			user_id : $('#user_id').val(),
			user_pw : $('#user_pw').val(),
			user_group : $('#user_group').val(),
			user_phone : $('#tel').val(),
			user_email : email,
			user_allow_mailing : $('#mailing').is(':checked') == true ? '1' : '0',
			user_depart : $('#user_depart').val()
		};
		
		$.post( g_apiUrlRoot+"join.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				localStorage.removeItem("com.facelink.join.confirm_terms");
				localStorage.removeItem("com.facelink.join.user_name");
				localStorage.removeItem("com.facelink.join.user_birth_year");
				localStorage.removeItem("com.facelink.join.user_birth_month");
				localStorage.removeItem("com.facelink.join.user_birth_day");
				localStorage.removeItem("com.facelink.join.user_sex");
				
				location.href="./join_step4.php";
			} else if (dataJson.rt_code == 2000) {
				alert('아이디 혹은 이메일이 중복되어 가입하지 못했습니다\n정보를 확인 후 다시 가입해 주세요');
			} else {
				alert('죄송합니다\n가입하지 못했습니다\n정보를 확인 후 다시 가입해 주세요');
			}
		}, "json");
	});

	$("#step_cancel").click(function(){
		history.back(-1);
	});
	
	$('#email3').change(function(e) {
		$("#email3 option:selected").each(function () {
		
			if($(this).val()== '1') {					//직접입력일 경우
				$("#email2").val('');                //값 초기화
				$("#email2").attr("disabled", false); //활성화
			} else {									//직접입력이 아닐경우
				$("#email2").val($(this).text());    //선택값 입력
				$("#email2").attr("disabled", true);	//비활성화
			}
		});
    });
	
	$('#chk_id').click(function(e) {
		if ($('#user_id').val().length <= 2 || $('#user_id').val().length > 12) {
			alert('아이디를 정확히 입력해 주세요\n아이디는 3자 이상 12자 이하로만 가능합니다');
			$('#user_name').focus();
			return;
		}
		
		var reg_id = /^[A-Za-z0-9_+]{3,12}$/;
		if (!reg_id.test($('#user_id').val())) {
			alert("아이디는 영문대소문자, 숫자로만 입력하실 수 있습니다");
			return;
		}
		
		if ($('#user_id').val().indexOf("guest") == 0) {
			alert('guest라는 단어는 사용하실 수 없습니다');
			return;
		}
		
		var postJsonData = {
			user_id : $('#user_id').val()
		};
		
        $.post( g_apiUrlRoot+"check_id.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				g_chkID = true;
				alert('사용 가능한 아이디입니다');
			} else {
				g_chkID = false;
				alert('이미 가입된 아이디입니다\n다른 아이디로 가입해 주세요');
			}
		}, "json");
    });
	
	// init data
	$('#user_name').text(localStorage.getItem("com.facelink.join.user_name"));
	$('#user_birthday').text(localStorage.getItem("com.facelink.join.user_birth_year")+"년 "+localStorage.getItem("com.facelink.join.user_birth_month")+"월 "+localStorage.getItem("com.facelink.join.user_birth_day")+"일");
	$('#user_sex').text(localStorage.getItem("com.facelink.join.user_sex") == "1" ? "남" : "여");
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
		<div id="join">
			<ul id="join_step">
				<li class="step1"></li>
				<li class="step2"></li>
				<li class="step3 selected"></li>
				<li class="step4"></li>
			</ul>
			
			<p><span style="font-weight:bold; font-size:1.3em;">정보 입력</span> *표시된 부분은 필수 항목입니다.</p>
			<div id="content1">		
				<ul>
					<li class="q">이름 </li>
					<li id="user_name" class="a">홍길동</li>
				</ul>
				<ul>
					<li class="q">생년월일</li>
					<li id="user_birthday" class="a">1990년 01월 01일</li>
				</ul>
				<ul>
					<li class="q">성별</li>
					<li id="user_sex" class="a">남</li>
				</ul>
				<ul>
					<li class="q">아이디 <span class="star">*</span> </li>
					<li class="a"><input type="text" id="user_id" maxlength="12"><input id="chk_id" type="button" value="중복확인" class="btn_basic lightgray"></li>
				</ul>
				<ul>
					<li class="q">비밀번호 <span class="star">*</span> </li>
					<li class="a"><input type="password" id="user_pw" maxlength="16"></li>
				</ul>
				<ul>
					<li class="q">비밀번호 확인 <span class="star">*</span> </li>
					<li class="a"><input type="password" id="user_repw" maxlength="16"></li>
				</ul>
				<ul>
					<li class="q">소속</li>
					<li class="a"><input type="text" id="user_group" maxlength="20"></li>
				</ul>
                <ul>
					<li class="q">부서</li>
					<li class="a"><input type="text" id="user_depart" maxlength="20"></li>
				</ul>
				<ul>
					<li class="q">핸드폰 <span class="star">*</span> </li>
					<li class="a">
						<input type="text" id="tel" maxlength="12"> (숫자만 입력)
					</li>
				</ul>
				<ul>
					<li class="q">이메일 <span class="star">*</span></li>
					<li class="a">
						<input type="text" id="email1" maxlength="100"> @ <input type="text" id="email2" maxlength="100">
						<select id="email3">
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
						</select><BR>
						<input id="mailing" type="checkbox" checked> FaceLink의 메일링 허용
					</li>
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
