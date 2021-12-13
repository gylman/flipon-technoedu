<? include "../include/header.php"; ?>
<!-- 캐시 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
/* 충전내역, 사용내역 탭 설정******************************************************/
#tab { width:100%; overflow:hidden; box-sizing:border-box; }
#tab input[type=radio] { display:none; }

#tab section { 
	display:none;
	clear:both;
	padding:10px 0px;
	box-sizing:border-box;
}

#tab1:checked~#sub1,
#tab2:checked~#sub2 { display:block; padding-top:30px; }

#tab1:checked~#lab1,
#tab2:checked~#lab2 {
	background: #ffffff; 

	border-left:3px solid #848586; 
	border-top:3px solid #848586; 
	border-right:3px solid #848586; 
	border-bottom:3px solid #ffffff;
}

#tab label { 
	display:block; 
	float:left; 
	width:50%; 
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
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php" class="sub_select">캐시</a><span class="path">HOME > My FaceLink > 캐시</span></li>
			<li class="r3"><span>캐시</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">

			<section id="tab">
				<input type="radio" id="tab1" name="tb" checked />
				<input type="radio" id="tab2" name="tb" />
				<label for="tab1" id="lab1">충전내역</label>
				<label for="tab2" id="lab2">사용내역</label>

				<!-- 충전내역 -->
				<section id="sub1">
					<? include "./cash_tab1.php"; ?>
				</section>

				<!-- 사용내역 -->
				<section id="sub2">
					<? include "./cash_tab2.php"; ?>					
				</section>
				
			</section>
			
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>