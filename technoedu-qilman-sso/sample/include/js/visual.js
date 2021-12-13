$(document).ready(function(){
	/* 전역변수 선언*/
	var g_visual_select = -1;	// 메인비주얼
	var g_direction = -1;		// 메인비주얼 방향(0:왼쪽, 1:오른쪽)
	var intv = -1;

	visual_movePlay();	// 로딩되면 visual자동 슬라이딩

	/* visual 관련 */
	function visual_moveAuto() {
		if(g_visual_select <= 0)
			g_direction = 0;

		if(g_visual_select >= 2)
			g_direction = 2;

		if(g_direction == 0)
			visual_moveSelect(g_visual_select+1);			
		else
			visual_moveSelect(g_visual_select-1);

	}

	function visual_movePlay() {
		intv = setInterval(function(){ visual_moveAuto();}, 2500);
	}

	function visual_moveStop() {
		clearInterval(intv);
		intv = -1;
	}

	function visual_moveSelect(n) {		
		var dura = 0;
		if(g_visual_select != n) {
			$(".visual_btn_area > ul > li > a:eq("+g_visual_select+")").removeClass("cur_visual_select");

			dura = n * -100;			
			g_visual_select = n;
			
			$(".visual_btn_area > ul > li > a:eq("+g_visual_select+")").addClass("cur_visual_select");
			$("#regbg").animate({"marginLeft":dura+"%"}, 200);
		}
	}

	$(".visual_leftbtn").click(function(event) {
		if(g_visual_select > 0) {
			if(intv > -1) { visual_moveStop(); }
			visual_moveSelect(g_visual_select-1);
		};
	});

	$(".visual_rightbtn").click(function(event) {
		if(g_visual_select < 2) {
			if(intv > -1) { visual_moveStop(); }
			visual_moveSelect(g_visual_select+1);
		}
	});

	$(".visual_btn_area > ul > li > a").click(function(event){		
		var n = parseInt($(this).text());
		visual_moveStop();
		visual_moveSelect(n);		
	});

	$("#direction > li").hover(
		function (){
			visual_moveStop();
		},
		function (){
			visual_movePlay();
		}		
	);
});