<?php
	$conn = mysqli_connect("localhost", "mentorservice", "roskfl");
	        mysqli_select_db($conn, "facelink");
    if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])){ 
		$emailValue = $_GET['emailValue'];
		$roomNumber = $_GET['roomNumber'];
		$flag = 0;
		$frontEmail;
		$backEmail;
		$query = "DELETE FROM guest_user where date(created) >= date(subdate(now(), INTERVAL 30 DAY)) and date(created) <= date(subdate(now(),INTERVAL 1 DAY))";
        $result = mysqli_query($conn, $query);
		$query = "DELETE FROM emailCheck where date(created) >= date(subdate(now(), INTERVAL 30 DAY)) and date(created) <= date(subdate(now(),INTERVAL 1 DAY))";
		$result = mysqli_query($conn, $query);
		$query  = "SELECT * FROM emailCheck WHERE id = '".$roomNumber."'";
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result)){
			echo $row['email'];
	        if($row['email'] == $emailValue){
				$flag = $flag + 1;
				 list($frontEmail,$backEmail) = explode("@", $emailValue);
				break;
			}
			else
			{
				continue;
			}
		}
		if($flag == 1){
			$query = "INSERT INTO guest_user(userID,userPW,userNAME,created) VALUES('".$frontEmail."_".$backEmail."','".$frontEmail."_".$backEmail."','".$frontEmail."_".$backEmail."',now())";
			$result = mysqli_query($conn, $query);
			session_start();
			$_SESSION["user_id"] = $frontEmail."_".$backEmail;
			$_SESSION["user_name"] = $frontEmail."_".$backEmail;
			$_SESSION["userEmail"] = $emailValue;
			$_SESSION["roomNumber"] = $roomNumber;
		}
        // sykim 2021.7.9
        //header('Location: https://mentorservice.co.kr/conference/room_list.php');
        header('Location: https://technoedu.co.kr/conference/room_list.php');
  		
  }else{
        echo "<script>
                alert('잘못된 접근입니다.');
                location.href='javascript:history.go(-1);';
            </script>";
    }
?>
