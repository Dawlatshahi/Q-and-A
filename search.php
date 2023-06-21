<?php require_once("connection.php"); ?>
<?php
	$q = $_GET["q"];	
	$users = mysqli_query($con, "SELECT users.user_id, firstname, lastname, picture, (SELECT status FROM friend WHERE sender_id = " . $_SESSION["user_id"] . " AND receiver_id = users.user_id) AS request_sender_status, (SELECT status FROM friend WHERE receiver_id = " . $_SESSION["user_id"] . " AND sender_id = users.user_id) AS request_recv_status, (SELECT blocked_user FROM block WHERE (blocked_user = users.user_id AND user_id = " . $_SESSION["user_id"] . ") OR (blocked_user = " . $_SESSION["user_id"] . " AND user_id = users.user_id)) AS blocked FROM users INNER JOIN profile ON users.user_id = profile.user_id WHERE (firstname LIKE '%$q%' OR lastname LIKE '%$q%') AND users.user_id <> " . $_SESSION["user_id"]);
	$row_users = mysqli_fetch_assoc($users);
?>
<?php require_once("top.php"); ?>

<h3>Search</h3>

<table width="100%">

	<?php do { ?>
	<?php if($row_users["blocked"] == "") { ?>
	<tr>
		<td><img src="<?php echo $row_users["picture"]; ?>" width="60"></td>
		<td style="padding-left:10px;"><?php echo $row_users["firstname"]; ?>
			<?php echo $row_users["lastname"]; ?>

			<a href="#" id="<?php echo $row_users["user_id"]; ?>" class="block pull-right btn btn-danger btn-sm" style="margin-left:5px;">
				Block
			</a>
			
			<?php if($row_users["request_sender_status"] == "" && $row_users["request_recv_status"] == "") { ?>
			<a href="#" id="<?php echo $row_users["user_id"]; ?>" class="friend_request pull-right btn btn-primary btn-sm">
				Add Friend
			</a>
			<?php } else { ?>
				
				<?php if($row_users["request_sender_status"] == 1 || $row_users["request_recv_status"] == 1) { ?>
					<span class="btn btn-default btn-sm pull-right">
					Friends
					</span>
				<?php } else { ?>
					<span class="btn btn-default btn-sm pull-right">
					Request Sent
					</span>
				<?php } ?>
				
			<?php } ?>
			
		</td>
	</tr>
	<?php } ?>
	<?php } while($row_users = mysqli_fetch_assoc($users)); ?>
	
</table>

<?php require_once("footer.php"); ?>