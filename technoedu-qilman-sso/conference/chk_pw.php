<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>입장 비밀번호 입력</title>

<!-- css -->
<link rel="stylesheet" type="text/css" href="../css/basic.css">
<link rel="stylesheet" type="text/css" href="../css/conference.css">
<style>
#wrap { margin:0px; padding:0px; border:1px solid #000000; }
p { height:40px; padding:0px 10px; font-size:16px; line-height:40px; background:#454545; color:white; }
#close { display:block; float:right; width:27px; height:27px; cursor:pointer; }
div { padding:10px; }
input[type=text] { width:90%; padding:10px; color:#828181; margin-top:30px; }
#common_btn_area { width:180px; }

</style>

<script src="../js/html5shiv.js" type="text/javascript"></script>
<script src="../js/jquery.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function() {
	$("#close").click(function(){
		self.close();
	});
});	
</script>

</head>
<body>

<div id="wrap">
	<p>입장 비밀번호 입력<span id="close"><img src="../images/close.png"></span></p>
	<div>		
		<input type="text" value="회의방 비밀번호를 입력해 주세요." >
		<div id="common_btn_area">
			<input type="button" value="확인" class="btn_small blue">
			<input type="button" value="취소" class="btn_small darkgray">	
		</div>
	</div>
</div>
</body>
</html> 