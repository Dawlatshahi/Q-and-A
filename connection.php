<?php

	$con = mysqli_connect("localhost", "root", "");
	mysqli_select_db($con, "Question_answer");

	if(!isset($_SESSION)) {
		session_start();
	}
	
	require_once("tools.php");

?>