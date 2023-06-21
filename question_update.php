<?php require_once("top.php"); ?>
<?php
	if(!isset($_SESSION)){
		session_start();
	}
	$question_update =mysqli_query($con,"SELECT *FROM post WHERE post_id=".$_GET["post_id"]);
	$row_question_update =mysqli_fetch_assoc($question_update);

	if(isset($_POST["text"])) {
			$question =$_POST["text"];

		if(mysqli_query($con,"UPDATE post SET post_text='$question' WHERE post_id=".$_GET["post_id"]))
			{
				header("location:question_list.php?update=updatedone");
			}
			else
			{
				header("location:question_list.php?update=failed");
			}
			
	}
?>


<h4>Edit Question</h4>
<div class="col-lg-9 col-md-9 col-sm-12 col-xm-12">
	<form method="post" enctype="multipart/form-data">
		
		<div>
			<h6>Question</h6>
			<textarea rows="5" name="text" class="form-control" ><?php
			echo $row_question_update["post_text"]; ?>
			</textarea>
		</div>
	

		<div>
			<input type="submit" id="submit" value="Save"
			class="btn btn-primary form-control nav-icon fa fa-login">
		</div>

	</form>
</div>
<?php require_once("footer.php"); ?>