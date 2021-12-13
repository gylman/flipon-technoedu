<?php
	session_start();
	$conn = mysqli_connect("localhost", "mentorservice", "roskfl");
	mysqli_select_db($conn, "facelink");
    include "Sendmail.php";
    $sendmail = new Sendmail();
    $toEmail = $_GET['emailValue'];
    $fromEmail = $_GET['fromEmail'];
	$roomNumber = $_GET['roomNumber'];
	$query = "INSERT INTO emailCheck (id,email,created) VALUES('".$roomNumber."','".$toEmail."',now())";
	$result = mysqli_query($conn, $query);
    $query = "SELECT pw FROM room_list where id ='".$roomNumber."'";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$row = $row['pw'];
// sykim 2021.7.9
//    $to= $toEmail; $from= $fromEmail; $subject="i-mentorService 회의방 초대장 입니다."; $body="주소 클릭시 방 목록 창으로 이동합니다.\n"."https://mentorservice.co.kr/conference/landomjoin.php?"."emailValue=".$toEmail."&fromEmail=".$fromEmail."&roomName=&roomPassword=&roomNumber=".$roomNumber."\n"."방 번호 : "."090"."$roomNumber\n"."이 방번호로 입장해주시길 바랍니다."; $cc_mail=""; $bcc_mail=""; 
    $to= $toEmail; $from= $fromEmail; $subject="i-mentorService 회의방 초대장 입니다."; $body="주소 클릭시 방 목록 창으로 이동합니다.\n"."https://technoedu.co.kr/conference/landomjoin.php?"."emailValue=".$toEmail."&fromEmail=".$fromEmail."&roomName=&roomPassword=&roomNumber=".$roomNumber."\n"."방 번호 : "."090"."$roomNumber\n"."이 방번호로 입장해주시길 바랍니다."; $cc_mail=""; $bcc_mail=""; 

    $sendmail->send_mail($to, $from, $subject, $body,$cc_mail,$bcc_mail);
?>
