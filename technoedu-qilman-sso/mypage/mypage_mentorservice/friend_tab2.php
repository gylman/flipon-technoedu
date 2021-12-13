<!-- My FaceLink > 친구 > 그룹 관리 -->
<style>
#add_group, #add_group+div { display:inline-block; width:100%; padding:5px 0px 5px 0px; }
#add_group > span:nth-child(1) { display:inline-block; text-align:center; font-weight:bold; padding:0px 20px; }
#add_group > span:nth-child(2) > input[type=text] { width:200px; height:30px; line-height:30px; margin-right:10px; }
#add_group > span:nth-child(3) > input[type=button] {}

#sub2 .col1 { width:5%; text-align:center; }
#sub2 .col2 { width:75%; padding-left:20px; }
#sub2 .col3 { width:10%; text-align:center; }
#sub2 .col4 { width:10%; text-align:center; }

/* 버튼영역 중앙정렬을 위한 재설정 */
#common_btn_area { width:160px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	////////////////////////////////
	//그룹 리스트 가져오기
	var ul_start = "<ul>";
	var ul_col_1_start = "<li class='col1'><input name='group_checkbox' type='checkbox' data-group_id='";
	var ul_col_1_end = "'></li>";
	var ul_col_2_start	= "<li class='col2'>";
	var ul_col_2_end	= "</li>";
	var ul_col_3 = "<li class='col3'><input type='button' class='btn_small lightgray' value='수정'></li>";
	var ul_col_4 = "<li class='col4'><input type='button' class='btn_small lightgray' value='삭제'></li>";
	var ul_end = "</ul>";
	
	var postJsonData = {
		user_id : g_user_id
	};
	
	$.post( g_apiUrlRoot+"group_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			for(var i=0; i<dataJson.group.length;i++){
				$("#common_room_list")
				.append(
					ul_start
					+ ul_col_1_start
					+ dataJson.group[i].id
					+ ul_col_1_end
					+ ul_col_2_start
					+ dataJson.group[i].group_name 
					+ ul_col_2_end
					+ ul_col_3
					+ ul_col_4
					+ ul_end
				);
			}
		} else {
			alert('그룹 정보를 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	//리스트 가져오기 끝
	////////////////////////////////
	
	//전체 체크박스 이벤트
	$("#checkbox_all").click(function() {
		var isChecked = $(this).is(":checked");
		$("input[name=group_checkbox]").each(function() {
			//$(this).attr("checked", isChecked);
			this.checked = isChecked;
		});
    });
	//동적 버튼 이벤트
	$("#common_room_list").on("click", "input[type=button]", function(){
		var btn_state = $(this).val();
		var group_name = $(this).parent().parent().children(".col2");
		var group_id = $(this).parent().parent().children(".col1").children("input").data("group_id");
		var tag = "";
		
		//그룹명 수정
		if(btn_state == "수정") {
			group_name_text = group_name.text();
			tag = "<input type='text' id='new_group_name' value='"+group_name_text+"' style='height:25px; line-height:25px; padding-left:10px;'>";

			group_name.text("");			
			group_name.append(tag);

			$(this).attr("value","저장");

		}
		//그룹명 수정
		else if(btn_state == "저장") {
			var new_group_name = $.trim(group_name.children("input").val());
			if(new_group_name == "undefined" || new_group_name == ""){
				alert('그룹명을 입력해주세요.');
				return false;
			}
			var postJsonData = {
				group_id : group_id,
				new_group_name : new_group_name
			};
			
			$.post( g_apiUrlRoot+"group_rename.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					/*
					select_row_txt = new_group_name;
					tag = select_row_txt;
		
					group_name.text("");			
					group_name.text(tag);
		
					$(this).attr("value","수정");
					*/
					localStorage.setItem("com.facelink.mypage.friend_tap", "2");
					location.reload();
				}else if (dataJson.rt_code == 2000){
					alert('동일한 그룹명이 존재합니다.');
				}else {
					alert('그룹 수정에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");

		}
		//그룹 삭제
		else if(btn_state == "삭제") {
			if(confirm("삭제하시면 복구할 수 없습니다.\n정말 삭제하시겠습니까??") == true){
				var postJsonData = {
					group_id : group_id
				};
				
				$.post( g_apiUrlRoot+"group_remove.php", postJsonData, function( dataJson) {
					
					if (dataJson.rt_code == 0) {
						localStorage.setItem("com.facelink.mypage.friend_tap", "2");
						location.reload();
					} else {
						alert('그룹 삭제에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
					}
				}, "json");
			}
		}
	});
	
	//버튼 이벤트
	$("input[type=button]").on("click", function(){
		var btn_state = $(this).val();
		
		//그룹 추가
		if(btn_state == "추가") {
			var group_name = $.trim($("#group_name").val());
			if(group_name == "undefined" || group_name == ""){
				alert('그룹명을 입력해주세요.');
				return false;
			}
			
			var postJsonData = {
				user_id : g_user_id,
				group_name : group_name
			};
			
			$.post( g_apiUrlRoot+"group_add.php", postJsonData, function( dataJson) {
				
				if (dataJson.rt_code == 0) {
					localStorage.setItem("com.facelink.mypage.friend_tap", "2");
					location.reload();
				} else if (dataJson.rt_code == 2000){
					alert('동일한 그룹명이 존재합니다.');
				} else {
					alert('그룹 생성에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
				}
			}, "json");
		}
		//선택 그룹 삭제
		else if(btn_state == "선택 그룹 삭제") {
			var max_size = $("input[name=group_checkbox]:checked").size();
			if(max_size < 1){
				alert("삭제할 그룹을 선택해주세요.");
			}
			else if(confirm("삭제하시면 복구할 수 없습니다.\n정말 삭제하시겠습니까??") == true){
				//체크되어 있는 그룹 가져오기	
				var now_size = 0;
				$("input[name=group_checkbox]:checked").each(function() {
					var group_id = $(this).data("group_id");
					var postJsonData = {
						group_id : group_id
					};
					
					$.post( g_apiUrlRoot+"group_remove.php", postJsonData, function( dataJson) {
						
						if (dataJson.rt_code == 0) {
							now_size++;
							if(now_size == max_size){
								localStorage.setItem("com.facelink.mypage.friend_tap", "2");
								location.reload();
							}
						} else {
							alert('그룹 삭제에 실패하였습니다.\n 잠시 후 다시 시도해주세요.');
						}
					}, "json");
				});
			}
		}
	});	
});	
</script>

<div id="add_group" style="">
	<span>추가</span>
	<span><input id="group_name" type="text"></span>
	<span><input type="button" class="btn_small gray" value="추가"></span>
</div>
<div id="common_btn_area" style="float:right; width:140px;"><input type="button" class="btn_small gray" value="선택 그룹 삭제"></div>
<div id="common_room_list">
	<ul class="title">
		<li class="col1"><input id="checkbox_all" type="checkbox"></li>
		<li class="col2">그룹명</li>					
		<li class="col3">수정</li>
		<li class="col4">삭제</li>
	</ul>
    <!--
	<ul>
		<li class="col1"><input type="checkbox"></li>
		<li class="col2">욱성미디어</li>					
		<li class="col3"><input type="button" class="btn_small lightgray" value="수정"></li>
		<li class="col4"><input type="button" class="btn_small lightgray" value="삭제"></li>
	</ul>
	<ul>
		<li class="col1"><input type="checkbox"></li>
		<li class="col2">이음</li>					
		<li class="col3"><input type="button" class="btn_small lightgray" value="수정"></li>
		<li class="col4"><input type="button" class="btn_small lightgray" value="삭제"></li>
	</ul>
	<div id="common_btn_area">
		<input type="button" value="확인" class="btn_small blue">
		<input type="button" value="취소" class="btn_small darkgray">
	</div>
    -->
</div>