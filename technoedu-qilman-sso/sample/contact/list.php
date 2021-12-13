<? include "../include/header.php"; ?>
<!-- 공지사항, 문의사항, FAQ 리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
/* common_room_list 재정의 */
#common_room_list ul~ul { cursor:pointer; }
.col1 { width:10%; text-align:center; }
.col2 { width:60%; }
.col3 { width:15%; text-align:center; }
.col4 { width:15%; text-align:center; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	$("#common_room_list > ul~ul").click(function(){
		location.href = "./content.php";
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
			<ul class="title">
				<li class="col1">번호</li>
				<li class="col2">제목</li>
				<li class="col3">등록일</li>
				<li class="col4">조회수</li>
			</ul>
			<ul>
				<li class="col1">1</li>
				<li class="col2">공지사항 입니다.</li>
				<li class="col3">2014-11-24</li>
				<li class="col4">52</li>
			</ul>
			<ul>
				<li class="col1">50</li>
				<li class="col2">공지사항 입니다.</li>
				<li class="col3">2014-11-24</li>
				<li class="col4">52</li>
			</ul>
			<ul>
				<li class="col1">100</li>
				<li class="col2">공지사항 입니다.</li>
				<li class="col3">2014-11-24</li>
				<li class="col4">52</li>
			</ul>
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