<?php require_once("connection.php"); ?>
<?php

	$user_id = $_SESSION["user_id"];
	$blocked_user = $_POST["blocked_user"];
	$block_date = time();

	$result = mysqli_query($con, "INSERT INTO block VALUES ($user_id, $blocked_user, $block_date)");
	
	if($result) {
		echo "ok";
	}
	else {
		echo "error";
	}

?>