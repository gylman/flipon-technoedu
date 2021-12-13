<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>FACE LINK</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="../include/css/basic.css">

<style>
#header { width:100%; min-width:1000px; }
#header > li { float:left; height:51px; line-height:51px; padding:0px 10px; margin:10px auto; }
#header > li:nth-child(1) { width:20%; text-align:center; }
#header > li:nth-child(2) { width:70%; padding-left:20px; font-weight:bold; font-size:1.5em; }
#header > li:nth-child(3) { width:10%; padding-left:20px; }
#header > li:nth-child(3) > img { display:block; width:40px; padding:5px 0px; }
#sub_section { clear:both; width:100%; padding:10px 0px; margin:0px auto; }
#footer { clear:both; width:100%; min-width:1000px; height:40px; line-height:40px; background-color:#282a2b; color:#444a41; text-align:center; }


/* 화면영상 */
#sub_section > #jqxSplitter { min-width:1000px; margin:0 auto; }
#sub_section > #jqxSplitter > .left_area { min-width:512px; }
#sub_section > #jqxSplitter > .left_area > #movie { min-width:640px; min-height:480px; max-width:1024px; border:1px solid #c8c7c7; }
#sub_section > #jqxSplitter > .left_area > #movie_option { height:100px; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a { display:block; float:left; width:35px; height:35px; margin-top:3px; margin-right:3px; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_kind,
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select { position:relative; display:none; min-width:500px; background:#ffffff; z-index:10; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_kind > li,
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select > li { float:left; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_kind > li > img,
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select > li > img { display:block; float:left; width:80px; margin:5px; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select > li > p { clear:both; width:300px; height:30px; margin-bottom:5px; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select > li > p > span { display:block; float:left; width:60px; height:30px; line-height:30px; margin:0px 10px; text-align:center; background:#efefef; }
#sub_section > #jqxSplitter > .left_area > #movie_option > a > #screen_select > li > p > select { float:left; height:30px; padding:0px 5px; }


/* 참여자 리스트, 채팅방 영역 */
#sub_section > #jqxSplitter > .left_area > #movie_chat { clear:both; display:inline-block; width:512px; overflow:hidden; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li { float:left; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list { min-width:200px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > li { float:left; min-width:180px; padding:10px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p { width:200px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p.title { height:35px; line-height:35px; text-align:center; font-weight:bold; background:#2577b8; color:#ffffff; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p.sip { height:35px; line-height:35px; text-align:right; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p.chodae { height:35px; margin-top:10px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p.chodae > input[type=text] { width:150px; height:30px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > p.chodae > .btn_chodae { width:46px; height:32px; }

#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list > .list { width:200px; height:200px; overflow-y:auto; border:1px solid #c8c7c7; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul { clear:both; height:35px; background:#e9edf4; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul:nth-child(odd) { background:#d0d8e8; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul.title { background:#4d4e50; color:white; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul > li { float:left; height:35px; line-height:35px; border-bottom:1px solid #d6d6d6; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul > li:nth-child(1) { min-width:90px; padding-left:5px; } /* 참여자 리스트 */
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul > li:nth-child(2) { float:left; min-width:90px; } /* 아이콘 */
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul > li:nth-child(2) > a { display:block; float:left; height:35px; line-height:35px; padding-left:5px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.chat_list ul > li:nth-child(2) > a > img { vertical-align:middle; }

/* 채팅방 영역 */
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.msg_area { min-width:302px; padding-left:10px; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.msg_area > #msg_content { min-width:282px; height:200px; padding:10px; overflow-y:scroll; border:1px solid #c8c7c7; }
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.msg_area > #msg_txt { width:302px; height:30px; } 
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.msg_area > #msg_txt > #chat_msg { float:left; width:252px; height:30px;  border:1px solid #d6d6d6; } 
#sub_section > #jqxSplitter > .left_area > #movie_chat > li.msg_area > #msg_txt > .btn_send { float:left; width:46px; height:34px; background:#2577b8; border:1px solid #1a67a4; color:white; }



/* 문서 및 화이트보드 */
#sub_section > #jqxSplitter > .right_area { float:right; width:50%; min-width:500px; }
#sub_section > #jqxSplitter > .right_area > #pdf_option { width:100%; height:50px; }
#sub_section > #jqxSplitter > .right_area > #pdf_option > a { display:block; float:left; width:35px; height:35px; margin:2px; }
#sub_section > #jqxSplitter > .right_area > #pdf_option > a > img { width:35px; height:35px; }
#sub_section > #jqxSplitter > .right_area > #pdf_option > a.color { float:right; width:200px; border:1px solid red; }
#sub_section > #jqxSplitter > .right_area > #pdf { width:100%; min-height:530px; border:1px solid #1a67a4; }

#sub_section > #jqxSplitter > .right_area > #pdf_page { width:100%; height:40px; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li { float:left; height:40px; line-height:40px; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(1) { width:75%; text-align:center; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(2) { width:25%; text-align:right; }

#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(1) > a { display:block; float:left; width:30px; height:30px; line-height:30px; margin:5px auto; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(1) > a > img { vertical-align:middle; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(1) > a:nth-child(3) { width:100px; text-align:center; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(2) > input[type=text] { width:50px; height:25px; margin-right:5px; }
#sub_section > #jqxSplitter > .right_area > #pdf_page > li:nth-child(2) > input[type=submit] { width:50px; height:28px; text-align:center; border:0px; background:#2577b8; color:#ffffff; }

#sub_section > #jqxSplitter > .right_area > #pdf_file { width:100%; height:110px; margin-top:10px; }
#sub_section > #jqxSplitter > .right_area > #pdf_file > li { }
#sub_section > #jqxSplitter > .right_area > #pdf_file > li:nth-child(1) { width:100%; height:80px; border:1px solid #1a67a4; }
#sub_section > #jqxSplitter > .right_area > #pdf_file > li:nth-child(2) { width:100%; height:30px; }
#sub_section > #jqxSplitter > .right_area > #pdf_file > li:nth-child(2) > input[type=button] { float:right; width:100px; height:27px; text-align:center; border:0px; background:#2577b8; color:#ffffff; }

</style>

<script src="../include/js/html5shiv.js" type="text/javascript"></script>
<script src="../include/js/jquery.js" type="text/javascript"></script>

<!-- splitter -->
<link rel="stylesheet" type="text/css" href="../include/css/jqx.base.css">
<link rel="stylesheet" type="text/css" href="../include/css/jqx.energyblue.css">
<script type='text/javascript' src="../include/js/jqx-all.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$("#jqxSplitter").jqxSplitter({
		width:99+"%",
		height:1300,
		panels:[{ size:50+"%"}, { size:50+"%"}],
		theme: 'energyblue'
	});

	$("#jqxSplitter").bind('resize', function (event) {
		var args = event.args;
		var left_area = $(".left_area");
		var screen = $("#movie");
		var screen_width = left_area.width();
		var screen_height = 3*screen_width / 4;

		if(screen_width < 1025) {
			screen.css("width", screen_width+"px");
			screen.css("height", screen_height+"px");
		}		
	});

	$(".option5").click(function(){
		$("#screen_kind").slideToggle("slow");
	});

	$(".option6").click(function(){
		$("#screen_select").slideToggle("slow");
	});

});	
</script>
<body>
<ul id="header">
	<li class="logo"><a href="../main/"><img src="../images/logo.png"></a></li>
	<li class="subject">회의방 제목</li>
	<li class="window_close"><img src="../images/w_close.png"></li>
</ul>

<section id="sub_section">
	<div id='jqxSplitter'>
		<!-- 화면영상 -->
		<div class="left_area">
			<div id="movie"></div>
			<div id="movie_option">
				<a href="#"><img src="../images/option1.png"></a>
				<a href="#"><img src="../images/option2.png"></a>
				<a href="#"><img src="../images/option3.png"></a>
				<a href="#"><img src="../images/option4.png"></a>
				<a href="#screen_kind" class="option5"><img src="../images/option5.png">
					<ul id="screen_kind">
						<li>
							<img src="../images/screen1.png">
							<img src="../images/screen2.png">
							<img src="../images/screen3.png">
							<img src="../images/screen4.png">
							<img src="../images/screen5.png">
							<img src="../images/screen6.png">
							<img src="../images/screen7.png">
							<img src="../images/screen8.png">
							<img src="../images/screen9.png">
							<img src="../images/screen10.png">
						</li>
					</ul>
				</a>
				<a href="#screen_select" class="option6"><img src="../images/option6.png">
					<ul id="screen_select">
						<li><img src="../images/screen8.png"></li>
						<li>
							<p>
								<span>위치</span>
								<select>
									<option>1</option>
								</select>
							</p>
							<p>
								<span>배치</span>
								<select>
									<option>test1</option>
								</select>
							</p>
						</li>
					</ul>
				</a>				
			</div>

			<ul id="movie_chat">
				<!-- 음성 및 영상 제어 -->
				<li class="chat_list">
					<p class="title">참여자 리스트(방장)</p>
						<div class="list">
						<ul>
							<li>test1(방장)</li>
							<li>
								<a><img src="../images/v_off.png"></a> <!-- 음소거 -->
								<a><img src="../images/m_off.png"></a>	<!-- 영상소거 -->
								<a></a>	<!-- 퇴장 -->
							</li>
						</ul>					
						<ul>
							<li>test2</li>
							<li>
								<a><img src="../images/v_on.png"></a> <!-- 음소거 -->
								<a><img src="../images/m_on.png"></a>	<!-- 영상소거 -->
								<a><img src="../images/del.png"></a>	<!-- 퇴장 -->
							</li>
						</ul>
						<ul>
							<li>test3</li>
							<li>
								<a></a> <!-- 음소거 -->
								<a></a>	<!-- 영상소거 -->
								<a></a>	<!-- 퇴장 -->
							</li>
						</ul>
					</div>
					<p class="sip">SIP 단말여부 <input type="checkbox"></p>
					<p class="chodae"><input type="text"><input type="submit" class="btn_chodae" value="초대"></p>
				</li>

				<li class="msg_area">
					<div id="msg_content">채팅방 영역</div>
					<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" class="btn_send" value="전송"></div>
				</li>

			</ul>
		</div>
		<!-- 문서 및 화이트보드 -->
		<div class="right_area">
			<!-- PDF 옵션 - PDF화면, 화이트보드, 펜, 레이저포인터, 클리어, 색상표  -->
			<div id="pdf_option">
				<a><img src="../images/pdf_option1.png"></a>
				<a><img src="../images/pdf_option2.png"></a>
				<a><img src="../images/pdf_option3.png"></a>
				<a><img src="../images/pdf_option4.png"></a>
				<a><img src="../images/pdf_option5.png"></a>
				<a class="color"></a>
			</div>
			<div id="pdf"></div>
			<!-- PDF 페이지 -->
			<ul id="pdf_page">
				<li>
					<a><img src="../images/btn_start.png"></a>
					<a><img src="../images/btn_left.png"></a>
					<a>page4</a>
					<a><img src="../images/btn_right.png"></a>
					<a><img src="../images/btn_end.png"></a>
				</li>
				<li><input type="text"><input type="submit" value="이동"></li>					
			</ul>
			<!-- PDF 파일공유 -->
			<ul id="pdf_file">
				<li class="file_list"></li>
				<li><input type="button" value="파일업로드"></li>
			</ul>
		</div>
	</div>
</section>

<div id="footer">COPYRIGHT(C) FACELINK CO., LTD. ALL RIGHTS RESERVED.</div>
</body>
</html> 