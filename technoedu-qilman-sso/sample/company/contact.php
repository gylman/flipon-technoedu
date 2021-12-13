<? include "../include/header.php"; ?>
<!-- 회의방 예약 -->
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">

<style>
#contact { display:inline-block; *zoom:1; width:100%; color:#606060;}
#contact > p.title_img > img { margin:20px auto; }

#contact > ul { width:100%; }
#contact > ul > li { padding:5px 0px; font-size:17px; }
#contact > ul > li.addr { font-weight:bold; height:30px; }
#contact > ul > li > span { display:inline; padding:2px 10px; margin-right:10px; background:#383838; color:#ffffff; border-radius:5px; border:1px solid #302f2f; }

</style>

	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">FaceLink는?</li>
			<li class="r2"><a href="./service.php">서비스 소개</a><a href="./contact.php">회사소개</a><a href="./contact.php" class="sub_select">Contact</a><span class="path">HOME > FaceLink는? > Contact</span></li>
			<li class="r3"><span>Contact</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/conference.css 참고] -->
	<section id="sub_section">
		<div id="contact">		
			<p class="title_img"><img src="../images/contact.png"></p>
			<ul>				
				<li class="addr">대전광역시 유성구 테크노5로 68 우림빌딩 4층 (관평동 774번지)</li>
				<li><span>Tel</span>070-8763-5000</li>
				<li><span>Fax</span>042-931-5026</li>
				<li><span>Mail</span>info@wooksungmedia.com </li>
				<li><span>Homepage</span>http://www.wooksungmedia.com </li>
			</ul>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>