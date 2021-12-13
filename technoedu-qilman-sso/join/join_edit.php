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
//로그인 체크
checkLogin(true, true);

$(document).ready(function() {
	
	//기본정보 읽어옴
	var postJsonData = {
		user_id : g_user_id
	};
	
	$.post( g_apiUrlRoot+"user_info.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			var dtBirthday = new Date(dataJson.user[0].birthday);
			$("#user_name").text(dataJson.user[0].name);
			$("#user_birthday").text(dtBirthday.format('yyyy년 MM월 dd일'));
			if(dataJson.user[0].sex == 1){
				$("#user_sex").text("남");
			}else{
				$("#user_sex").text("여");
			}
			$("#user_group").val(dataJson.user[0].part);
			$("#user_depart").val(dataJson.user[0].depart);
			$("#user_id").html("<B>"+g_user_id+"</B>");
			var temp = dataJson.user[0].email;
			var email_split = temp.split("@");
			$("#email1").val(email_split[0]);
			$("#email2").val(email_split[1]);
			var phone = dataJson.user[0].phone.replaceAll('-', '');
			$("#tel").val(phone);
			if(dataJson.user[0].allow_mailing == 1){
				$('#mailing').attr("checked", true);
			}else{
				$('#mailing').attr("checked", false);
			}
			
		}
		else{
			alert('사용자 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	
	$(".step_ok").click(function(){
		// 필수항목 확인
		
		// pw check
		//비밀번호를 입력하지 않으면 체크 하지 않는다.
		if($('#user_pw').val().length > 0){
			if ($('#user_pw').val().length < 4 || $('#user_pw').val().length > 16) {
				alert("비밀번호는 4이상 16자 이하로 입력해 주세요");
				return false;
			}
			
			if ($('#user_pw').val() != $('#user_repw').val()) {
				alert("비밀번호와 비밀번호 확인이 서로 맞지 않습니다\n다시 입력해 주세요");
				return false;
			}
			//var reg_pw = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{6,16}$/;
			var reg_pw = /^(?=.*[a-zA-Z])(?=.*[0-9]).{4,16}$/;
			if (!reg_pw.test($('#user_pw').val()))     {
				alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 입력해 주세요");
				return false;
			}
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
		
		//정보 업데이트
		var postJsonData = {
			user_id : g_user_id,
			pw : $('#user_pw').val(),
			email : email,
			phone : $('#tel').val(),
			part : $('#user_group').val(),
			depart : $('#user_depart').val(),
			allow_mailing : $('#mailing').is(':checked') == true ? "1" : "0"
		};
		
		$.post( g_apiUrlRoot+"user_info_update.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				alert('사용자 정보가 업데이트 되었습니다.');
				location.reload();
			}
			else{
				alert('사용자 정보 업데이트에 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
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

	$(".step_cancel").click(function(){
		history.back(-1);
	});
});	
</script>
	<!-- 상단 -->

	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2">
			<a href="../mypage/meeting_list.php">나의 회의</a>
			<a href="../mypage/recording_list.php" >지난회의목록</a>
			<a href="../mypage/friend.php">친구</a>
			<a href="../mypage/note.php">쪽지</a>
			<a href="./join_edit.php" class="sub_select">회원정보</a><!--a href="./cash.php">캐시</a-->
			<a href="../mypage/device_test.php">장치설정</a>
			<span class="path">HOME > My FaceLink > 지난회의목록</span></li>
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
					<li class="a" id="user_name"></li>
				</ul>
				<ul>
					<li class="q">생년월일</li>
					<li class="a" id="user_birthday"></li>
				</ul>
				<ul>
					<li class="q">성별</li>
					<li class="a" id="user_sex"></li>
				</ul>
				<ul>
					<li class="q">아이디 <span class="star">*</span> </li>
					<li class="a" id="user_id"></li>
				</ul>
				<ul>
					<li class="q">비밀번호 <span class="star">*</span> </li>
					<li class="a"><input type="password" id="user_pw"></li>
				</ul>
				<ul>
					<li class="q">비밀번호 확인 <span class="star">*</span> </li>
					<li class="a"><input type="password" id="user_repw"></li>
				</ul>
				<ul>
					<li class="q">소속</li>
					<li class="a"><input type="text" id="user_group"></li>
				</ul>
                <ul>
					<li class="q">부서</li>
					<li class="a"><input type="text" id="user_depart"></li>
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

			<div id="btn_area">		
				<input type="submit" value="확인" class="step_ok"><input type="button" value="취소" class="step_cancel">
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
