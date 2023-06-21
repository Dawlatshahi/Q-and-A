<?php require_once("connection.php"); ?>
<?php

	$sender_id = $_POST["sender_id"];
	$receiver_id = $_SESSION["user_id"];
	
	$result = mysqli_query($con, "UPDATE friend SET status = 1 WHERE sender_id = $sender_id AND receiver_id = $receiver_id");
	
	if($result) {
		echo "ok";
	}
	else {
		echo "error";
	}

?>