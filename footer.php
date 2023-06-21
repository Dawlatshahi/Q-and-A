<?php
	
$friends = mysqli_query($con, "SELECT *, (SELECT blocked_user FROM block WHERE (blocked_user = users.user_id AND user_id = " . $_SESSION["user_id"] . ") OR (blocked_user = " . $_SESSION["user_id"] ." AND user_id = users.user_id))AS blocked FROM friend INNER JOIN users ON users.user_id = friend.receiver_id INNER JOIN profile ON users.user_id = profile.user_id WHERE status = 1 AND sender_id = " .$_SESSION["user_id"] . " UNION SELECT *, (SELECT blocked_user FROM block WHERE (blocked_user = users.user_id AND user_id = " . $_SESSION["user_id"] . ") OR (blocked_user = " . $_SESSION["user_id"] . " AND user_id = users.user_id)) AS blocked FROM friend INNER JOIN users ON users.user_id = friend.sender_id INNER JOIN profile ON users.user_id = profile.user_id WHERE status = 1 AND receiver_id = " . $_SESSION["user_id"]);$row_friends = mysqli_fetch_assoc($friends);
?>

			</div>
		
			<div id="friend" class="col-lg-2 col-md-2 col-sm-2 hidden-xs" style="padding-top:10px; background-color:#f5f5f5; min-height:700px;">
		
			Your Profile
				
				<div style="margin-top:10px;">
					<img src="<?php echo $row_profile["picture"]; ?>" width="35">
					<big><b><?php echo $row_profile["firstname"]; ?>
					<?php echo $row_profile["lastname"]; ?></b></big>
				</div>
				
				<br>
				
				<h4>Friends </h4>
				<div>
				<?php do { ?>
				<?php if($row_friends["blocked"] == "") { ?>
					<div style="margin-bottom:10px;">
						<img src="<?php echo $row_friends["picture"]; ?>" width="40" style="width:40px; height:40px; margin-right:5px;" class="img-circle">
						<?php echo $row_friends["firstname"]; ?>
						<?php echo $row_friends["lastname"]; ?>
					</div>
				<?php } ?>
				<?php } while($row_friends = mysqli_fetch_assoc($friends)); ?>
				
		</div>
		</div>
		
		
		
		
	
		<div class="clearfix"></div>
	
		<div id="footer">
			Copyright &copy;
			<?php echo date("Y"); ?>
			All right reserved.
		</div>
	
	</div>

</body>
</html>