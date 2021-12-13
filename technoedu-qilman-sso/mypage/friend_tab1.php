<!-- My FaceLink > 친구 > 친구관리 -->
<style>
/* 친구 관리 */
#group_area { float:left; width:40%; }
#member_area { float:right; width:55%; }

div > p:nth-child(1) { height:20px; padding-left:20px; margin-bottom:5px; font-weight:bold; }
#list { width:100%; height:300px; overflow-y:scroll; padding:20px; border-radius:10px; border:1px solid #c4c4c4;  }
#group_area #list > li { height:30px; line-height:30px; margin:0px 10px; border-bottom:1px solid #c4c4c4; }

#member_area #list > li { float:left; width:48%; padding:10px; margin-right:10px; margin-bottom:10px; border:1px solid #c4c4c4; }
#member_area #list > li > p { height:20px; line-height:20px; margin:0px 10px; }
#member_area #list > li > p:nth-child(1) > input[type=checkbox] { margin-right:10px; }
#member_area #list > li > p:nth-child(2) { padding-left:26px; }

#member_area > div > span:nth-child(1) { display:inline-block; float:left; }
#member_area > div > span:nth-child(2) { display:inline-block; float:right; }

/* 팝업창 - 친구관리 : 친구추가 */
#add_friend_page { position:absolute; display:none; left:50%; top:50%; margin-left:-200px; margin-top:-260px; width:400px; height:400px; background:white; border:1px solid #454545; }
#add_friend_page > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#add_friend_page > p > span { float:right; margin:0px; padding:0px; }
#add_friend_page > p > span > img { vertical-align:middle; cursor:pointer; }
#add_friend_page > #search { padding:10px; }
#add_friend_page > #search select { width:80px; height:34px; border:1px solid #d3d3d3; vertical-align:top;}
#add_friend_page > #user { width:94%; height:220px; padding:10px; margin:0px 10px; border:1px solid #d3d3d3; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#add_friend_page > #user > li { height:30px; line-height:30px; border-bottom:1px solid #e0e0e0; }
#add_friend_page > #user > li > span { }
#add_friend_page > #user > li > span.name { margin-left:10px; }
#add_friend_page > #user > li > span.group { margin-left:10px; }

/* 팝업창 - 친구관리 : 쪽지 보내기 */
#send_letter_page { position:absolute; display:none; left:50%; top:50%; margin-left:-200px; margin-top:-260px; width:400px; height:350px; background:white; border:1px solid #454545; }
#send_letter_page > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#send_letter_page > p > span { float:right; margin:0px; padding:0px; }
#send_letter_page > p > span > img { vertical-align:middle; cursor:pointer; }
#send_letter_page > ul { width:100%; }
#send_letter_page > ul > li { padding:2px 0px; }
#send_letter_page > ul > li > span { display:inline-block; width:50px; margin:5px 10px 5px 10px; font-weight:bold; border-right:1px solid #c4c4c4; }
#send_letter_page > ul > li > textarea { width:98%; height:150px; margin-top:10px; border:1px solid #c4c4c4; }

/* 팝업창 - 친구관리 : 이동 */
#move_page { position:absolute; display:none; left:50%; top:50%; margin-left:-200px; margin-top:-260px; width:400px; height:350px; background:white; border:1px solid #454545; }
#move_page > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#move_page > p > span { float:right; margin:0px; padding:0px; }
#move_page > p > span > img { vertical-align:middle; cursor:pointer; }
#move_page > #user { width:94%; height:220px; padding:10px; margin:10px; border:1px solid #d3d3d3; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#move_page > #user > li { height:30px; line-height:30px; border-bottom:1px solid #e0e0e0; }

/* 팝업창 - 친구관리 : 그룹삭제 */
#del_group_page { position:absolute; display:none; left:50%; top:50%; margin-left:-150px; margin-top:-100px; width:300px; height:200px; background:white; border:1px solid #454545; }
#del_group_page > p.subject { height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white; }
#del_group_page > p > span { float:right; margin:0px; padding:0px; }
#del_group_page > p > span > img { vertical-align:middle; cursor:pointer; }
#del_group_page > ul { width:100%; }
#del_group_page > ul > li:nth-child(1) { padding:20px 0px; text-align:center; }

