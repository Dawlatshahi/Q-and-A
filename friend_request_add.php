<?php require_once("connection.php"); ?>
<?php

	$sender_id = $_SESSION["user_id"];
	$receiver_id = $_POST["user_id"];
	$request_date = time();

	$result = mysqli_query($con, "INSERT INTO friend (sender_id, receiver_id, request_date) VALUES ($sender_id, $receiver_id, $request_date)");
	
	if($result) {
		echo "ok";
	}
	else {
		echo "error";
	}

?>