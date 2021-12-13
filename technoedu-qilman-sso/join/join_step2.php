<? include "../include/header.php"; ?>
<link rel="stylesheet" type="text/css" href="../css/join.css">

<style>
#join p { width:100%; margin:0px auto; padding:5px 0px; }
#join > #content1 { display:inline-block; width:100%; padding:30px; margin:10px auto; border-top:1px solid #d9d9d9; border-bottom:1px solid #d9d9d9; }
#join > #content1 > ul { clear:both; width:500px; padding:5px 0px; margin:0px auto; display:block; }
#join > #content1 > ul > li { display:inline-block; float:left; }
#join > #content1 > ul > li.q { width:100px; }
#join > #content1 > ul > li.a { width:70%; }

.star { color:red; }


#btn_area {	width:360px; height:83px; margin:10px auto; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	
	if (localStorage.getItem("com.facelink.join.confirm_terms") != "1") {
		history.back(-1);
		return;
	}
	
	$("#step_ok").click(function() {
		
		// 이름 체크
		if ($('#user_name').val().length <= 0 || $('#user_name').val().length > 20) {
			alert('이름을 정확히 입력해 주세요\n이름은 20자 이하만 가능합니다');
			$('#user_name').focus();
			return;
		}
		
		// 생년월일 체크
		if ($('#birthday_year').val().length <= 0 || $('#birthday_month').val().length <= 0 || $('#birthday_day').val().length <= 0) {
			alert('생년월일을 선택해 주세요');
			return;
		}
		
		// 성별 체크
		if ($('input[name=sex]:checked').val() != 1 && $('input[name=sex]:checked').val() != 2) {
			alert('성별을 선택해 주세요');
			return;
		}
		
		localStorage.setItem("com.facelink.join.user_name", $('#user_name').val());
		localStorage.setItem("com.facelink.join.user_birth_year", $('#birthday_year').val());
		localStorage.setItem("com.facelink.join.user_birth_month", $('#birthday_month').val());
		localStorage.setItem("com.facelink.join.user_birth_day", $('#birthday_day').val());
		localStorage.setItem("com.facelink.join.user_sex", $('input[name=sex]:checked').val());
		
		location.href="./join_step3.php";
	});

	$("#step_cancel").click(function() {
		history.back(-1);
	});
	
	// 생년월일 select option 구성
	function setSelect(birthday) {
		
		var toDay = new Date();
		var year  = toDay.getFullYear();
		var month = (toDay.getMonth()+1);
		var day   = toDay.getDate();
		
		var str = "<option value=''>년도</option>";
		// 년도 설정
		for (var i=year; i>=1900; i--) {
			if (birthday != null && birthday.substr(0,4) == i) {
				str += "<option value='" + i + "' selected='selected'>" + i + "</option>";
			} else {
				str += "<option value='" + i + "' >" + i + "</option>";
			}
		}
		$("#birthday_year").html(str);
		
		// 월, 일 설정
		for (var i=1; i<=31; i++) {
			var val = "";
			if (i < 10) {
				val = "0" + new String(i);
			} else {
				val = new String(i);
			} 
			
			if (birthday != null && birthday.substr(6,2) == i) {
				
				$("<option value='" + val + "' selected>" + val + "</option>").appendTo("#birthday_day");
			} else {
				$("<option value='" + val + "'>" + val + "</option>").appendTo("#birthday_day");
			}
			
			if (i < 13) {
				if (birthday != null && birthday.substr(4,2) == i) {
					$("<option value='" + val + "' selected>" + val + "</option>").appendTo("#birthday_month");
				} else {
					$("<option value='" + val + "'>" + val + "</option>").appendTo("#birthday_month");
				}
			}
		}
		// null 일경우 오늘 날짜
		if (birthday == "null") {
			$("#birthday_year").val(year);
			$("#birthday_month").val(month);
			$("#birthday_day").val(day);
		}
	}
	setSelect(null);
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
						<select id="birthday_year">
							<option value=''>년도</option>
						</select>
						<select id="birthday_month">
							<option value=''>월</option>
						</select>
						<select id="birthday_day">
							<option value=''>일</option>
						</select>
					</li>
				</ul>
				<ul>
					<li class="q">성별 <span class="star">*</span> </li>
					<li class="a"><input type="radio" name="sex" value="1"> 남&nbsp;&nbsp;<input type="radio" name="sex" value="2">여</li>
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
