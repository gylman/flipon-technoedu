<!-- My FaceLink > 캐시 > 충전내역 -->
<style>
#charge_cash { }
#charge_cash ul { width:100%; }
#charge_cash ul.title { border:1px solid #848586; }
#charge_cash ul li {  }

#charge_cash .col1 { width:15%; }
#charge_cash .col2 { width:60%; }
#charge_cash .col3 { width:10%; }
#charge_cash .col4 { width:15%; }

/*#charge_cash ul~ul { cursor:pointer; }*/
#charge_cash ul~ul > li { box-sizing:border-box; }
#charge_cash ul~ul .col1 { text-align:center; }
#charge_cash ul~ul .col2 { padding-left:20px; }
#charge_cash ul~ul .col3 { padding-left:20px; }
#charge_cash ul~ul .col4 { text-align:right; padding-right:30px; }
</style>

<script type="text/javascript">
$(document).ready(function() {
});	
</script>

<div id="charge_cash">
	<div id="common_room_list">
		<ul class="title">
			<li class="col1">날짜</li>
			<li class="col2">세부내역</li>
			<li class="col3">결제수단</li>
			<li class="col4">금액</li>
		</ul>
		<ul>
			<li class="col1">2010.10.26</li>
			<li class="col2">충전</li>
			<li class="col3">카드</li>
			<li class="col4">2,000원</li>
		</ul>
		<ul>
			<li class="col1">2010.10.26</li>
			<li class="col2">충전</li>
			<li class="col3">카드</li>
			<li class="col4">2,000원</li>
		</ul>
	</div>
</div>
<p style="display:block; height:30px;"><input type="button" class="btn_small darkgray" value="충전" style="float:right;"></p>
<div id="common_reserve_page">
	<div class="page_group">
		<span class="page_left">◀</span>
		<span class="page_num">1</span><span class="page_num">2</span><span class="page_num">3</span><span class="page_num">4</span>
		<span class="page_right">▶</span>
	</div>
</div>