<? include "../include/header.php"; ?> <!-- 지난회의목록 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
#common_room_content { width:100%; height:100px; padding:20px; border-radius:10px; border:1px solid #848586; }
#common_room_content li { float:left; height:30px; line-height:30px; padding-left:20px; margin:0px 0px 0px 0px; }
#common_room_content li > span { display:inline-block; width:100px; height:20px; line-height:20px; margin-right:20px; border-right:1px solid #dddcdc; }

#common_room_content > li.rev_date { width:100%; }
#common_room_content > li.rev_name { width:70%; border-bottom:0px solid #dddcdc; }
#common_room_content > li.rev_reader { width:30%; border-bottom:0px solid #dddcdc; }

p.title { height:30px; line-height:30px; padding-left:20px; font-size:14px; font-weight:bold; }
#mans { float:left; width:260px; margin-top:20px; }
#mans > ul { height:440px; padding:10px 20px; border-radius:10px; border:1px solid #848586; overflow-x:auto; }
#mans > ul > li { height:30px; line-height:30px; border-bottom:1px solid #dddcdc; }

#movie { float:right; width:800px; margin-top:20px; }
#movie > video { width:100%; }

#file_list { clear:both; width:100%; padding-top:20px; }
#file_list > ul { height:130px; padding:10px 20px; border-radius:10px; border:1px solid #848586; overflow-x:auto; }
#file_list > ul > li { height:30px; line-height:30px; border-bottom:1px solid #dddcdc; }
#file_list > ul > li > a { padding-left:20px; }

/* 재정의 */
#common_btn_area {
	width:100px;
	float:right;
}
</style>

<link href="../player/video-js.min.css" rel="stylesheet" type="text/css">
<script src="../player/video.js"></script>
<script>
	videojs.options.flash.swf = "../player/video-js.swf";
</script>


<script type="text/javascript">

var g_room_id = '<?= $_POST["rid"] ?>';

if (typeof g_room_id == 'undefined' || g_room_id == null || g_room_id == '') {
	alert("방 정보가 잘못되었습니다!\n다시 확인해주세요");
	history.back(-1);
}

$(document).ready(function() {
	$("#recording_list").click(function(){ location.href="./recording_list.php"; });

    player =  videojs('VideoPlayer', {
    techOrder: ['flash', 'html5'],
    autoplay: false,
    sources: [{
    type: "video/flv",
    src: ""
    }]
    });
	
	$.post( g_apiUrlRoot+"room_info.php", {rid: g_room_id}, function(dataJson) {
		console.log(dataJson);
		if (dataJson.rt_code == 0) {
			var dtStart = new Date(dataJson.start_datetime);
			var dtEnd = new Date(dataJson.end_datetime);
			
			$('.rev_date').html('<span>일시</span>'+dtStart.format('yyyy년 MM월 dd일 hh:mm')+' ~ '+dtEnd.format('yyyy년 MM월 dd일 hh:mm'));
			$('.rev_name').html('<span>제목</span>'+dataJson.title);
			$('.rev_reader').html('<span>방장</span>'+dataJson.name);
			
			if ( dataJson.record_url != '' && dataJson.record_url.search("flv") != -1  ) {
				player.pause();
				player.currentTime(0);
				player.src('http://'+g_MCUAddressList[0]+dataJson.record_url);
				player.ready(function() {
						this.one('loadeddata', videojs.bind(this, function() {
										this.currentTime(0);
										}));
						this.load();
						//this.play();
						});
			}
			else {
				$('#movie').html('<p class="title">본 회의는 녹화영상이 존재하지 않습니다.</p><video id="videoPlayer" src="#" controls autoplay loop muted preload="auto" poster="../images/demo.jpg"></video>');
			}
			
			$('#file_list ul li').remove();
			if (dataJson.doclist != '') {
				var doclist = eval ( "(" + dataJson.doclist+")");
				
				console.log(doclist);
				for (var i=0; i<doclist.length; i++ )
				{
					$('#file_list ul').append('<li><a href="../upload/downdoc.php?rid='+g_room_id+'&idx='+i+'&filename='+doclist[i].name+'" target=_blank>'+doclist[i].name+'</a></li>');
				}
			}
			
			$('#mans ul li').remove();
			_.each(dataJson.member, function(user, idx) {
				$('#mans ul').append('<li>'+user.name+'('+user.part+')</li>');
			});
		}
	}, 'json');
});	
</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php" class="sub_select">지난회의목록</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="../join/join_edit.php">회원정보</a><!--a href="./cash.php">캐시</a--><span class="path">HOME > My FaceLink > 지난회의목록</span></li>
			<li class="r3"><span>지난회의목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<ul id="common_room_content">
				<li class="rev_date"><span>회의일시</span>2014년 10월 28일 13:00 15:00</li>
				<li class="rev_name"><span>회의명</span>(주)○○○ 주간회의</li>
				<li class="rev_reader"><span>방장</span>김종근</li>
			</ul>

			<!-- 참석자 -->
			<div id="mans">
				<p class="title">참석자</p>
				<ul>
					<!--li>김종근(소속)</li>
					<li>김종근(소속)</li>
					<li>김종근(소속)</li>
					<li>김종근(소속)</li>
					<li>김종근(소속)</li>
					<li>김종근(소속)</li-->
				</ul>
			</div>

			<!-- 녹화영상 -->
			<div id="movie" style="width:810px;height:480px;">
				<p class="title">녹화영상</p>
				  <video id="VideoPlayer" class="video-js vjs-default-skin" controls preload="none" width="800" height="450" data-setup="{}" >
					<source id=video_src src="" type='video/flv' />
				  </video>	
			</div>

			<!-- 첨부 자료 목록 -->
			<div id="file_list">
				<p class="title">첨부 자료 목록</p>
				<ul>					
					<!--li>20141123.pdf <a href="#">다운받기</a></li>
					<li>20141123.pdf <a href="#">다운받기</a></li>
					<li>20141123.pdf <a href="#">다운받기</a></li-->
				</ul>
			</div>

			<div id="common_btn_area"><input type="button" id="recording_list" class="btn_small gray" value="목록보기"></div>
		</div>		
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
