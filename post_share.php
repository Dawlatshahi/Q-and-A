<?php require_once("connection.php"); ?>
<?php

	$post_id = $_POST["post_id"];
	$share_text = $_POST["share_text"];
	$user_id = $_SESSION["user_id"];
	$share_date = time();
	
	$result = mysqli_query($con, "INSERT INTO post_share VALUES (NULL, $user_id, $post_id, $share_date, '$share_text')");
	
	if($result) {
		echo "ok";
	}
	else {
		echo "error";
	}

?>