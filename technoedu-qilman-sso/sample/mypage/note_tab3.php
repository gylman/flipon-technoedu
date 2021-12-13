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

<div id="write_note">
	<ul>
		<li>
			<select class="user_select">
				<option>그룹명</option>
				<option></option>
			</select>
			<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
		</li>
		<li>
			<span>
				<fieldset>
					<input type="checkbox"> 이순신<BR>
					<input type="checkbox"> 홍길동<BR>
				</fieldset>
			</span>
			<span class="LRbtn"><input type="button" class="btn_right"><input type="button" class="btn_left"></span>
			<span>
				<fieldset>
					<span>회의참여자 목록 + </span>
					<input type="checkbox"> 이순신<BR>
					<input type="checkbox"> 홍길동<BR>
				</fieldset>
			</span>			
		</li>
	</ul>
	<ul>
		<li>
			<p>내용입력</p>
			<textarea></textarea>
			<input type="button" class="btn_small blue" value="보내기">
		</li>
	</ul>		
</div>