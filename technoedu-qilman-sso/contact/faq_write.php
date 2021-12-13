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
		
		var title = $("#subject").val();
		var content = $("#content").val();
		
		//글 등록
		var postJsonData = {
			user_id : g_user_id,
			title : title,
			content : content
		};
		$.post( g_apiUrlRoot+"board_faq_write.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				alert('게시물 작성에 성공하였습니다.');
				location.reload();
			}else if(dataJson.rt_code == 1000){
				alert("로그인 해주시기 바랍니다.");
			}else {
				alert('게시물 작성에 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	});
	
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 관리자</li>
            <!--
			<li class="r2"><a href="./list.php">공지사항</a><a href="./write.php" class="sub_select">문의사항</a><a href="./list.php">FAQ</a><span class="path">HOME > FaceLink 고객센터 > 문의사항</span></li>
            -->
            <li class="r2"></li>
			<li class="r3"><span>FAQ 작성</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="write">
            <ul>
                <li>제 목</li>
                <li><input type="text" id="subject" name="subject"></li>
            </ul>
            <ul>
                <li>내 용</li>
                <li><textarea id="content"></textarea></li>
            </ul>				
            <div id="common_btn_area">
                <input id="write_btn" type="button" value="확인" class="btn_big blue">
            </div>
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>