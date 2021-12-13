<!-- My FaceLink > 친구 > 메세지 -->
<style>
#rev_msg { margin-top:10px; }
#rev_msg .col1 { width:80%; text-align:left; padding-left:20px; }
#rev_msg .col2 { width:10%; text-align:center; }
#rev_msg .col3 { width:10%; text-align:center; }


#send_msg { margin-top:50px; }
#send_msg .col1 { width:90%; text-align:left; padding-left:20px; }
#send_msg .col2 { width:10%; text-align:center; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	var invite_cnt = 0;
	
	//받은 신청 조회
	var ul_start = "<ul>";
	var ul_li_col_01_start = "<li class='col1'>";
	var ul_li_col_01_end = "</li>";
	var ul_li_col_02_start = "<li class='col2'><input type='button' class='btn_small lightgray' value='수락' data-user_id='";
	var ul_li_col_02_end = "'></li>";
	var ul_li_col_03_start = "<li class='col3'><input type='button' class='btn_small lightgray' value='무시' data-user_id='";
	var ul_li_col_03_end = "'></li>";
	var ul_end = "</ul>";
	var postJsonData = {
		user_id : g_user_id
	};
	$.post( g_apiUrlRoot+"friend_request_list.php", postJsonData, function( dataJson) {	
		if (dataJson.rt_code == 0) {
			var list = $("#rev_msg #common_room_list");
			invite_cnt += dataJson.friend.length;
			$('#invite_msg_cnt').html(invite_cnt);
			for(var i=0; i<dataJson.friend.length;i++){
				list.append(
					ul_start
					+ ul_li_col_01_start
					+ dataJson.friend[i].name + "(" + dataJson.friend[i].id + ")" + " 소속명:" + dataJson.friend[i].part
					+ ul_li_col_01_end
					+ ul_li_col_02_start
					+ dataJson.friend[i].id
					+ ul_li_col_02_end
					+ ul_li_col_03_start
					+ dataJson.friend[i].id
					+ ul_li_col_03_end
					+ ul_end
					);
			}
		} else {
			alert('사용자 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	//보낸신청 조회
	var send_ul_start = "<ul>";
	var send_ul_li_col_01_start = "<li class='col1'>";
	var send_ul_li_col_01_end = "</li>";
	var send_ul_li_col_02_start = "<li class='col2'><input type='button' class='btn_small lightgray' value='취소' data-user_id='";
	var send_ul_li_col_02_end = "'></li>";
	var send_ul_end = "</ul>";
	var postJsonData = {
		user_id : g_user_id
	};
	$.post( g_apiUrlRoot+"friend_list.php", postJsonData, function( dataJson) {	
		if (dataJson.rt_code == 0) {
			var list = $("#send_msg #common_room_list");
			for(var i=0; i<dataJson.friend.length;i++){
				//친구 신청 중일때
				if(dataJson.friend[i].status == 'wait'){
					list.append(
						send_ul_start
						+ send_ul_li_col_01_start
						+ dataJson.friend[i].name + "(" + dataJson.friend[i].id + ")" + " 소속명:" + dataJson.friend[i].part
						+ send_ul_li_col_01_end
						+ send_ul_li_col_02_start
						+ dataJson.friend[i].id
						+ send_ul_li_col_02_end
						+ send_ul_end
						);

					invite_cnt++;
				}
			}
			$('#invite_msg_cnt').html(invite_cnt);
		} else {
			alert('사용자 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	//받은 신청 - 수락, 무시 버튼
	$("#rev_msg #common_room_list").on("click", "input[type=button]", function(){
		var user_id = $(this).data("user_id");
		var parent = $(this).parent().parent();
		//수락 버튼
		if($(this).val() == "수락"){
			var postJsonData = {
				user_id : user_id,
				friend_id : g_user_id,
				status : 'done'
			};
			$.post( g_apiUrlRoot+"friend_status_change.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					alert(parent.children(".col1").text()+" 와 친구가 되었습니다.");
					//parent.remove();
					localStorage.setItem("com.facelink.mypage.friend_tap", "3");
					location.reload();
				}
				else {
					alert('친구 수락에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		}
		//무시 버튼
		else{
			var postJsonData = {
				user_id : user_id,
				friend_id : g_user_id
			};
			$.post( g_apiUrlRoot+"friend_remove.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					alert(parent.children(".col1").text()+" 의 친구 신청이 무시되었습니다.");
					//parent.remove();
					localStorage.setItem("com.facelink.mypage.friend_tap", "3");
					location.reload();
				}
				else {
					alert('친구 무시에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		}
	});
	
	//보낸 신청 - 신청 취소 버튼
	$("#send_msg #common_room_list").on("click", "input[type=button]", function(){
		var user_id = $(this).data("user_id");
		var parent = $(this).parent().parent();
		//친구에서 삭제
		var postJsonData_friend = {
			user_id : g_user_id,
			friend_id : user_id
		};
		$.post( g_apiUrlRoot+"friend_remove.php", postJsonData_friend, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				alert(parent.children(".col1").text()+" 의 친구 신청이 취소되었습니다.");
				//parent.remove();
				localStorage.setItem("com.facelink.mypage.friend_tap", "3");
				location.reload();
			}
			else {
				alert('신청 취소에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
			}
		}, "json");
	});
});	
</script>

<div id="rev_msg">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">받은 신청</li>					
			<li class="col2">수락</li>
			<li class="col3">무시</li>
		</ul>
        <!--
		<ul>
			<li class="col1">홍길동(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="수락" data-user-name="test"></li>
			<li class="col3"><input type="button" class="btn_small lightgray" value="무시"></li>
		</ul>
		<ul>
			<li class="col1">이순신(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="수락"></li>
			<li class="col3"><input type="button" class="btn_small lightgray" value="무시"></li>
		</ul>
        -->
	</div>
</div>

<div id="send_msg">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">보낸 신청</li>
			<li class="col2">취소</li>
		</ul>
        <!--
		<ul>
			<li class="col1">홍길동(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="취소"></li>
		</ul>
		<ul>
			<li class="col1">이순신(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="취소"></li>
		</ul>
        -->
	</div>
</div>
