<?php

	require_once("connection.php");

	if(isset($_POST["post_id"])) { 
	
		$user_id = $_SESSION["user_id"];
		$post_id = $_POST["post_id"];
		$comment_date = time();
		$comment_text = $_POST["comment_text"];
		
		$result = mysqli_query($con, "INSERT INTO post_comment VALUES (NULL, $user_id, $post_id, $comment_date, '$comment_text')");
		
		if($result) {
			$profile = mysqli_query($con, "SELECT picture FROM profile WHERE user_id=$user_id");
			$row_profile = mysqli_fetch_assoc($profile);
			echo $row_profile["picture"];
		}
		else {
			echo "false";
		}
	}
	else {
		header("location:home.php");
	}

	
?>