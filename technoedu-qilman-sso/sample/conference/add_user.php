<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>입장 비밀번호 입력</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="../include/css/basic.css">
<link rel="stylesheet" type="text/css" href="../include/css/conference.css">
<style>
#wrap { margin:0px; padding:0px; border:1px solid #000000; }
p.subject { height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white; }
.close { display:inline-block; float:right; width:27px; height:27px; margin:3px 0px; cursor:pointer; }

#search { padding:10px; }
#search select { width:80px; height:34px; border:1px solid #d3d3d3; }

#user { width:94%; height:220px; padding:10px; margin:10px; border:1px solid #d3d3d3; font-size:12px; font-weight:normal; overflow-x:hidden; overflow-y:scroll;}
#user > li { height:30px; line-height:30px; border-bottom:1px solid #e0e0e0; }
#user > li > span { }
#user > li > span.name { margin-left:10px; }
#user > li > span.group { margin-left:10px; }

#common_btn_area { width:170px; }
</style>

<script src="../include/js/html5shiv.js" type="text/javascript"></script>
<script src="../include/js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$(".close").click(function(){
		self.close();
	});
});	
</script>

</head>
<body>

<div id="wrap">
	<p class="subject">회원검색<span class="close"><img src="../images/close.png" class="close"></span></p>
	<div id="search">		
		<span>
			<select>
				<option>이름</option>
			</select>
		</span>
		<span id="common_reserve_search"><input type="text" class="input_search"><input type="button" class="btn_search"></span>
	</div>
	<ul id="user">
		<? For($i=0;  $i<10; $i++) { ?>
		<li>
			<span class="name"><input type="checkbox"> 이순신</span>
			<span class="group">소속명 : 거북선</span>
		</li>
		<? } ?>
	</ul>
	<div id="common_btn_area">
		<input type="button" value="확인" class="btn_small blue">
		<input type="button" value="취소" class="btn_small darkgray">	
	</div>
</div>
</body>
</html> 