/* 팝업창 - 친구관리 : 친구삭제 */
#del_friend_page { position:absolute; display:none; left:50%; top:50%; margin-left:-150px; margin-top:-100px; width:300px; height:200px; background:white; border:1px solid #454545; }
#del_friend_page > p.subject { height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white; }
#del_friend_page > p > span { float:right; margin:0px; padding:0px; }
#del_friend_page > p > span > img { vertical-align:middle; cursor:pointer; }
#del_friend_page > ul { width:100%; }
#del_friend_page > ul > li:nth-child(1) { padding:20px 0px; text-align:center; }

/* 버튼영역 중앙정렬을 위한 재설정 */
#common_btn_area { width:80px; }
</style>

<script type="text/javascript">
//현재 그룹 ID, 이름
var now_group_id;
var now_group_name;

//그룹의 친구 리스트 설정 함수
function setFriendList(){
	
	$("#member_area p[name=group_name]").text(now_group_name);
	$("#member_area #list").text('');
	
	var friend_li_start = "<li>";
	var friend_li_start_wait = "<li style='background:lightgray'>";
	var friend_li_p_01_start = "<p><input type='checkbox' data-friend_id='";
	var friend_li_p_01_middle = "'>";
	var friend_li_p_01_end = "</p>";
	var friend_li_p_02_start = "<p>";
	var friend_li_p_02_end = "</p>";
	var friend_li_end = '</li>';
	
	//전체 친구 조회
	if(now_group_id == "0"){
		//그룹에서 삭제 버튼 숨김
		$("#del_group").hide();
		var postJsonData = {
			user_id : g_user_id
		};
		
		$.post( g_apiUrlRoot+"friend_list.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				var list = $("#member_area #list");
				list.text('');
				for(var i=0; i<dataJson.friend.length;i++){
					//친구 신청 중일때
					if(dataJson.friend[i].status == 'wait'){
						list.append(
							friend_li_start_wait
							+ friend_li_p_02_start
							+ dataJson.friend[i].name +"("+dataJson.friend[i].id+")" + " - 수락 대기중"
							+ friend_li_p_01_end
							+ friend_li_p_02_start
							+ " 소속명:" + dataJson.friend[i].part
							+ friend_li_p_02_end
							+ friend_li_end
							);
					}
					//맞친 일때
					else{
						list.append(
							friend_li_start
							+ friend_li_p_01_start
							+ dataJson.friend[i].id
							+ friend_li_p_01_middle
							+ dataJson.friend[i].name +"("+dataJson.friend[i].id+")"
							+ friend_li_p_01_end
							+ friend_li_p_02_start
							+ " 소속명:" + dataJson.friend[i].part
							+ friend_li_p_02_end
							+ friend_li_end
						);
					}
				}
			} else {
				alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	}
	//그룹 친구 조회
	else{
		//그룹에서 삭제 버튼 나타남
		$("#del_group").show();
		var postJsonData = {
			group_id : now_group_id
		};
		
		$.post( g_apiUrlRoot+"group_friend_list.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				var list = $("#member_area #list");
				list.text('');
				for(var i=0; i<dataJson.friend.length;i++){
					//친구 신청 중일때
					if(dataJson.friend[i].status == 'wait'){
						list.append(
							friend_li_start_wait
							+ friend_li_p_02_start
							+ dataJson.friend[i].name +"("+dataJson.friend[i].id+")" + " - 수락 대기중"
							+ friend_li_p_01_end
							+ friend_li_p_02_start
							+ " 소속명:" + dataJson.friend[i].part
							+ friend_li_p_02_end
							+ friend_li_end
							);
					}
					//맞친 일때
					else{
						list.append(
							friend_li_start
							+ friend_li_p_01_start
							+ dataJson.friend[i].id
							+ friend_li_p_01_middle
							+ dataJson.friend[i].name +"("+dataJson.friend[i].id+")"
							+ friend_li_p_01_end
							+ friend_li_p_02_start
							+ " 소속명:" + dataJson.friend[i].part
							+ friend_li_p_02_end
							+ friend_li_end
							);
					}
				}
			} else {
				alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	}
}


$(document).ready(function() {
	
	/* 친구추가 */
	$("#add_friend").click(function(){
		//체크박스 초기화
		$("#user input[type=checkbox]").each(function() {
			this.checked = false;
		});
		//페이지 나타남
		$("#add_friend_page").show();
	});
	$("#add_friend_page #close").click(function(){ $("#add_friend_page").hide(); });	
	$("#add_ok").click(function(){
		var max_size = $("#user input[type=checkbox]:checked").size();
		var now_size_all = 0;
		var now_size = 0;
		var success_size = 0;
		if(max_size == 0){
			alert("추가할 친구를 선택해 주세요.");
			return;
		}
		$("#user input[type=checkbox]:checked").each(function() {
			var friend_id = $(this).data("friend_id");
			var friend_name = $(this).parent().text();
			
			//1.전체 친구 추가
			var postJsonData_friend = {
				user_id : g_user_id,
				friend_id : friend_id
			};
			$.post( g_apiUrlRoot+"friend_add.php", postJsonData_friend, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					now_size_all++;
					if(now_size_all == max_size && now_group_id == 0){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}else if(dataJson.rt_code == 2000){
					if(now_group_id == 0){
						alert(friend_name+'(ID:'+friend_id+')는 이미 추가되어 있습니다.');
						now_size_all++;
						if(now_size_all == max_size){
							localStorage.setItem("com.facelink.mypage.friend_tap", "1");
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
							location.reload();
						}
					}
					
				}
			}, "json");
			
			//전체 그룹에서 친구를 추가하였으면, 친구 추가만하고 아래는 skip
			if(now_group_id != "0"){
				//2.그룹에 친구 추가
				var postJsonData_group = {
					group_id : now_group_id,
					friend_id : friend_id
				};
				$.post( g_apiUrlRoot+"group_friend_add.php", postJsonData_group, function( dataJson) {
					
					if (dataJson.rt_code == 0) {
						now_size++;
						success_size++;
						if(now_size == max_size){
							localStorage.setItem("com.facelink.mypage.friend_tap", "1");
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
							location.reload();
						}
					}else if(dataJson.rt_code == 2000){
						alert(friend_name+'(ID:'+friend_id+')는 이미 해당 그룹에 추가되어 있습니다.');
						now_size++;
						if(now_size == max_size && success_size > 0){
							localStorage.setItem("com.facelink.mypage.friend_tap", "1");
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
							localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
							location.reload();
						}
					}
					else {
						alert('친구 추가에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
					}
				}, "json");
			}
		});
		$("#add_friend_page").hide();
	});

	/* 쪽지 보내기 */
	$("#send_letter").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		if(max_size == 0){
			alert("쪽지를 보낼 친구를 선택해 주세요.");
			return;
		}
		
		var receiver_name = "";
		var receiver_id_list = "";
		var isStart = true;
		$("#member_area input[type=checkbox]:checked").each(function() {
			
			if(isStart){
				receiver_name = $(this).parent().text();
				receiver_id_list = $(this).data("friend_id");
				isStart = false;
			}else{
				receiver_name = receiver_name + ", " + $(this).parent().text();
				receiver_id_list = receiver_id_list + "/" + $(this).data("friend_id");
			}
            
        });
		$("#send_letter_page #sender").text('');
		$("#send_letter_page #receiver").text('');
		$("#send_letter_page #sender").append("<span>보낸이</span>"+g_user_name);
		$("#send_letter_page #receiver").append("<span>받는이</span>"+receiver_name);
		$("#send_letter_page #receiver").data("receiver_id_list",receiver_id_list);
		$("#msg").val('');
		
		$("#send_letter_page").show();
	});
	$("#send_letter_page #send_letter_ok").click(function(){
		var msg_text = $("#msg").val();
		var trim_msg = $.trim(msg_text);
		if(trim_msg == ""){
			alert("보낼 내용을 입력해주세요.");
		}else{
			var receiver_id_list = $("#send_letter_page #receiver").data("receiver_id_list").split("/");
			var receiver_max_size = receiver_id_list.length;
			var success_size = 0;
			var error_size = 0;
			for(var i in receiver_id_list){
				var postJsonData = {
					to_id : receiver_id_list[i],
					from_id : g_user_id,
					msg : msg_text
				};
				$.post( g_apiUrlRoot+"msg_send.php", postJsonData, function( dataJson) {
					if (dataJson.rt_code == 0) {
						success_size++;
						if(receiver_max_size == success_size+error_size){
							alert("쪽지가 전송되었습니다.\n성공:"+success_size+"  "+"실패:"+error_size);
							$("#send_letter_page").hide();
						}
					}
					else {
						error_size++;
						if(receiver_max_size == success_size+error_size){
							alert("쪽지가 전송되었습니다.\n성공:"+success_size+"  "+"실패:"+error_size);
							$("#send_letter_page").hide();
						}
					}
				}, "json");
			}
		}
	});
	$("#send_letter_page #close").click(function(){ $("#send_letter_page").hide(); });

	/* 이동 */
	$("#move").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		if(max_size == 0){
			alert("이동할 친구를 선택해 주세요.");
			return;
		}
		$("#move_page").show();
	});
	$("#move_page #move_page_move").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		var now_size = 0;
		var success_size = 0;
		if(max_size == 0){
			alert("이동할 친구를 선택해 주세요.");
			return;
		}
		$("#member_area input[type=checkbox]:checked").each(function() {
			var friend_id = $(this).data("friend_id");
			var friend_name = $(this).parent().text();

			//1.기존 그룹 친구 삭제
			var postJsonData_remove = {
				group_id : now_group_id,
				friend_id : friend_id
			};
			$.post( g_apiUrlRoot+"group_friend_remove.php", postJsonData_remove, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
				}else if(dataJson.rt_code == 2000){
				}
				else {
				}
			}, "json");
			
			//2.새로운 그룹에 친구 등록
			var new_group_id = $("input:radio[name=move_page_gruop]:checked").data("group_id");
			var postJsonData_add = {
				group_id : new_group_id,
				friend_id : friend_id
			};
			$.post( g_apiUrlRoot+"group_friend_add.php", postJsonData_add, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					now_size++;
					success_size++;
					if(now_size == max_size){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}else if(dataJson.rt_code == 2000){
					alert(friend_name+'(ID:'+friend_id+')는 이미 해당 그룹에 추가 되었습니다.');
					now_size++;
					if(now_size == max_size){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}
				else {
					alert('친구 이동에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		});
		$("#move_page").hide();
	});
	$("#move_page #move_page_copy").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		var now_size = 0;
		var success_size = 0;
		if(max_size == 0){
			alert("복사할 친구를 선택해 주세요.");
			return;
		}
		$("#member_area input[type=checkbox]:checked").each(function() {
			var friend_id = $(this).data("friend_id");
			var friend_name = $(this).parent().text();
			
			//1.새로운 그룹에 친구 등록
			var new_group_id = $("input:radio[name=move_page_gruop]:checked").data("group_id");
			var postJsonData_add = {
				group_id : new_group_id,
				friend_id : friend_id
			};
			$.post( g_apiUrlRoot+"group_friend_add.php", postJsonData_add, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					now_size++;
					success_size++;
					if(now_size == max_size){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}else if(dataJson.rt_code == 2000){
					alert(friend_name+'(ID:'+friend_id+')는 이미 해당 그룹에 추가 되었습니다.');
					now_size++;
					if(now_size == max_size && success_size > 0){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}
				else {
					alert('친구 복사에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		});
		$("#move_page").hide();
	});
	$("#move_page #close").click(function(){ $("#move_page").hide(); });

	/* 그룹에서 삭제 */
	$("#del_group").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		if(max_size == 0){
			alert("삭제할 친구를 선택해 주세요.");
			return;
		}else if(now_group_id == "0"){
			alert("전체 그룹에서는 삭제하실 수 없습니다.\n친구 끊기로 진행해 주세요.");
			return;
		}
		$("#del_group_page").show();
	});
	$("#del_group_page #group_del_ok").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		var now_size = 0;
		var success_size = 0;
		if(max_size == 0){
			alert("삭제할 친구를 선택해 주세요.");
			return;
		}
		$("#member_area input[type=checkbox]:checked").each(function() {
			var friend_id = $(this).data("friend_id");
			var friend_name = $(this).parent().text();

			var postJsonData = {
				group_id : now_group_id,
				friend_id : friend_id
			};
			
			$.post( g_apiUrlRoot+"group_friend_remove.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					now_size++;
					success_size++;
					if(now_size == max_size){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}else if(dataJson.rt_code == 2000){
					alert(friend_name+'(ID:'+friend_id+')는 이미 해당 그룹에서 삭제 되었습니다.');
					now_size++;
					if(now_size == max_size && success_size > 0){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}
				else {
					alert('친구 삭제에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		});
		$("#del_group_page").hide();
	});
	$("#del_group_page #close").click(function(){ $("#del_group_page").hide(); });
	
	/* 친구끊기 */	
	$("#del_friend").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		if(max_size == 0){
			alert("삭제할 친구를 선택해 주세요.");
			return;
		}
		$("#del_friend_page").show();
	});
	$("#del_friend_page #friend_del_ok").click(function(){
		var max_size = $("#member_area input[type=checkbox]:checked").size();
		var now_size = 0;
		var success_size = 0;
		if(max_size == 0){
			alert("삭제할 친구를 선택해 주세요.");
			return;
		}
		$("#member_area input[type=checkbox]:checked").each(function() {
			var friend_id = $(this).data("friend_id");
			var friend_name = $(this).parent().text();

			//친구에서 삭제
			var postJsonData_friend = {
				user_id : g_user_id,
				friend_id : friend_id
			};
			$.post( g_apiUrlRoot+"friend_remove.php", postJsonData_friend, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					now_size++;
					success_size++;
					if(now_size == max_size){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}else if(dataJson.rt_code == 2000){
					alert(friend_name+'(ID:'+friend_id+')는 이미 친구에서 삭제 되었습니다.');
					now_size++;
					if(now_size == max_size && success_size > 0){
						localStorage.setItem("com.facelink.mypage.friend_tap", "1");
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_id", now_group_id);
						localStorage.setItem("com.facelink.mypage.friend_tap_1.group_name", now_group_name);
						location.reload();
					}
				}
				else {
					alert('친구 삭제에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		});
		$("#del_group_page").hide();
	});
	$("#del_friend_page #close").click(function(){ $("#del_friend_page").hide(); });
	
	////////////////////////////////
	//전체 사용자 가져오기
	var user_li_start = "<li>";
	var user_li_span_01_start = "<span class='name'><input type='checkbox' data-friend_id='";
	var user_li_span_01_middle = "'>";
	var user_li_span_01_end = "</span>";
	var user_li_span_02_start = "<span class='group'>";
	var user_li_span_02_end = "</span>";
	var postJsonData = {};
	$.post( g_apiUrlRoot+"user_all_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			var user = $("#user");
			user.text('');
			for(var i=0; i<dataJson.user.length;i++){
				//자기 자신은 제외
				if(g_user_id != dataJson.user[i].id){
					user.append(
						user_li_start
						+ user_li_span_01_start
						+ dataJson.user[i].id
						+ user_li_span_01_middle
						+ dataJson.user[i].name +"("+dataJson.user[i].id+")"
						+ user_li_span_01_end
						+ user_li_span_02_start
						+ " 소속명:" + dataJson.user[i].part
						+ user_li_span_02_end
					);
				}
			}
		} else {
			alert('사용자 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	//전체 사용자 가져오기 끝
	////////////////////////////////
	
	////////////////////////////////
	//그룹 리스트 가져오기
	var li_start = "<li style='cursor:pointer'";
	var li_name = "name='group_list' ";
	var li_value_start = "data-group_id='";
	var li_value_end = "'>";
	var li_end = "</li>";
	
	var li_move_page_start = "<li>";
	var li_move_page_input_start = "<input type='radio' name='move_page_gruop' data-group_id='";
	var li_move_page_input_end = "' style='display:inline'/>";
	var li_move_page_end = "</li>";
	
	var postJsonData = {
		user_id : g_user_id
	};
	
	$.post( g_apiUrlRoot+"group_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			//메인 왼쪽 그룹 레이아웃에 추가
			var list = $("#group_area #list");
			//이동 버튼 클릭시 그룹선택 화면에 추가
			var move_list = $("#move_page #user");
			for(var i=0; i<dataJson.group.length;i++){
				list.append(
					li_start
					+ li_name
					+ li_value_start
					+ dataJson.group[i].id
					+ li_value_end
					+ dataJson.group[i].group_name 
					+ li_end
				);
				move_list.append(
					li_move_page_start
					+ li_move_page_input_start
					+ dataJson.group[i].id
					+ li_move_page_input_end
					+ dataJson.group[i].group_name 
					+ li_move_page_end
				);
			}
		} else {
			alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	//리스트 가져오기 끝
	////////////////////////////////
	
	//리스트 동적 버튼 이벤트
	$("#list").on("click", "li[name=group_list]", function(){
		//그룹 id, 이름 저장
		now_group_id = $(this).data("group_id");
		now_group_name = $(this).text();
		
		setFriendList();
	});
	
	//전체 친구 검색
	$("#common_reserve_search input[type=button]").on("click", function(){
		var search_key = $("select[name=search_key]").val();
		var search_val = $.trim($(this).parent().children("input[type=text]").val());
		if(search_val == ""){
			alert("검색어를 입력해주세요.");
		}else{
			var postJsonData = {
				search_key : search_key,
				search_val : search_val
			};
			$.post( g_apiUrlRoot+"search_member.php", postJsonData, function( dataJson) {
				
				var user = $("#user");
				user.text('');
				
				if (dataJson.count > 0) {	
					for(var i=0; i<dataJson.user.length;i++){
						//자기 자신은 제외
						if(g_user_id != dataJson.user[i].id){
							user.append(
								user_li_start
								+ user_li_span_01_start
								+ dataJson.user[i].id
								+ user_li_span_01_middle
								+ dataJson.user[i].name +"("+dataJson.user[i].id+")"
								+ user_li_span_01_end
								+ user_li_span_02_start
								+ " 소속명:" + dataJson.user[i].part
								+ user_li_span_02_end
							);
						}
					}
				}
				else {
					user.append("<li><span class='name'>검색 결과가 없습니다.</li>");
				}
			}, "json");
		}
	});
	
	//기본 선택 설정
	now_group_id = localStorage.getItem("com.facelink.mypage.friend_tap_1.group_id");
	now_group_name = localStorage.getItem("com.facelink.mypage.friend_tap_1.group_name");
	if(now_group_id != null && now_group_name != null){
		localStorage.removeItem("com.facelink.mypage.friend_tap_1.group_id");
		localStorage.removeItem("com.facelink.mypage.friend_tap_1.group_name");
		setFriendList();
	}else{
		now_group_id = "0";
		now_group_name = "전체";
		setFriendList();
	}
});	
</script>

<p style="display:block; height:30px; "><input type="button" id="add_friend" class="btn_small darkgray" value="친구 추가" style="float:right;"></p>
<div id="group_area">
	<p>그룹</p>
	<ul id="list">
		<li style="cursor:pointer" name="group_list" data-group_id="0">전체</li>						
	</ul>
</div>
<div id="member_area">
	<p name="group_name">그룹명</p>
	<ul id="list">
    	<!-- 그룹 구성원 리스트
		<li>
			<p><input type="checkbox">홍길동</p>
			<p>소속명</p>
		</li>
		<li>
			<p><input type="checkbox">홍길동</p>
			<p>소속명</p>
		</li>
		<li>
			<p><input type="checkbox">홍길동</p>
			<p>소속명</p>
		</li>
		<li>
			<p><input type="checkbox">홍길동</p>
			<p>소속명</p>
		</li>
		<li>
			<p><input type="checkbox">홍길동</p>
			<p>소속명</p>
		</ul>
        -->
	</ul>
	<div id="common_btn_area" style="width:100%;">
		<span><input type="button" id="send_letter" class="btn_small blue" value="쪽지보내기"></span>
		<span>
			<input type="button" id="move" class="btn_small gray" value="이동">
			<input type="button" id="del_group" class="btn_small gray" value="그룹에서 삭제">
			<input type="button" id="del_friend" class="btn_small gray" value="친구 끊기">
		</span>
	</div>
</div>


<!---------------------------------------------------------------------------------------------------------------------------------->
<!-- 팝업창 : 친구관리 -->
<div id="add_friend_page">
	<p class="subject">회원검색<span><img src="../images/close.png" id="close"></span></p>
	<div id="search">		
		<span>
			<select name="search_key">
            	<option value="id">아이디</option>
				<option value="name">이름</option>
                <option value="part">소속</option>
                <option value="email">이메일</option>
			</select>
		</span>
		<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
	</div>
	<ul id="user">
    	<!-- 사용자 리스트 -->
	</ul>
	<div id="common_btn_area">
		<input type="button" value="확인" id="add_ok" class="btn_small blue">
		<input type="button" value="취소" id="close" class="btn_small darkgray">	
	</div>
</div>
<!-- 팝업창 : 친구관리 -->

<!-- 팝업창 : 쪽지보내기 -->
<div id="send_letter_page">
	<p class="subject">쪽지 보내기<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li id="sender">
        	<!--<span>보낸이</span>이순신-->
		</li>
		<li id="receiver">
        	<!--<span>받는이</span>홍길동, 김과장, 이부장, 양주임-->
		</li>
		<li><textarea id="msg"></textarea></li>
		<li id="common_btn_area">
			<input type="button" value="보내기" id="send_letter_ok" class="btn_small blue">
			<input type="button" value="취소" id="close" class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 쪽지보내기 -->

<!-- 팝업창 : 이동 -->
<div id="move_page">
	<p class="subject">이동<span><img src="../images/close.png" id="close"></span></p>
	<ul id="user">
    <!--
		<li><input type="radio" name="move_page_gruop" value="0" style='display:inline'/>욱성미디어</li>
		<li><input type="radio" name="move_page_gruop" value="1" style='display:inline'/>욱성미디어</li>
        -->
	</ul>
	<div id="common_btn_area">
		<input type="button" value="이동" id="move_page_move" class="btn_small blue">
		<input type="button" value="복사" id="move_page_copy" class="btn_small darkgray">	
	</div>
</div>
<!-- 팝업창 : 이동 -->

<!-- 팝업창 : 그룹삭제 -->
<div id="del_group_page">
	<p class="subject">그룹에서 삭제<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li>선택한 친구를 [그룹이름] 그룹에서<BR>삭제하시겠습니까?</li>
		<li id="common_btn_area">
			<input type="button" value="확인" id="group_del_ok" class="btn_small blue">
			<input type="button" value="취소" id="close"class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 그룹삭제 -->

<!-- 팝업창 : 친구삭제 -->
<div id="del_friend_page">
	<p class="subject">친구 끊기<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li>선택한 친구를 내 친구에서 <BR>삭제하시겠습니까?</li>
		<li id="common_btn_area">
			<input type="button" value="확인" id="friend_del_ok" class="btn_small blue">
			<input type="button" value="취소" id="close"class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 친구삭제 -->
<!---------------------------------------------------------------------------------------------------------------------------------->
