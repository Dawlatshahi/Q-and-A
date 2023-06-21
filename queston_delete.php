<?php require_once("top.php"); ?>


<?php
	if(mysqli_query($con, "DELETE FROM post WHERE post_id=".$_GET["post_id"]))
	{
		header("location:question_list.php?delete=done");
	}
	else
	{
		header("location:question_list.php?delete=failed");
	}
	
?>

<?php require_once("footer.php"); ?>