<? include "../include/header.php"; ?>
<!-- 공지사항, 문의사항, FAQ 리스트 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#write { display:inline-block; width:100%; }
#write form { display:inline-block; }
#write li { float:left; padding-bottom:10px; }
#write li .star { display:inline-block; padding-left:10px; color:red; }
#write li:nth-child(odd) { width:20%; line-height:30px; padding-left:100px; font-weight:bold; }
#write li:nth-child(even) { width:80%; padding-left:20px; }

#write li input[type=text] { height:30px; line-height:30px; }
#write li select { width:150px; height:34px; line-height:34px; padding-left:10px; }

#write #subject { width:90%; }
#write #name { width:340px; }
#write #hp1, #write #hp2, #write #hp3 { width:100px; }
#write #email1, #write #email2 { width:200px; }


textarea { width:90%; min-height:200px; padding:10px 20px; border:1px solid #cccccc; }

/* common_room_list 재정의 */
#common_btn_area { width:200px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
	
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink 고객센터</li>
			<li class="r2"><a href="./list.php">공지사항</a><a href="./write.php" class="sub_select">문의사항</a><a href="./list.php">FAQ</a><span class="path">HOME > FaceLink 고객센터 > 문의사항</span></li>
			<li class="r3"><span>문의사항</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="write">
			<form>
				<ul>
					<li>제 목</li>
					<li><input type="text" id="subject" name="subject"></li>
				</ul>
				<ul>
					<li>이 름</li>
					<li><input type="text" id="name" name="name"></li>
				</ul>
				<ul>
					<li>핸드폰<span class="star">*</span></li>
					<li><input type="text" id="hp1" name="hp1"> - <input type="text" id="hp2" name="hp2"> - <input type="text" id="hp3" name="hp3"></li>
				</ul>
				<ul>
					<li>이메일<span class="star">*</span></li>
					<li><input type="text" id="email1" name="email1"> @ <input type="text" id="email2" name="email2"> &nbsp;
					<select>
						<option>선택하세요</option>
						<option>naver.co.kr</option>
					</select>
					</li>
				</ul>
				<ul>
					<li>내 용</li>
					<li><textarea></textarea></li>
				</ul>				
				<div id="common_btn_area">
					<input type="submit" value="확인" class="btn_big blue">
				</div>
			</form>			
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>