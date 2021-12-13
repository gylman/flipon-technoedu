<!-- My FaceLink > 쪽지 > 보낸 쪽지함 -->
<style>
#send_note { }
#send_note ul~ul { cursor:pointer; }
#send_note .title { border:1px solid #848586; }
#send_note .col1 { width:5%; text-align:center; }
#send_note .col2 { width:15%; text-align:left; padding-left:20px; }
#send_note .col3 { width:50%; text-align:left; padding-left:20px; overflow:hidden;}
#send_note .col4 { width:15%; text-align:center; }
#send_note .col5 { width:15%; text-align:center; }

/* 팝업창 - 쪽지보기 */
#send_note_content { position:absolute; display:none; right:50%; top:50%; margin-top:-260px; width:400px; height:400px; background:white; border:1px solid #454545; }
#send_note_content > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#send_note_content > p > span { float:right; margin:0px; padding:0px; }
#send_note_content > p > span > img { vertical-align:middle; cursor:pointer; }
#send_note_content > ul { width:100%; }
#send_note_content > ul > li { padding:2px 0px; }
#send_note_content > ul > li > span { display:inline-block; width:50px; margin:5px 10px 5px 10px; font-weight:bold; border-right:1px solid #c4c4c4; }
#send_note_content > ul > li > textarea { width:98%; height:210px; border:1px solid #c4c4c4; }
#send_note_content #common_btn_area { width:170px; }
</style>

<script type="text/javascript">
//전역변수
var g_send_now_page = 0;
var g_send_max_page = 0;
var g_send_now_limit = 10;

function initSendList(){
	//첫 쪽지 리스트 가져옴
	var temp_page = localStorage.getItem("com.facelink.mypage.note_tap2.page_num");
	if(temp_page != null){
		g_send_now_page = temp_page;
		localStorage.removeItem("com.facelink.mypage.note_tap2.page_num");
	}
	g_send_now_page = 0;
	setSendList(g_send_now_page, g_send_now_limit);
}

function setSendList(now_page, now_limit){
	//보낸 쪽지함 리스트 가져오기
	var send_ul_start = "<ul name='ul_msg'>";
	var send_ul_li_col1_start = "<li class='col1'><input type='checkbox' name='send_msg_checkbox' data-to_id='";
	var send_ul_li_col1_middle_1 = "' data-from_id='";
	var send_ul_li_col1_middle_2 = "' data-datetime='";
	var send_ul_li_col1_end = "'></li>";
	var send_ul_li_col2_start = "<li class='col2' name='send_msg'>"
	var send_ul_li_col2_end = "</li>";
	var send_ul_li_col3_start = "<li class='col3' name='send_msg'>"
	var send_ul_li_col3_end = "</li>";
	var send_ul_li_col4_start = "<li class='col4' name='send_msg'>"
	var send_ul_li_col4_end = "</li>";
	var send_ul_li_col5_start = "<li class='col5' name='send_msg'>"
	var send_ul_li_col5_end = "</li>";
	var send_ul_end = "</ul>";
	var postJsonData = {
		user_id : g_user_id,
		page : now_page,
		limit : now_limit
	};
	$.post( g_apiUrlRoot+"msg_send_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			var list = $("#send_note #common_room_list");
			//초기화
			list.children("[name='ul_msg']").remove();
			//리스트 그리기
			for(var i=0; i<dataJson.msg.length;i++){
				var is_non_read = dataJson.msg[i].read_datetime == "0000-00-00 00:00:00";
				var read_datetime = is_non_read ? "읽지않음":dataJson.msg[i].read_datetime;
				
				list.append(
					send_ul_start
					+ send_ul_li_col1_start
					+ dataJson.msg[i].to_id
					+ send_ul_li_col1_middle_1
					+ dataJson.msg[i].from_id
					+ send_ul_li_col1_middle_2
					+ dataJson.msg[i].reg_datetime
					+ send_ul_li_col1_end
					+ send_ul_li_col2_start
					+ dataJson.msg[i].to_name + "(" + dataJson.msg[i].to_id + ")"
					+ send_ul_li_col2_end
					+ send_ul_li_col3_start
					+ dataJson.msg[i].message
					+ send_ul_li_col3_end
					+ send_ul_li_col4_start
					+ dataJson.msg[i].reg_datetime
					+ send_ul_li_col4_end
					+ send_ul_li_col5_start
					+ read_datetime
					+ send_ul_li_col5_end
					+ send_ul_end
					);
			}
				
			$('#send_note_cnt').html('('+dataJson.total_count+')');

			//전역 변수 설정
			g_send_now_page = now_page;
			g_send_now_limit = now_limit;
			var total_count = parseInt(dataJson.total_count,10);
			g_send_max_page = Math.ceil(total_count/now_limit);
			
			//페이징 만들기
			setSendPaging(now_page, now_limit, total_count, 5, $("#send_note~#common_reserve_page"));
			
		} else {
			alert('쪽지 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
}

function setSendPaging(now_page, now_limit, total_count, page_group_max_count, target){
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
			setSendList(target_number, now_limit);
		}
	});
	target.on("click", "#page_left", function(){
		var now_number = $(this).parent().data("now_number");
		var temp = now_number - page_group_max_count;
		if( temp >= 0){
			var page_num = Math.floor(temp/page_group_max_count) * page_group_max_count;
			//페이지 호출
			setSendList(page_num, now_limit);
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
			setSendList(page_num, now_limit);
		}else{
			alert("이동할 페이지가 없습니다.");
		}
	});
}

