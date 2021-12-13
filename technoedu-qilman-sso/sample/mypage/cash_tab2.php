<!-- My FaceLink > 캐시 > 사용내역 -->
<style>
#used { }
#used ul.title { border:1px solid #848586; }

#used .col1 { width:15%; }
#used .col2 { width:70%; }
#used .col3 { width:15%; }

/*#used ul~ul { cursor:pointer; }*/
#used ul~ul .col1 { text-align:center; }
#used ul~ul .col2 { text-align:left; padding-left:20px; }
#used ul~ul .col3 { text-align:right; padding-right:30px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
});	
</script>

<div id="used">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">날짜</li>
			<li class="col2">세부내역</li>
			<li class="col3">금액</li>
		</ul>
		<ul>
			<li class="col1">2010.10.26</li>
			<li class="col2">회의방 생성</li>
			<li class="col3">2,000원</li>
		</ul>
		<ul>
			<li class="col1">2010.10.26</li>
			<li class="col2">회의방 생성</li>
			<li class="col3">2,000원</li>
		</ul>
	</div>
</div>
<div id="common_reserve_page">
	<div class="page_group">
		<span class="page_left">◀</span>
		<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
		<span class="page_right">▶</span>
	</div>
</div>