<? include "../include/header.php"; ?>
<!-- 공지사항, 문의사항, FAQ 리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#write { display:inline-block; width:100%; }
#write form { display:inline-block; }
#write li { float:left; padding-bottom:10px; }
#write li .star { display:inline-block; padding-left:10px; color:red; }
#write li:nth-child(odd) { width:20%; line-height:30px; padding-left:100px; font-weight:bold; }
#write li:nth-child(even) { width:80%; padding-left:20px; }

#write li input[type=text] { height:30px; line-height:30px; }
#write li select { width:150px; height:34px; line-height:34px; padding-left:10px; }

#write #subject { width:90%; }
#write #name { width:340px; }
#write #hp1, #write #hp2, #write #hp3 { width:100px; }
#write #email1, #write #email2 { width:200px; }


textarea { width:90%; min-height:200px; padding:10px 20px; border:1px solid #cccccc; }

/* common_room_list 재정의 */
#common_btn_area { width:200px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
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
	
	$("#write_btn").click(function(){
		// cellphone check
		var reg_num = /^[0-9]*$/;
		if ($('#hp1').val().length < 3 || $('#hp2').val().length < 3 || $('#hp3').val().length < 3) {
			alert("핸드폰 번호를 정확히 입력해 주세요");
			return false;
		}
		
		if (!reg_num.test($('#hp1').val()) || !reg_num.test($('#hp2').val()) || !reg_num.test($('#hp3').val())) {
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
		
		//글 등록
		var postJsonData = {
			page : now_page,
			limit : now_limit
		};
		$.post( g_apiUrlRoot+"board_notice_write.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				
			} else {
				alert('공지사항을 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	});
	
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 고객센터</li>
			<li class="r2"><a href="notice_list.php">공지사항</a><a href="./write.php" class="sub_select">문의사항</a><a href="faq_list.php">FAQ</a><span class="path">HOME > FaceLink 고객센터 > 문의사항</span></li>
			<li class="r3"><span>문의사항</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="write">
			<form>
				<ul>
					<li>제 목</li>
					<li><input type="text" id="subject" name="subject"></li>
				</ul>
				<ul>
					<li>이 름</li>
					<li><input type="text" id="name" name="name"></li>
				</ul>
				<ul>
					<li>핸드폰<span class="star">*</span></li>
					<li><input type="text" id="hp1" name="hp1"> - <input type="text" id="hp2" name="hp2"> - <input type="text" id="hp3" name="hp3"></li>
				</ul>
				<ul>
					<li>이메일<span class="star">*</span></li>
					<li>
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
						</select>
					</li>
				</ul>
				<ul>
					<li>내 용</li>
					<li><textarea></textarea></li>
				</ul>				
				<div id="common_btn_area">
					<input id="write_btn" type="button" value="확인" class="btn_big blue">
				</div>
			</form>			
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>