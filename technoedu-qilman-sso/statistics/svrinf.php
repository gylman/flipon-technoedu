<?php
$file = "data.txt";
file_put_contents($file, "User ID: ".$_POST['userid']." MCU ID: ".$_POST['mcuid']." Room ID: ".$_POST['roomid']." Type: ".$_POST['type']." Time: ".$_POST['time']);

echo "User ID: ".$_POST['userid']." MCU ID: ".$_POST['mcuid']." Room ID: ".$_POST['roomid']." Type: ".$_POST['type']." Time: ".$_POST['time'];
?>
