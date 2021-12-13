<!-- My FaceLink > 쪽지 > 보낸 쪽지함 -->
<style>
#send_note { }
#send_note ul~ul { cursor:pointer; }
#send_note .title { border:1px solid #848586; }
#send_note .col1 { width:10%; text-align:center; }
#send_note .col2 { width:20%; text-align:left; padding-left:20px; }
#send_note .col3 { width:50%; text-align:left; padding-left:20px; }
#send_note .col4 { width:20%; text-align:center; }

/* 팝업창 - 쪽지보기 */
#send_note_content { position:absolute; display:none; right:50%; top:50%; margin-top:-260px; width:400px; height:400px; background:white; border:1px solid #454545; }
#send_note_content > p.subject { height:40px; line-height:40px; padding:0px 10px; font-size:16px; background:#454545; color:white; }
#send_note_content > p > span { float:right; margin:0px; padding:0px; }
#send_note_content > p > span > img { vertical-align:middle; cursor:pointer; }
#send_note_content > ul { width:100%; }
#send_note_content > ul > li { padding:2px 0px; }
#send_note_content > ul > li > span { display:inline-block; width:50px; margin:5px 10px 5px 10px; font-weight:bold; border-right:1px solid #c4c4c4; }
#send_note_content > ul > li > textarea { width:98%; height:250px; border:1px solid #c4c4c4; }
#send_note_content #common_btn_area { width:170px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	/* 쪽지보기 */
	$("#send_note ul~ul").click(function(){ $("#send_note_content").show(); });
	$("#send_note_content #close").click(function(){ $("#send_note_content").hide(); });
});	
</script>

<div id="send_note">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1"><input type="checkbox"></li>
			<li class="col2">이름</li>
			<li class="col3">내용</li>
			<li class="col4">날짜</li>
		</ul>
		<? for($i=0; $i<10; $i++){ ?>
		<ul>
			<li class="col1"><input type="checkbox"></li>
			<li class="col2">홍길동</li>
			<li class="col3">2014년 10월 30일 회의 시간 어떠신가요?</li>
			<li class="col4">2010.10.26</li>
		</ul>
		<? } ?>
		<ul>
			<li class="col1"><input type="checkbox"></li>
			<li class="col2">홍길동</li>
			<li class="col3">2014년 10월 30일 회의 시간 어떠신가요?</li>
			<li class="col4">2010.10.26</li>
		</ul>
	</div>
</div>
<p style="display:block; height:30px; "><input type="button" class="btn_small darkgray" value="삭제" style="float:right;"></p>
<div id="common_reserve_page">
	<div class="page_group">
		<span class="page_left">◀</span>
		<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
		<span class="page_right">▶</span>
	</div>
</div>


<!---------------------------------------------------------------------------------------------------------------------------------->
<!-- 팝업창 : 쪽지보기 -->
<div id="send_note_content">
	<p class="subject">쪽지 보기<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li><span>보낸이</span>홍길동 (2014-10-28 15:30)</li>
		<li><textarea readonly></textarea></li>
		<li id="common_btn_area">
			<input type="button" value="확인" class="btn_small blue">
			<input type="button" value="삭제" class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 쪽지보기 -->
