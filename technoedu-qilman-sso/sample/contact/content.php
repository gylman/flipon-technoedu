<? include "../include/header.php"; ?>
<!-- 공지사항, 문의사항, FAQ 리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
/* common_room_list 재정의 */
#common_room_list { border:1px solid #cccccc; }
#common_room_list li { background:#ffffff; }
#common_room_list li span { display:block; height:20px; line-height:20px; padding-right:10px; margin:10px; border-right:1px solid #bbbbbb; }

.col1, .col3, .col5, .col7 { width:10%; text-align:right; font-weight:bold; box-sizing:border-box; }
.col2 { width:90%; }
.col4, .col6 { width:30%; }
.col8 { width:10%; }

.content { min-height:300px; margin-top:10px; padding:10px 20px; border-bottom:1px solid #cccccc; }

#common_btn_area { }
#common_btn_area input[type=button] { float:right; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#list").click(function(){
		location.href = "./list.php";
	});
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 고객센터</li>
			<li class="r2"><a href="./list.php" class="sub_select">공지사항</a><a href="./write.php">문의사항</a><a href="./list.php">FAQ</a><span class="path">HOME > FaceLink 고객센터 > 공지사항</span></li>
			<li class="r3"><span>공지사항</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="common_room_list">
			<ul>
				<li class="col1"><span>제목</span></li>
				<li class="col2">공지사항 입니다.</li>
			</ul>
			<ul>
				<li class="col3"><span>등록자</span></li>
				<li class="col4">관리자</li>
				<li class="col5"><span>등록일</span></li>
				<li class="col6">2014-10-30</li>
				<li class="col7"><span>조회수</span></li>
				<li class="col8">52</li>
			</ul>			
		</div>
		<div class="content">
			Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum


			
		</div>

		<div id="common_btn_area">
			<input type="button" id="list" value="목록" class="btn_small darkgray">
		</div>

		<div id="common_reserve_page">
			<div class="page_group">
				<span class="page_left">◀</span>
				<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
				<span class="page_right">▶</span>
			</div>
		</div>
		<div id="common_reserve_search">
			<input type="text" class="input_search"><input type="button" class="btn_search">
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>