$(document).ready(function() {
	//전체 체크박스 이벤트
	$("#checkbox_send_all").click(function() {
		var isChecked = $(this).is(":checked");
		$("input[name=send_msg_checkbox]").each(function() {
			//$(this).attr("checked", isChecked);
			this.checked = isChecked;
		});
    });
	
	//삭제
	$("#send_del_btn").click(function(){
		var msg_max_size = $("input[name=send_msg_checkbox]:checked").size();
		if(msg_max_size < 1){
			alert("삭제할 쪽지를 선택해주세요.");
		}
		else if(confirm("삭제하시면 복구할 수 없습니다.\n정말 삭제하시겠습니까??") == true){
			var msg_now_size = 0;
			var msg_success_size = 0;
			$("input[name=send_msg_checkbox]:checked").each(function(){
				//var thisCheckBox = $(this);
				var postJsonData = {
					to_id : $(this).data("to_id"),
					from_id : $(this).data("from_id"),
					datetime : $(this).data("datetime")
				};
				$.post( g_apiUrlRoot+"msg_remove.php", postJsonData, function( dataJson) {
					
					if (dataJson.rt_code == 0) {
						//thisCheckBox.parent().parent().remove();
						msg_now_size++;
						msg_success_size++;
						if(msg_now_size == msg_max_size){
							if($("input[name=send_msg_checkbox]").size() == msg_max_size && (g_send_max_page-1) == g_send_now_page){
								g_send_now_page = g_send_now_page - 1;
								if(g_send_now_page < 0) g_send_now_page = 0;
							}
							localStorage.setItem("com.facelink.mypage.note_tap", "2");
							localStorage.setItem("com.facelink.mypage.note_tap2.page_num", g_send_now_page);
							location.reload();
						}
					} else {
						msg_now_size++;
						alert('쪽지 삭제에 실패하였습니다.\n잠시 후 다시 시도해주세요.');
						if(msg_now_size == msg_max_size && msg_success_size > 0){
							if($("input[name=send_msg_checkbox]").size() == msg_now_size && (g_send_max_page-1) == g_send_now_page){
								g_send_now_page = g_send_now_page - 1;
								if(g_send_now_page < 0) g_send_now_page = 0;
							}
							localStorage.setItem("com.facelink.mypage.note_tap", "2");
							localStorage.setItem("com.facelink.mypage.note_tap2.page_num", g_send_now_page);
							location.reload();
						}
					}
				}, "json");
			});
		}
	});
	
	/* 쪽지보기 */
	$("#send_note").on("click","ul~ul [name=send_msg]",function(){
		var name = $(this).parent().children(".col2").text();
		var msg = $(this).parent().children(".col3").text();
		var date = $(this).parent().children(".col4").text();
		
		$("#send_receiver_name").html("<span>받는이</span>"+name+" ("+date+")");

		var newMsg = msg.replace(new RegExp("&nbsp;", 'g')," ");
		$("#send_msg").val(newMsg);
		
		var to_id = $(this).parent().children(".col1").children("input").data("to_id");
		var from_id = $(this).parent().children(".col1").children("input").data("from_id");
		var datetime = $(this).parent().children(".col1").children("input").data("datetime");
		$("#send_note_del").data("to_id",to_id);
		$("#send_note_del").data("from_id",from_id);
		$("#send_note_del").data("datetime",datetime);
		
		$("#send_note_content").show();
	});
	$("#send_note ul~ul").click(function(){ $("#send_note_content").show(); });
	$("#send_note_content #close").click(function(){ $("#send_note_content").hide(); });
	$("#send_note_ok").click(function(){ $("#send_note_content").hide(); });
	$("#send_note_del").click(function(){
		if(confirm("삭제하시면 복구할 수 없습니다.\n정말 삭제하시겠습니까??") == true){
			var postJsonData = {
				to_id : $(this).data("to_id"),
				from_id : $(this).data("from_id"),
				datetime : $(this).data("datetime")
			};
			$.post( g_apiUrlRoot+"msg_remove.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					if($("input[name=send_msg_checkbox]").size() == 1 && (g_send_max_page-1) == g_send_now_page){
						g_send_now_page = g_send_now_page - 1;
						if(g_send_now_page < 0) g_send_now_page = 0;
					}
					localStorage.setItem("com.facelink.mypage.note_tap", "2");
					localStorage.setItem("com.facelink.mypage.note_tap2.page_num", g_send_now_page);
					location.reload();
				} else {
					alert('쪽지 삭제에 실패하였습니다.\n잠시 후 다시 시도해주세요.');
					localStorage.setItem("com.facelink.mypage.note_tap", "2");
					localStorage.setItem("com.facelink.mypage.note_tap2.page_num", g_send_now_page);
					location.reload();
				}
			}, "json");
		}
	});
	
	//리스트 초기화
	initSendList();
	
});	
</script>

