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
#add_friend_page > #search select { width:80px; height:34px; border:1px solid #d3d3d3; }
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
$(document).ready(function() {
	/* 친구추가 */
	$("#add_friend").click(function(){ $("#add_friend_page").show(); });
	$("#add_friend_page #close").click(function(){ $("#add_friend_page").hide(); });	

	/* 쪽지 보내기 */
	$("#send_letter").click(function(){ $("#send_letter_page").show(); });
	$("#send_letter_page #close").click(function(){ $("#send_letter_page").hide(); });

	/* 이동 */
	$("#move").click(function(){ $("#move_page").show(); });
	$("#move_page #close").click(function(){ $("#move_page").hide(); });

	/* 그룹삭제 */
	$("#del_group").click(function(){ $("#del_group_page").show(); });
	$("#del_group_page #close").click(function(){ $("#del_group_page").hide(); });
	
	/* 친구끊기 */	
	$("#del_friend").click(function(){ $("#del_friend_page").show(); });
	$("#del_friend_page #close").click(function(){ $("#del_friend_page").hide(); });
});	
</script>

<p style="display:block; height:30px; "><input type="button" id="add_friend" class="btn_small darkgray" value="친구 추가" style="float:right;"></p>
<div id="group_area">
	<p>그룹</p>
	<ul id="list">
		<li>전체</li>
		<li>욱성미디어</li>
		<li>이음</li>
		<li>7GNC</li>							
	</ul>
</div>
<div id="member_area">
	<p>7GNC</p>
	<ul id="list">
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
			<select>
				<option>이름</option>
			</select>
		</span>
		<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
	</div>
	<ul id="user">
		<? For($i=0;  $i<10; $i++) { ?>
		<li>
			<span class="name"><input type="checkbox"> 이순신</span>
			<span class="group">소속명 : 거북선</span>
		</li>
		<? } ?>
	</ul>
	<div id="common_btn_area">
		<input type="button" value="확인" class="btn_small blue">
		<input type="button" value="취소" id="close" class="btn_small darkgray">	
	</div>
</div>
<!-- 팝업창 : 친구관리 -->

<!-- 팝업창 : 쪽지보내기 -->
<div id="send_letter_page">
	<p class="subject">쪽지 보내기<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li><span>보낸이</span>이순신</li>
		<li><span>받는이</span>홍길동, 김과장, 이부장, 양주임</li>
		<li><textarea></textarea></li>
		<li id="common_btn_area">
			<input type="button" value="보내기" class="btn_small blue">
			<input type="button" value="취소" id="close" class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 쪽지보내기 -->

<!-- 팝업창 : 이동 -->
<div id="move_page">
	<p class="subject">이동<span><img src="../images/close.png" id="close"></span></p>
	<ul id="user">
		<li>욱성미디어</li>
		<li>욱성미디어</li>
	</ul>
	<div id="common_btn_area">
		<input type="button" value="이동" class="btn_small blue">
		<input type="button" value="복사" class="btn_small darkgray">	
	</div>
</div>
<!-- 팝업창 : 이동 -->

<!-- 팝업창 : 그룹삭제 -->
<div id="del_group_page">
	<p class="subject">그룹에서 삭제<span><img src="../images/close.png" id="close"></span></p>
	<ul>
		<li>선택한 친구를 [그룹이름] 그룹에서<BR>삭제하시겠습니까?</li>
		<li id="common_btn_area">
			<input type="button" value="확인" class="btn_small blue">
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
			<input type="button" value="확인" class="btn_small blue">
			<input type="button" value="취소" id="close"class="btn_small darkgray">
		</li>
	</ul>
</div>
<!-- 팝업창 : 친구삭제 -->
<!---------------------------------------------------------------------------------------------------------------------------------->