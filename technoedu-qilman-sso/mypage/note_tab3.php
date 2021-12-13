<!-- My FaceLink > 쪽지 > 쪽지쓰기 -->
<style>
#write_note { }
#write_note > ul {  }
#write_note > ul:first-child { float:left; width:64%; margin:0px; padding:0px; border-right:1px dashed #d3d3d3; }
#write_note > ul:nth-child(2) { float:right; width:350px; margin:0px; padding:0px; }

#write_note > ul:first-child > li { color:#404141; padding-bottom:10px; }
#write_note > ul:first-child > li:nth-child(1) input[type=text] { height:30px; }
#write_note > ul:first-child > li:nth-child(1) select { width:40%; border:1px solid #d3d3d3; height:30px; }

#write_note > ul:first-child > li:nth-child(2) > span { display:inline-block; padding-right:30px; vertical-align:top; }
#write_note > ul:first-child > li:nth-child(2) fieldset { width:250px; height:200px; padding:0px; border:1px solid #d3d3d3; border-radius:5px; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#write_note > ul:first-child > li:nth-child(2) fieldset > input[type=checkbox]{ margin-left:20px; }
#write_note > ul:first-child > li:nth-child(2) fieldset > span { display:inline-block; height:30px; line-height:30px; width:100%; font-size:14px; font-weight:bold; color:#5b5a5a; text-align:center; border-bottom:1px solid #d3d3d3; background:#f5f5f5; }

#write_note > ul:first-child > li:nth-child(2) .LRbtn { width:78px; vertical-align:middle; }
#write_note > ul:first-child > li:nth-child(2) .LRbtn > input[type=button]{ width:78px; height:50px; margin-top:30px; cursor:pointer; }
#write_note > ul:first-child > li:nth-child(2) .btn_right { border:0px; background:url("../images/Rarrow.png") 0 50% no-repeat; }
#write_note > ul:first-child > li:nth-child(2) .btn_left { border:0px; background:url("../images/Larrow.png") 0 50% no-repeat; }

