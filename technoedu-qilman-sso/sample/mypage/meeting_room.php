<? include "../include/header.php"; ?>
<!-- 나의 회의 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<link rel="stylesheet" type="text/css" href="../include/css/mypage.css">

<script type="text/javascript">
$(document).ready(function() {
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My FaceLink</li>
			<li class="r2"><a href="./meeting_list.php" class="sub_select">나의 회의</a><a href="./recording_list.php">녹화리스트</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="./cash.php">캐시</a><span class="path">HOME > My FaceLink > 나의 회의</span></li>
			<li class="r3"><span>나의 회의</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<p class="title">영업부 주간회의</p>
			<!-- 회의방(일반) -->
			<ul id="chat">
				<li id="movie">
					<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
				</li>
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>

			<!-- 회의방(방장) -->
			<ul id="chat">
				<li id="movie">
					<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
				</li>
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<ul class="room_func">
						<li>방 제어 기능(방장)</li>
						<li>
							<input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small blue" value="화면 레이아웃 설정">
							<input type="button" class="btn_small blue" value="화면 위치 변경"><input type="button" class="btn_small blue" value="음성/영상">
							<input type="button" class="btn_small darkgray" value="퇴장">
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>


			<!-- 회의방(방장) - 초대 -->
			<ul id="chat">
				<li id="movie">
					<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
				</li>
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<ul class="invited_func">
						<li>초대하기</li>
						<li>
							<span style="inline-block; float:left; width:45%; padding:10px 0px 5px 0px; text-align:center; "><input type="radio"> 회원초대</span>
							<span style="inline-block; float:left; width:45%; padding:10px 0px 5px 0px; text-align:center; "><input type="radio"> SIP 단말 초대</span>
							<input type="text" value="회원 ID/단말 번호" style="width:300px; height:30px; line-height:30px; margin:5px 20px;">
							<span style="display:block; width:220px; margin:5px auto; "><input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small gray" value="취소"></span>
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>


			<!-- 회원기능(방장레이아웃) -->
			<ul id="chat">
				<li id="movie">
					<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
				</li>
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<!-- 화면 레이아웃 설정 -->
					<ul class="screen_layout_func">
						<li>화면 레이아웃 설정</li>
						<li>
							<span>종류<BR>
								<select>
									<option>2X2</option>
									<option>4X4</option>
									<option>1+PIP1</option>
									<option>1+PIP3</option>
									<option>1+5</option>
									<option>1+7</option>
								</select>
							</span>
							<span><img src="../images/screen4.png"></span>							
							<span><input type="button" class="btn_small blue" value="변경"><BR><input type="button" class="btn_small gray" value="취소"></span>
						</li>
					</ul>

					<!-- 화면 위치 변경 -->
					<ul class="screen_position_func">
						<li>화면 위치 변경</li>
						<li>
							<span><img src="../images/screen4.png"></span>							
							<span>
								위치1
								<select>
									<option>자동</option>
									<option>이사님</option>
									<option>사장님</option>
									<option>잠금</option>
								</select>
								<BR>								
								위치2
								<select>
									<option>이사님</option>
								</select>
								<BR>
								위치3
								<select>
									<option>사장님</option>
								</select>
								<BR>
								위치4
								<select>
									<option>잠금</option>
								</select>
							</span>
						</li>
					</ul>

					<!-- 음성 및 영상 제어 -->
					<ul class="voice_func">
						<li>음성 및 영상 제어</li>
						<li>
							<ul>
								<li>번호</li>
								<li>이름</li>
								<li>음성 제어</li>
								<li>영상 제어</li>
							</ul>
							<ul>
								<li>1</li>
								<li>홍길동</li>
								<li><img src="../images/voice_on.png"></li>
								<li><img src="../images/video_off.png"></li>
							</ul>
							<ul>
								<li>2</li>
								<li>이사님</li>
								<li><img src="../images/voice_off.png"></li>
								<li><img src="../images/video_on.png"></li>
							</ul>
							<ul>
								<li>3</li>
								<li>홍길순</li>
								<li><img src="../images/voice_on.png"></li>
								<li><img src="../images/video_off.png"></li>
							</ul>
						</li>
					</ul>

					<!-- 사용자 리스트 -->
					<ul class="user_list">
						<li>사용자 리스트</li>
						<li>
							<ul>
								<li>번호</li>
								<li>이름</li>
								<li>강제퇴장</li>
							</ul>
							<ul>
								<li>1</li>
								<li>홍길동</li>
								<li><input type="button" value="퇴장"></li>
							</ul>
							<ul>
								<li>2</li>
								<li>이사님</li>
								<li><input type="button" value="퇴장"></li>
							</ul>
						</li>
					</ul>

					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>

			<style>
				div.pdf_btn > input[type=button] { min-width:40px; height:30px; border-radius:4px; cursor:pointer; border:1px solid #aeaeae; }
				div.pdf_btn > input[type=button]:nth-child(1) { background:url("../images/btn_start.png") 50% 50% no-repeat; }
				div.pdf_btn > input[type=button]:nth-child(2) { background:url("../images/btn_left.png") 50% 50% no-repeat; }
				div.pdf_btn > input[type=button]:nth-child(3) { background:url("../images/btn_right.png") 50% 50% no-repeat; }
				div.pdf_btn > input[type=button]:nth-child(4) { background:url("../images/btn_end.png") 50% 50% no-repeat; }
			</style>

			<!-- 회의방(방장) - 자료공유 -->
			<ul id="data_sharing">
				<li id="movie">
					<video src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>
				</li>
				<li id="pdf_area">
					<div class="pdf_btn">
						<input type="button" title="처음">
						<input type="button" title="이전">
						<input type="button" title="다음">
						<input type="button" title="끝">
						<input type="button" value="지우기" title="지우기">
					</div>
					<div class="pdf_color">
						<span class="color1"></span>
						<span class="color2"></span>
						<span class="color3"></span>
						<span class="color4"></span>
						<span class="color5"></span>
						<span class="color6"></span>
					</div>
					<div class="pdf_file"></div>
				</li>
				<li id="movie_func">
					<ul class="mem_func">
						<li>회의 기능(일반)</li>
						<li>
							<input type="button" class="btn_small blue" value="최대화면 전환"><input type="button" class="btn_small blue" value="자기화면 끄기/켜기">
							<input type="button" class="btn_small blue" value="음성 소거"><input type="button" class="btn_small blue" value="영상 중지">
							<input type="button" class="btn_small darkgray" value="방나가기">
						</li>
					</ul>
					<ul class="room_func">
						<li>방 제어 기능(방장)</li>
						<li>
							<input type="button" class="btn_small blue" value="초대"><input type="button" class="btn_small blue" value="화면 레이아웃 설정">
							<input type="button" class="btn_small blue" value="화면 위치 변경"><input type="button" class="btn_small blue" value="음성/영상">
							<input type="button" class="btn_small darkgray" value="퇴장">
						</li>
					</ul>
					<div id="msg_area">
						<div id="msg_content">채팅방 영역</div>
						<div id="msg_txt"><input type="text" id="chat_msg"><input type="submit" id="btn_chat_send" value="전송"></div>
					</div>
				</li>
			</ul>


		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>