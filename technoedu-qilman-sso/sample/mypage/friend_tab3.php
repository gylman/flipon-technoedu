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
});	
</script>

<div id="rev_msg">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">받은 신청</li>					
			<li class="col2">수락</li>
			<li class="col3">무시</li>
		</ul>
		<ul>
			<li class="col1">홍길동(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="수락"></li>
			<li class="col3"><input type="button" class="btn_small lightgray" value="무시"></li>
		</ul>
		<ul>
			<li class="col1">이순신(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="수락"></li>
			<li class="col3"><input type="button" class="btn_small lightgray" value="무시"></li>
		</ul>
	</div>
</div>

<div id="send_msg">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">보낸 신청</li>
			<li class="col2">취소</li>
		</ul>
		<ul>
			<li class="col1">홍길동(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="취소"></li>
		</ul>
		<ul>
			<li class="col1">이순신(소속)</li>					
			<li class="col2"><input type="button" class="btn_small lightgray" value="취소"></li>
		</ul>
	</div>
</div>