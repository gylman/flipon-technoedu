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
//전역변수
var g_now_page = 0;
var g_max_page = 0;
var g_now_limit = 10;
var g_search_val = '';

function setPaging(now_page, now_limit, total_count, page_group_max_count, target){
	var paging_start = "<div class='page_group' data-now_number='"+now_page+"'>";
	var paging_left = "<span class='page_left' id='page_left'>◀</span>";
	var paging_number_start = "<span class='page_num' name='page_num' data-number='";
	var paging_number_start_selected = "<span class='page_num selected' name='page_num' data-number='";
	var paging_number_middle = "'>";
	var paging_number_end = "</span>";
	var paging_right = "<span class='page_right' id='page_right'>▶</span>";
	var paging_end ="</div>";
	
	var make_paging = paging_start;
	//왼쪽 버튼 등록
	if( now_page - page_group_max_count >= 0){
		make_paging = make_paging + paging_left;
	}
	var page_start_num = Math.floor(now_page/page_group_max_count) * page_group_max_count;
	var page_end_num = page_start_num + page_group_max_count;
	if(page_end_num > Math.ceil(total_count/now_limit)){
		page_end_num = Math.ceil(total_count/now_limit);
	}
	for(var i=page_start_num; i < page_end_num; i++){
		if( i == now_page ){
			make_paging = make_paging + paging_number_start_selected + i + paging_number_middle + (i+1) + paging_number_end;
		}else{
			make_paging = make_paging + paging_number_start + i + paging_number_middle + (i+1) + paging_number_end;
		}
	}
	//오른쪽 버튼 등록
	var temp = Math.floor(now_page/page_group_max_count) * page_group_max_count + page_group_max_count;
	if( temp <= Math.ceil(total_count/now_limit)-1){
		make_paging = make_paging + paging_right;
	}
	make_paging = make_paging + paging_end;
	
	target.text('');
	target.append(make_paging);
	
	//이벤트 제거 - 중복으로 여려번 등록되는경우가 있었다.
	target.off("click");
	//이벤트 등록
	target.on("click", "span[name=page_num]", function(){
		var now_number = $(this).parent().data("now_number");
		var target_number = $(this).data("number");
		if(now_number != target_number){
			$(this).parent().data("now_number",target_number);
			//페이지 호출
			setList(target_number, now_limit);
		}
	});
	target.on("click", "#page_left", function(){
		var now_number = $(this).parent().data("now_number");
		var temp = now_number - page_group_max_count;
		if( temp >= 0){
			var page_num = Math.floor(temp/page_group_max_count) * page_group_max_count;
			//페이지 호출
			setList(page_num, now_limit);
		}else{
			alert("이동할 페이지가 없습니다.");
		}
	});
	target.on("click", "#page_right", function(){
		var now_number = $(this).parent().data("now_number");
		var temp = Math.floor(now_number/page_group_max_count) * page_group_max_count + page_group_max_count;
		if( temp <= Math.ceil(total_count/now_limit)-1){
			var page_num = temp;
			//페이지 호출
			setList(page_num, now_limit);
		}else{
			alert("이동할 페이지가 없습니다.");
		}
	});
}

function setList(now_page, now_limit){
	var ul_start = "<ul name='board'>";
	var ul_start_zero = "<ul name='zero'>";
	var ul_li_col1_start = "<li class='col1' data-bid='";
	var ul_li_col1_middle = "'>";
	var ul_li_col1_end = "</li>";
	var ul_li_col2_start = "<li class='col2'>";
	var ul_li_col2_end = "</li>";
	var ul_li_col3_start = "<li class='col3'>";
	var ul_li_col3_end = "</li>";
	var ul_li_col4_start = "<li class='col4'>";
	var ul_li_col4_end = "</li>";
	var ul_end = "</ul>";
	
	var postJsonData = {
		page : now_page,
		limit : now_limit,
		search_val : g_search_val
	};
	$.post( g_apiUrlRoot+"board_notice_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			
			var list = $("#common_room_list")
			$("#common_room_list").children("ul~ul[name=board]").remove();
			$("#common_room_list").children("ul~ul[name=zero]").remove();
			if(dataJson.board.length == 0){
				list.append(
					ul_start_zero
					+ ul_li_col1_start
					+ ul_li_col1_middle
					+ ul_li_col1_end
					+ ul_li_col2_start
					+ "공지사항이 없습니다."
					+ ul_li_col2_end
					+ ul_li_col3_start
					+ ul_li_col3_end
					+ ul_li_col4_start
					+ ul_li_col4_end
					+ ul_end
				);	
			}
			for(var i=0; i<dataJson.board.length;i++){
				list.append(
					ul_start
					+ ul_li_col1_start
					+ dataJson.board[i].id
					+ ul_li_col1_middle
					+ dataJson.board[i].id
					+ ul_li_col1_end
					+ ul_li_col2_start
					+ dataJson.board[i].title
					+ ul_li_col2_end
					+ ul_li_col3_start
					+ dataJson.board[i].reg_datetime
					+ ul_li_col3_end
					+ ul_li_col4_start
					+ dataJson.board[i].hits
					+ ul_li_col4_end
					+ ul_end
				);
			}
	
			//전역 변수 설정
			g_now_page = now_page;
			g_now_limit = now_limit;
			var total_count = parseInt(dataJson.total_count,10);
			g_max_page = Math.ceil(total_count/now_limit);
			
			//검색어 설정
			$("#common_reserve_search input[type=text]").val(g_search_val);
			
			//페이징 만들기
			setPaging(now_page, now_limit, total_count, 5, $("#common_reserve_page"));
			
		} else {
			alert('공지사항을 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
}
$(document).ready(function() {
	$("#common_room_list").on("click", "ul~ul[name=board]", function(){
		//location.href = "./content.php";
		var hit_num = parseInt($(this).children(".col4").text(),10);
		$(this).children(".col4").text(++hit_num);
		
		localStorage.setItem("com.facelink.contack.list.page_num",g_now_page)
		localStorage.setItem("com.facelink.contack.list.search_val", g_search_val);
		
		location.href = "./content.php?bid=" + $(this).children(".col1").data("bid");
	});
	
	$("#search_btn").click(function(){
		g_search_val = $(this).parent().children("input[type=text]").val();
		g_now_page = 0;
		setList(g_now_page, g_now_limit);
	});
	
	//기본 선택 설정
	g_now_page = localStorage.getItem("com.facelink.contack.list.page_num");
	g_search_val = localStorage.getItem("com.facelink.contack.list.search_val");
	if(g_now_page != null){
		localStorage.removeItem("com.facelink.contack.list.page_num");
		localStorage.removeItem("com.facelink.contack.list.search_val");
	}else{
		g_now_page = 0;
		g_search_val = '';
	}
	
	setList(g_now_page, g_now_limit);
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
            <!--
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
            -->
		</div>
		<div id="common_reserve_page">
        	<!--
			<div class="page_group">
				<span class="page_left">◀</span>
				<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
				<span class="page_right">▶</span>
			</div>
            -->
		</div>
		<div id="common_reserve_search">
			<input type="text" class="input_search"><input id="search_btn" type="button" class="btn_search">
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>