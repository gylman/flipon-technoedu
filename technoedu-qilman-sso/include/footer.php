<script type="text/javascript">
$(document).ready(function() {
	
	var ul_start = "<ul class='notice' data-board_id='";
	var ul_start_end = "'>";
	var ul_li_start = "<li class='subject'>";
	var ul_li_end = "</li>";
	var ul_li_date_start = "<li class='date'>";
	var ul_li_date_end = "</li>";
	var ul_end = "</ul>";
	
	var postJsonData = {
		page : 0,
		limit : 4,
		search_val : ""
	};
	$.post( g_apiUrlRoot+"board_notice_list.php", postJsonData, function( dataJson) {
		
		if (dataJson.rt_code == 0) {
			
			var list = $("#notice")
			if(dataJson.board.length == 0){
				list.append(
					ul_start
					+ ul_start_end
					+ ul_li_start
					+ "게시물이 없습니다"
					+ ul_li_end
					+ ul_li_date_start
					+ ul_li_date_end
					+ ul_end
				);	
			}
			for(var i=0; i<dataJson.board.length;i++){
				var yyyymmdd = dataJson.board[i].reg_datetime;
				yyyymmdd = yyyymmdd.substring(0, 10);
				list.append(
					ul_start
					+ dataJson.board[i].id
					+ ul_start_end
					+ ul_li_start
					+ dataJson.board[i].title
					+ ul_li_end
					+ ul_li_date_start
					+ yyyymmdd
					+ ul_li_date_end
					+ ul_end
				);
			}
			
		} else {
			//alert('공지사항을 가져오는데 실패하였습니다.\n잠시 후 다시 시도해주세요.');
		}
	}, "json");
	
	$("#notice").on("click","ul",function(){
		var bid = $(this).data("board_id");
		if(bid != ""){
			location.href = "../contact/content.php?type=footer&bid=" + bid;
		}
	});
});
</script>
	<footer id="footer">
		<ul>
			<li>
				<!-- <P class="tit">CONTACT INFORMATION</P>
				305-509<BR>
				대전광역시 유성구 테크노2로 340 2층<BR>
				Tel : 042-931-5025 (직통:070-7729-7034)<BR>
				Fax : 042-931-5026<BR>
			</li>
			<li>
				<P class="tit">CS CENTER</P>
				<P class="tel">042-931-5025</P>
				월요일~금요일 AM 09:00~PM 06:00<BR>
				(토,일요일 및 공휴일은 휴무입니다.)
			</li>
			<li id="notice">
				<P class="tit">NOTICE</P>
			</li>
			<li class="icon"><a></a><a></a><a></a><a></a></li>
		</ul>
		<p> COPYRIGHT(C) WOOKSUNG MEDIA CO., LTD. ALL RIGHTS RESERVED.</p> -->
		<li id="contact">
				<P class="tit">CONTACT INFORMATION</P>
				<p class="add">305-509<BR>
				
				대전광역시 유성구 테크노2로 340 2층<BR>
				Tel : 042-931-5025 (직통:070-7729-7034)<BR>
				Fax : 042-931-5026<BR></p>
			</li>
			<li id="cs">
				<P class="tit">CS CENTER</P>
				<P class="tel">042-931-5025</P>
				<p class="time">월요일~금요일 AM 09:00~PM 06:00<BR>
				(토,일요일 및 공휴일은 휴무입니다.)<p>
			</li>
			<li id="notice">
				<P class="tit">NOTICE</P>
			</li>
			<li class="icon"><a></a><a></a><a></a><a></a></li>
		</ul>
		<p> COPYRIGHT(C) WOOKSUNG MEDIA CO., LTD. ALL RIGHTS RESERVED.</p>
	</footer>
</div>
</body>
</html> 
