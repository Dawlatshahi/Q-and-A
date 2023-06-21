<?php require_once("connection.php"); ?>
<?php
	mysqli_query($con, "UPDATE friend SET seen = 1 WHERE receiver_id = " . $_SESSION["user_id"]);
	
	$request = mysqli_query($con, "SELECT * FROM friend INNER JOIN users ON users.user_id = friend.sender_id INNER JOIN profile ON users.user_id = profile.user_id WHERE receiver_id = " . $_SESSION["user_id"] . " AND status = 0");
	$row_request = mysqli_fetch_assoc($request);
	
?>
<?php require_once("top.php"); ?>

<h2>Friend Requests</h2>

<table width="100%">

	<?php do { ?>
		<tr>
			<td>
				<img src="<?php echo $row_request["picture"]; ?>" width="50">
				<?php echo $row_request["firstname"]; ?> 
				<?php echo $row_request["lastname"]; ?>
				
				<div class="pull-right" style="margin-top:15px;">
				
					<a class="request_accept" href="#" id="<?php echo $row_request["sender_id"]; ?>">
						Accept
					</a>
					
						&nbsp;
					
					<a class="request_reject" href="#" id="<?php echo $row_request["sender_id"]; ?>">
						Reject
					</a>
				</div>
			</td>
		</tr>
	<?php } while($row_request = mysqli_fetch_assoc($request)); ?>
</table>


<?php require_once("footer.php"); ?>