<div id="send_note">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1"><input id="checkbox_send_all" type="checkbox"></li>
			<li class="col2">이름</li>
			<li class="col3">내용</li>
			<li class="col4">날짜</li>
			<li class="col5">확인</li>
		</ul>
        <!--
		<ul>
			<li class="col1"><input type="checkbox"></li>
			<li class="col2">홍길동</li>
			<li class="col3">2014년 10월 30일 회의 시간 어떠신가요?</li>
			<li class="col4">2010.10.26</li>
		</ul>
        -->
	</div>
</div>
<p style="display:block; height:30px; "><input id="send_del_btn" type="button" class="btn_small darkgray" value="삭제" style="float:right;"></p>
<div id="common_reserve_page">
	<!--
	<div class="page_group">
		<span class="page_left">◀</span>
		<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
		<span class="page_right">▶</span>
	</div>
    -->
</div>


<!---------------------------------------------------------------------------------------------------------------------------------->
<!-- 팝업창 : 쪽지보기 -->
<div id="send_note_content">
	<p class="subject">쪽지 보기<span><img src="../images/close.png" id="close"></span></p>
	<ul>
    	<li>
        	<span>보낸이</span>나
		</li>
		<!--
        <li><span>보낸이</span>홍길동 (2014-10-28 15:30)</li>
        -->
        <li id="send_receiver_name"></li>
		<li><textarea id="send_msg" readonly></textarea></li>
		<li id="common_btn_area">
			<input type="button" id="send_note_ok" value="확인" class="btn_small blue">
			<input type="button" id="send_note_del" value="삭제" class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 쪽지보기 -->
