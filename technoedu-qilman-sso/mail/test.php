<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0-rc.1/jquery.mobile-1.3.0-rc.1.min.css" />
<script src="http://code.jquery.com/jquery-1.9.0.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.0-rc.1/jquery.mobile-1.3.0-rc.1.min.js"></script>
<title>mail</title>
<style>
A:link{text-decoration:none; color:black;}
A:visited{text-decoration:none; color:black;}
A:hover{text-decoration:none; color:black;}
</style>
<script>
function AutoSize(h){
    var iframeHeight=(h).contentWindow.document.body.scrollHeight;
        (h).height=iframeHeight;
}
</script>
</head>
<body>
<div data-role="page">
        <div data-role="header">
                <h1>Mail</h1>
        </div>
        <div data-role="content" style="background: #FFF;">
                <form name="write" class="member" method="post" action="sendmail.php">
                    <label for="to_id">받는사람</label><input type="text" name="to_id" id="to_id" placeholder="받는사람의 이메일 주소"/>
                    <label for="from_id">보내는사람</label><input type="text" name="from_id" id="from_id" placeholder="Gmail.com만 지원합니다."/>
                    <label for="pass">비밀번호</label><input type="password" name="pass" id="pass" placeholder="자신의 비밀번호"/>
                    <label><span>제목</span><input type="text" name="title" id="title" placeholder="30글자 이하"></label>
                    <label><span>본문</span><textarea name="article" id="article" placeholder="<br>태그의 사용이 가능합니다."></textarea>
                    <label><input style="font-family: 'Nanum Gothic';" type="submit" value="sendmail" class="button"/></label>
                </form>
        </div>
        <div data-role="footer">
                <h1>윤정현 All rights reserved.</h1>
        </div>
</div>
</body>
</html>
