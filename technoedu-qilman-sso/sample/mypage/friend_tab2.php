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
	$("input[type=button]").click(function(){
		var btn_state = $(this).val();		
		var $select = $(this).parent().parent().children(".col2");		
		var tag = "";

		if(btn_state == "수정") {
			select_row_txt = $select.text();
			tag = "<input type='text' name='group_name' value='"+select_row_txt+"' style='height:25px; line-height:25px; padding-left:10px;'>";

			$select.text("");			
			$select.append(tag);

			$(this).attr("value","저장");

		} else if(btn_state == "저장") {
			select_row_txt = $select.children("input:text[name='group_name']").val();
			tag = select_row_txt;

			$select.text("");			
			$select.text(tag);

			$(this).attr("value","수정");

		} else if(btn_state == "삭제") {

		}		
	});	
});	
</script>

<div id="add_group" style="">
	<span>추가</span>
	<span><input type="text"></span>
	<span><input type="button" class="btn_small gray" value="추가"></span>
</div>
<div id="common_btn_area" style="float:right; width:140px;"><input type="button" class="btn_small gray" value="선택 그룹 삭제"></div>
<div id="common_room_list">
	<ul class="title">
		<li class="col1"><input type="checkbox"></li>
		<li class="col2">그룹명</li>					
		<li class="col3">수정</li>
		<li class="col4">삭제</li>
	</ul>
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
</div>