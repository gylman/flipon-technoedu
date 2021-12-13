<? include "../include/header.php"; ?>
<!-- 지난회의목록 -->
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<link rel="stylesheet" type="text/css" href="../css/mypage.css">

<style>
/* 재정의 */
#common_room_list li.room_time { width:40%; }
#common_room_list li.room_name { width:60%; }

#common_room_list ul~ul { cursor:pointer; }
#common_room_list ul~ul:hover { background-color:#9ADDFF; }
#nextPage { cursor:pointer; }
#prevPage { cursor:pointer; }



</style>

<script type="text/javascript">
checkLogin(true, true);

var listcntPerPage = 10;
var curPage = 1;
var isLastPage = false;

Date.createFromMysql = function(mysql_string)
{ 
   if(typeof mysql_string === 'string')
   {
      var t = mysql_string.split(/[- :]/);

      //when t[3], t[4] and t[5] are missing they defaults to zero
      return new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);          
   }

   return null;   
}


function updateConfList( page )
{
	$.post( g_apiUrlRoot+"room_past_list.php",{page:page, listcnt:listcntPerPage}, function(dataJson) {
		if (dataJson.rt_code == 0) {
			
			if ( dataJson.total_count <= 0 ) return;

			$('#common_room_list ul').not('.title').remove();

			if ( dataJson.room_list.length < listcntPerPage )  isLastPage = true;
			else isLastPage = false;
			
			_.each(dataJson.room_list, function(room, idx) {
				var dtStart = Date.createFromMysql(room.start_datetime);
				var dtEnd = Date.createFromMysql(room.end_datetime);
				
				$('#common_room_list').append('<ul data-room-id="'+room.id+'">\
					<li class="room_time">'+dtStart.format('yyyy년 MM월 dd일 hh:mm')+' ~ '+dtEnd.format('yyyy년 MM월 dd일 hh:mm')+'</li>\
					<li class="room_name">'+room.title+'</li>\
				</ul>');
			});
			
			// navigation buttons
			$('.page_group').empty();
			
			var totalPage = Math.ceil(dataJson.total_count / listcntPerPage);
			
			if (totalPage > 0) {
				$('.page_group').append('<span class="page_left" id="prevPage">◀</span>');
				
				for (var i = 0; i < totalPage; i++) {
					if (curPage == (i+1)) {
						$('.page_group').append('<span class="page_num" style="color:#FFFFFF; background-color:#a5a4a4; ">'+(i+1)+'</span>');
					} else {
						$('.page_group').append('<span class="page_num" style="cursor:pointer;">'+(i+1)+'</span>');
					}
				}
				
				$('.page_group').append('<span class="page_right" id="nextPage">▶</span>');
			}
		}
	}, 'json');
}

function nextPage()
{
	if ( isLastPage ) return;
	curPage++;
	updateConfList(curPage);
}

function prevPage()
{
	if ( curPage == 1 ) return;
	curPage--;
	updateConfList(curPage);
}

$(document).ready(function() {
	$(document).on("click", "#common_room_list > ul~ul", function() {
	var rid = $(this).data('room-id');

	var url = './recording_content.php';
	var form = $('<form action="' + url + '" method="post">' +
				'<input type="text" name="rid" value="' + rid+ '" />' +
				'</form>');
	$('body').append(form);
	form.submit();
	});

	$(document).on("click", "#nextPage", function() { nextPage(); } );
	$(document).on("click", "#prevPage", function() { prevPage(); } );
	$(document).on("click", ".page_num", function() {
		curPage = parseInt($(this).text(), 10);
		updateConfList(curPage);
	});

	updateConfList(curPage);

});	

</script>
	<!-- 상단 [ css : ../include/css/sub.css 참고]-->
	<div id="sub_top">
		<ul>
			<li class="r1">My i-Mentor</li>
			<li class="r2"><a href="./meeting_list.php">나의 회의</a><a href="./recording_list.php" class="sub_select">지난회의목록</a><a href="./friend.php">친구</a><a href="./note.php">쪽지</a><a href="../join/join_edit.php">회원정보</a><a href="./device_test.php">장치설정</a><!--a href="./cash.php">캐시</a--><span class="path">HOME > My FaceLink > 지난회의목록</span></li>
			<li class="r3"><span>지난회의목록</span></li>
		</ul>		
	</div>

	<!-- 본문 [ css : ../include/css/mypage.css 참고] -->
	<section id="sub_section">
		<div id="mypage">
			<div id="common_room_list">
				<ul class="title">
					<li class="room_time">일자</li>
					<li class="room_name">회의명</li>
				</ul>
			</div>
		</div>
		<div id="common_reserve_page">
			<div class="page_group">
				<span class="page_left" id="prevPage">◀</span>
				<span class="page_num">-</span><!--span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span-->
				<span class="page_right" id="nextPage">▶</span>
			</div>
		</div>
	</section>

	<!-- 하단 -->
<? include "../include/footer.php"; ?>
