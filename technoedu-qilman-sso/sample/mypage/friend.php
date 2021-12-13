<? include "../include/header.php"; ?>
<!-- 친구 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<link rel="stylesheet" type="text/css" href="../include/css/mypage.css">

<style>
/* 친구관리, 그룹 관리, 메세지 탭 설정******************************************************/
#tab { width:100%; overflow:hidden; box-sizing:border-box; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	/*height:330px;*/
	padding:10px 0px;
	box-sizing:border-box;
}

#tab1:checked~#sub1,
#tab2:checked~#sub2,
#tab3:checked~#sub3 { display:block; }

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
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php" class="sub_select">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My FaceLink > 친구</span></li>
			<li class="r3"><span>친구</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">

			<section id="tab">
				<input type="radio" id="tab1" name="tb" checked />
				<input type="radio" id="tab2" name="tb" />
				<input type="radio" id="tab3" name="tb" />
				<label for="tab1" id="lab1">친구 관리</label>
				<label for="tab2" id="lab2">그룹 관리</label>
				<label for="tab3" id="lab3">메세지</label>

				<!-- 친구관리 -->
				<section id="sub1">
					<? include "./friend_tab1.php"; ?>
				</section>

				<!-- 그룹관리 -->
				<section id="sub2">
					<? include "./friend_tab2.php"; ?>					
				</section>

				<!-- 메세지 -->
				<section id="sub3">
					<? include "./friend_tab3.php"; ?>
				<section id="sub3">
				
			</section>
			
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>