<?php

	require_once("connection.php");

	if(isset($_POST["post_id"])) { 
	
		$user_id = $_SESSION["user_id"];
		$post_id = $_POST["post_id"];
		
		$result = mysqli_query($con, "DELETE FROM post_like WHERE post_id=$post_id AND user_id=$user_id");
		
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