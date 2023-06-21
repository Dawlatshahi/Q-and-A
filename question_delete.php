


<?php
require_once("connection.php");
	if(mysqli_query($con, "DELETE FROM post WHERE post_id=".$_GET["post_id"]))
	{
		header("location:question_list.php?delete=deletedone");
		
	
	}
	else
	{
		header("location:question_list.php?delete=failed");
	}
	
?>

