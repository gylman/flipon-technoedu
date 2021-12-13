<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body>
<?php
extract($_POST);
extract($_GET);
if($to_id=="" | $from_id=="" | $pass=="" | $title=="" | $article==""){
?>      <script>alert("빈공간은 허용하지 않습니다."); location.href="./index.php";</script>
<?php    exit;
}
else{
    $smtp="smtp.daum.net";
    require_once("class.phpmailer.php");
    require_once("class.smtp.php");
    $mail=new PHPMailer(true);
    $mail->IsSMTP();
    try{
        $mail->Host=$smtp;
        $mail->SMTPAuth=true;
        $mail->Port=465;
        $mail->SMTPSecure="ssl";
        $mail->Username=$from_id;
        $mail->Password=$pass;
        $mail->SetFrom($from_id);
        $mail->AddAddress($to_id);
        $mail->Subject=$title;
        $mail->MsgHTML($article);
        $mail->Send();
    ?>      <script>alert("이메일을 전송하였습니다."); location.href="./index.php";</script>
    <?php   exit;
    }
    catch (phpmailerException $e){
        echo $e->errorMessage();
    }
    catch (Exception $e){
        echo $e->getMessage();
    }
}
?>
</body>
</html>