#write_note > ul:nth-child(2) > li > span { padding:0px; margin:0px; }
#write_note > ul:nth-child(2) > li > p { height:30px; margin-top:10px; font-size:14px; font-weight:bold; }
#write_note > ul:nth-child(2) > li textarea { width:98%; height:200px; border:1px solid #d3d3d3; border:1px solid #d3d3d3; border-radius:5px; font-size:12px; }
#write_note > ul:nth-child(2) > li input[type=button] { float:right; margin-top:10px; margin-right:5px; }
</style>
<script type="text/javascript">
function setUserList(now_group_id){
	var user_list_start = "<input type='checkbox' data-user_id='";
	var user_list_middle_01 = "' data-user_name='"
	var user_list_middle_02 = "'> ";
	var user_list_end = "<BR>";
	
	//전체 친구 조회
	if(now_group_id == "0"){
		var postJsonData = {
			user_id : g_user_id
		};
		$.post( g_apiUrlRoot+"friend_list.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				var list = $("#fieldset_user_list");
				list.text('');
				if(dataJson.friend.length == 0){
					list.append("<span>친구가 없습니다.</span>");
				}
				for(var i=0; i<dataJson.friend.length;i++){
					//맞친일때
					if(dataJson.friend[i].status == 'done'){
						list.append(
							user_list_start
							+ dataJson.friend[i].id
							+ user_list_middle_01
							+ dataJson.friend[i].name + "(" + dataJson.friend[i].id +")"
							+ user_list_middle_02
							+ dataJson.friend[i].name + "(" + dataJson.friend[i].id +")"
							+ user_list_end
						);
					}
				}
			}
			else {
				alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	}else{
		var postJsonData = {
			group_id : now_group_id
		};
		$.post( g_apiUrlRoot+"group_friend_list.php", postJsonData, function( dataJson) {
			
			if (dataJson.rt_code == 0) {
				var list = $("#fieldset_user_list");
				list.text('');
				if(dataJson.friend.length == 0){
					list.append("<span>친구가 없습니다.</span>");
				}
				for(var i=0; i<dataJson.friend.length;i++){
					//맞친일때
					if(dataJson.friend[i].status == 'done'){
						list.append(
							user_list_start
							+ dataJson.friend[i].id
							+ user_list_middle_01
							+ dataJson.friend[i].name + "(" + dataJson.friend[i].id +")"
							+ user_list_middle_02
							+ dataJson.friend[i].name + "(" + dataJson.friend[i].id +")"
							+ user_list_end
						);
					}
				}
			}
			else {
				alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
			}
		}, "json");
	}
}


$(document).ready(function() {
	////////////////////////////////
	//그룹 리스트 가져오기
	var option_start = "<option value='";
	var option_middle = "'>";
	var option_end = "</option>";
	
	var postJsonData = {
		user_id : g_user_id
	};
	
	$.post( g_apiUrlRoot+"group_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			var list = $("#write_note select");
			for(var i=0; i<dataJson.group.length;i++){
				list.append(
					option_start
					+ dataJson.group[i].id
					+ option_middle
					+ dataJson.group[i].group_name 
					+ option_end
				);
			}
		} else {
			alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	//리스트 가져오기 끝
	////////////////////////////////
	
	//그룹선택
	$("#select_group").change(function(e) {
		$("#common_reserve_search input[type=text]").val('');
		setUserList($(this).val());
	});
	
	//오른쪽버튼 이벤트
	$("#btn_right").click(function(){
		var temp_size = $("#fieldset_user_list input[type=checkbox]:checked").size();
		if( temp_size == 0 ){
			alert("이동할 친구를 선택해주세요.");
			return;
		}
		
		var user_list_start = "<div style='margin-left:20px;'><input type='checkbox' data-user_id='";
		var user_list_middle_01 = "' data-user_name='"
		var user_list_middle_02 = "'> ";
		var user_list_end = "</div>";
		var list = $("#fieldset_receiver_list");
		$("#fieldset_user_list input[type=checkbox]:checked").each(function() {
			var user_id = $(this).data("user_id");
			//중복 체크
			var isExists = false;
			$("#fieldset_receiver_list input[type=checkbox]").each(function(){
				if(user_id == $(this).data("user_id")){
					isExists = true;
				}
			});
			if(isExists){
				alert($(this).data("user_name")+"는 이미 추가된 친구입니다.");
			}
			else{
				list.append(
					user_list_start
					+ user_id
					+ user_list_middle_01
					+ $(this).data("user_name")
					+ user_list_middle_02
					+ $(this).data("user_name")
					+ user_list_end
				);
			}
        });
	});
	//왼쪽버튼 이벤트
	$("#btn_left").click(function(){
		var temp_size = $("#fieldset_receiver_list input[type=checkbox]:checked").size();
		if( temp_size == 0 ){
			alert("이동할 친구를 선택해주세요.");
			return;
		}
		
		$("#fieldset_receiver_list input[type=checkbox]:checked").each(function() {
			var temp_name = $(this).data("user_name")+"<BR>";
			$(this).parent().remove();
		});
	});
	
	$("#wrtie_send_btn").click(function(){
		var msg_text = $("#write_msg").val();
		var trim_msg = $.trim(msg_text);
		if(trim_msg == ""){
			alert("보낼 내용을 입력해주세요.");
		}else if( $("#fieldset_receiver_list input[type=checkbox]").size() < 1){
			alert("보낼 친구를 추가해주세요.");
		}else{
			//다중클릭 방지를 위한 버튼 숨김
			$(this).hide();
			
			var receiver_max_size = $("#fieldset_receiver_list input[type=checkbox]").size();
			var success_size = 0;
			var error_size = 0;
			$("#fieldset_receiver_list input[type=checkbox]").each(function(){
				var postJsonData = {
					to_id : $(this).data("user_id"),
					from_id : g_user_id,
					msg : msg_text
				};
				$.post( g_apiUrlRoot+"msg_send.php", postJsonData, function( dataJson) {
					if (dataJson.rt_code == 0) {
						success_size++;
						if(receiver_max_size == success_size+error_size){
							alert("쪽지가 전송되었습니다.\n성공:"+success_size+"  "+"실패:"+error_size);
							localStorage.setItem("com.facelink.mypage.note_tap", "3")
							location.reload();
						}
					}
					else {
						error_size++;
						if(receiver_max_size == success_size+error_size){
							alert("쪽지가 전송되었습니다.\n성공:"+success_size+"  "+"실패:"+error_size);
							localStorage.setItem("com.facelink.mypage.note_tap", "3")
							location.reload();
						}
					}
				}, "json");
			});
		}
	});
	
	//친구 검색
	$("#write_search_btn").click(function(){
		var user_list_start = "<input type='checkbox' data-user_id='";
		var user_list_middle_01 = "' data-user_name='"
		var user_list_middle_02 = "'> ";
		var user_list_end = "<BR>";

		var search_val = $.trim($(this).parent().children("input[type=text]").val());
		var group_id = $("#select_group").val();
		if(search_val == ""){
			alert("검색어를 입력해주세요.");
		}else{
			//전체 그룹에서 검색
			if(group_id == 0){
				var postJsonData = {
					user_id : g_user_id,
					search_val : search_val
				};
				$.post( g_apiUrlRoot+"search_friend.php", postJsonData, function( dataJson) {
					
					var list = $("#fieldset_user_list");
					list.text('');
					if(dataJson.user.length == 0){
						list.append("<span>검색 결과가 없습니다.</span>");
					}
					for(var i=0; i<dataJson.user.length;i++){
						//맞친일때
						if(dataJson.user[i].status == 'done'){
							list.append(
								user_list_start
								+ dataJson.user[i].id
								+ user_list_middle_01
								+ dataJson.user[i].name + "(" + dataJson.user[i].id +")"
								+ user_list_middle_02
								+ dataJson.user[i].name + "(" + dataJson.user[i].id +")"
								+ user_list_end
							);
						}
					}
				}, "json");
			}
			else{
				var postJsonData = {
					group_id : group_id,
					search_val : search_val
				};
				$.post( g_apiUrlRoot+"search_group_member.php", postJsonData, function( dataJson) {
					
					var list = $("#fieldset_user_list");
					list.text('');
					if(dataJson.user.length == 0){
						list.append("<span>검색 결과가 없습니다.</span>");
					}
					for(var i=0; i<dataJson.user.length;i++){
						//맞친일때
						if(dataJson.user[i].status == 'done'){
							list.append(
								user_list_start
								+ dataJson.user[i].id
								+ user_list_middle_01
								+ dataJson.user[i].name + "(" + dataJson.user[i].id +")"
								+ user_list_middle_02
								+ dataJson.user[i].name + "(" + dataJson.user[i].id +")"
								+ user_list_end
							);
						}
					}
				}, "json");
			}
		}
	});
	
	
	//처음 친구 전체 리스트 호출
	setUserList(0);
});
</script>
<div id="write_note">
	<ul>
		<li>
			<select class="user_select" id="select_group" style="height:34px;">
				<option value="0">전체</option>
			</select>
			<span id="common_reserve_search"><input type="text" class="input_search" ><input id="write_search_btn" type="button" class="btn_search" style="vertical-align:top;"></span>
		</li>
		<li>
			<span>
				<fieldset id="fieldset_user_list">
                	<!--
					<input type="checkbox"> 이순신<BR>
					<input type="checkbox"> 홍길동<BR>
                    -->
				</fieldset>
			</span>
			<span class="LRbtn"><input id="btn_right" type="button" class="btn_right"><input id="btn_left" type="button" class="btn_left"></span>
			<span>
				<fieldset id="fieldset_receiver_list">
					<span>받는사람</span>
                    <!--
					<input type="checkbox"> 이순신<BR>
					<input type="checkbox"> 홍길동<BR>
                    -->
				</fieldset>
			</span>			
		</li>
	</ul>
	<ul>
		<li>
			<p>내용입력</p>
			<textarea id="write_msg"></textarea>
			<input id="wrtie_send_btn" type="button" class="btn_small blue" value="보내기">
		</li>
	</ul>		
</div>
