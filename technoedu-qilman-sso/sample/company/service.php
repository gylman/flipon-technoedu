<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#service { display:inline-block; *zoom:1; width:100%; color:#606060;}
#service > p.title { font-family:'Nanum Myeongjo'; font-size:28px; line-height:40px; text-align:center; margin-bottom:20px; }
#service > p.title_img > img { margin:20px auto; }

#service > ul { display:inline-block; width:100%; border-bottom:1px dashed #000000; }
#service > ul > li { }
#service > ul > li:first-child { float:left; width:170px; line-height:130px; text-align:center; }
#service > ul > li:first-child > img { vertical-align:middle; }
#service > ul > li:last-child { float:left; line-height:25px; width:820px; margin:30px auto 30px 50px; }
#service > ul > li:last-child > b { font-size:16px; }
</style>

	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink는?</li>
			<li class="r2"><a href="./service.php" class="sub_select">서비스 소개</a><a href="./aboutus.php">회사소개</a><a href="./contact.php">Contact</a><span class="path">HOME > FaceLink는? > 서비스 소개</span></li>
			<li class="r3"><span>서비스 소개</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="service">		
			<p class="title"><font style="color:#3386c7; font-weight:bold; font-size:32px;">FACELINK</font>는 <font style="color:#272828; font-size:32px; ">HTML5기반의 차세대 영상협업 솔루션</font>을 제공하여<BR>
			생산성 증대와 다양한 비즈니스에 활용될 수 있도록 도와줍니다.</p>
			<p class="title_img"><img src="../images/service1.png"></p>
			<ul>				
				<li><img src="../images/service1-1.png"></li>
				<li>
					<B>No Plug-in, No ActiveX</B><BR>				
					FACELINK의 영상 협업 솔루션은 HTML5기반의 차세대 영상 협업 서비스로 더 이상 PC나 기타 기기에서 특정 S/W를 깔거나 웹 브라우저에서 Plug-in 또는 ActiveX를 설치 하지 않아도 됩니다.
				</li>
			</ul>
			<ul>
				<li><img src="../images/service1-2.png"></li>
				<li>
					<B>WebRTC 지원</B><BR>
					FACELINK의 영상 협업 솔루션은 HTML5기반의 WebRTC 기술을 지원하며 이를 지원하는 다양한 브라우저에서 서비스를 제공 가능합니다.
					(Chrome, Firefox, Opera등)
				</li>
			</ul>
			<ul>
				<li><img src="../images/service1-3.png" valign="absmiddle"></li>
				<li>
					<B>Multi-Device</B><BR>
					FACELINK의 영상 협업 솔루션은 PC뿐 아니라 스마트 패드, 스마트 폰, DID, 스마트 카 등 다양한 디바이스 환경에서 서비스 가능합니다.
				</li>
			</ul>
			<ul>
				<li><img src="../images/service1-4.png"></li>
				<li>
					<B>HD급 고화질 지원</B><BR>
					FACELINK의 영상 협업 다자간 회의는 HD급 고화질 영상 서비스(720P)를 지원합니다. 사용자는 보다 깨끗하고 선명한 화면을 볼 수 있어서 더욱 실감나게 회의를 진행 할 수 있습니다.
				</li>
			</ul>
			<ul>
				<li><img src="../images/service1-5.png"></li>
				<li>
					<B>다자간 회의</B><BR>
					FACELINK의 영상 협업 다자간 회의를 지원합니다. 한방에 최대 16자까지 지원하고 10가지의 화면 레이아웃을 제공하며 회의방내의 발언권 제어, 초대, 퇴장등의 기능을 제공합니다.
				</li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>