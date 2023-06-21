<?php require_once("top.php"); ?>

<?php
$users_id = $_SESSION["user_id"];

$questions = mysqli_query($con, "SELECT * FROM post INNER JOIN users on post.user_id = users.user_id ORDER BY post_id DESC ");
$question_rows = mysqli_fetch_assoc($questions);
$row_count = mysqli_num_rows($questions);

?>


<?php if($row_count > 0) { ?>
<h3>Questions list</h3>
<br>
	<table class ="table table-hover">
		<tr>
			<th>NO</th>
			<th>Questions</th>
			<th>Name</th>
			<th>Date</th>
			<th>Delete</th>
			<th>Update</th>
		</tr>
		
		<?php if(isset($_GET["delete"])) { ?>
			<div class="alert alert-danger alert-dismissable">
			Question successfully deleted!
			</div>
		<?php } ?>
		
		<?php if(isset($_GET["update"])) { ?>
			<div class="alert alert-success alert-dismissable">
			Question successfully updated!
			</div>
		<?php } ?>

		
		<?php 
		
		do { ?>
		<tr>
			<td><?php  echo $question_rows["post_id"];?></td>
			<td><?php echo $question_rows["post_text"];?></td>
			<td><?php echo $question_rows["firstname"];?></td>
			<td><?php echo convertTimestamp($question_rows["post_date"]); ?></td>
			
			<td style="text-align:center;"><a class="delete" href ="question_delete.php?post_id=
			<?php echo $question_rows["post_id"]; ?>">
			<span class="glyphicon glyphicon-trash"></span></a>
			</td>
			<td style="text-align:center;"><a href ="question_update.php?post_id=
			<?php echo $question_rows["post_id"]; ?>">
			<span class="glyphicon glyphicon-edit" ></span></a></td>
			</td>
			
		</tr>
		<?php } while($question_rows =mysqli_fetch_assoc($questions)); ?>
		
	</table>
	
	<?php } else { ?>
			
		<div class="alert alert-warning">
				there is no question!
		</div>
			
	<?php } ?>

<?php require_once("footer.php"); ?>