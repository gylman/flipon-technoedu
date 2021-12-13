<? include "../include/header.php"; ?>
<!-- 쪽지 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
/* 받은 쪽지함, 보낸 쪽지함, 쪽지스기 탭 설정******************************************************/
#tab { width:100%; overflow:hidden; box-sizing:border-box; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	height:330px;
	padding:10px 0px;
	box-sizing:border-box;
}

#tab1:checked~#sub1,
#tab2:checked~#sub2,
#tab3:checked~#sub3 { display:block; padding-top:30px; }

#tab1:checked~#lab1,
#tab2:checked~#lab2,
#tab3:checked~#lab3 {
	background: #ffffff; 

	border-left:3px solid #848586; 
	border-top:3px solid #848586; 
	border-right:3px solid #848586; 
	border-bottom:3px solid #ffffff;
}

#tab label { 
	display:block; 
	float:left; 
	width:33.33%; 
	height:40px; 
	line-height:40px; 
	font-weight:bold;
	text-align:center;
	cursor:pointer; 
	background:#fafafa;	

	border-top:1px solid #c4c4c4;
	border-left:1px solid #c4c4c4;
	border-right:1px solid #c4c4c4;
	border-bottom:3px solid #848586;

	border-radius:20px 20px 0px 0px;
	box-sizing:border-box;
}
/**********************************************************************************************/
</style>
<script type="text/javascript">
$(document).ready(function() {
	//로그인 체크
	checkLogin();
	
	//기본 선택 설정
	var tab_num = localStorage.getItem("com.facelink.mypage.note_tap");
	if(tab_num == "1"){
		$("#tab1").trigger("click");
		localStorage.removeItem("com.facelink.mypage.note_tap");
	}else if(tab_num == "2"){
		$("#tab2").trigger("click");
		localStorage.removeItem("com.facelink.mypage.note_tap");
	}else if(tab_num == "3"){
		$("#tab3").trigger("click");
		localStorage.removeItem("com.facelink.mypage.note_tap");
	}
	
	$("#tab1").on("click",function(){
		initReceiveList();
	});
	
	$("#tab2").on("click",function(){
		initSendList();
	});
});
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php">지난회의목록</a><a href="./friend.php">친구</a><a href="./note.php" class="sub_select">쪽지</a><a href="../join/join_edit.php">회원정보</a><a href="./device_test.php">장치설정</a><span class="path">HOME > My i-Mentor> 쪽지</span></li>
			<li class="r3"><span>쪽지</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">

			<section id="tab">
				<input type="radio" id="tab1" name="tb" checked />
				<input type="radio" id="tab2" name="tb" />
				<input type="radio" id="tab3" name="tb" />
				<label for="tab1" id="lab1">받은 쪽지함<span id="recv_note_cnt">( - )</span></label>
				<label for="tab2" id="lab2">보낸 쪽지함<span id="send_note_cnt">( - )</span></label>
				<label for="tab3" id="lab3">쪽지쓰기</label>

				<!-- 친구관리 -->
				<section id="sub1">
					<? include "./note_tab1.php"; ?>
				</section>

				<!-- 그룹관리 -->
				<section id="sub2">
					<? include "./note_tab2.php"; ?>					
				</section>

				<!-- 메세지 -->
				<section id="sub3">
					<? include "./note_tab3.php"; ?>
				<section id="sub3">
				
			</section>
			
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
