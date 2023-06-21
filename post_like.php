<?php

	require_once("connection.php");

	if(isset($_POST["post_id"])) { 
	
		$user_id = $_SESSION["user_id"];
		$like_date = time();
		$post_id = $_POST["post_id"];
		
		$result = mysqli_query($con, "INSERT INTO post_like VALUES ($user_id, $post_id, $like_date)");
		
		if($result) {
			echo "true";
		}
		else {
			echo "false";
		}
	}
	else {
		header("location:home.php");
	}

	
?>