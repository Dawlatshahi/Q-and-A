<?php require_once("connection.php"); ?>
<?php
	
	$group_view = mysqli_query($con, "SELECT * FROM groups WHERE group_id = " . $_GET["group_id"]);
	$row_group_view = mysqli_fetch_assoc($group_view);

	$group_post = mysqli_query($con, "SELECT * FROM post WHERE group_id = " . $_GET["group_id"]);
	$row_group_post = mysqli_fetch_assoc($group_post);
	
	
	if(isset($_POST["post_text"])) { 
	
		$post_text = $_POST["post_text"];
		
		$location_id = "NULL";
		
		$user_id = $_SESSION["user_id"];
		$post_date = time();
		$privacy = "1";
		
		$group_id = $_GET["group_id"];
		
		$result = mysqli_query($con, "INSERT INTO post VALUES (NULL, $user_id, '$post_text', $post_date, $privacy, NULL, $group_id)");
		
		$post_id = mysqli_insert_id($con);
		
		if($result) {

			if(count($_FILES["picture"]["name"]) > 0) {
				try {
					$totalfiles = count($_FILES["picture"]["name"]);
					for($x=0; $x < $totalfiles; $x++) {
						$path = "images/post/" . time() . $_FILES["picture"]["name"][$x];				
						@move_uploaded_file($_FILES["picture"]["tmp_name"][$x], $path);				
						@resizeImage($path, 400, 300);
						@mysqli_query($con, "INSERT INTO post_picture VALUES (NULL, $post_id, '$path')");
					}
				}catch(Exception $e) {
					
				}
			}
			
			header("location:group_view.php?posted=true&group_id=" . $_GET["group_id"]);
		}
		else {
			header("location:group_view.php?post=notsaved&group_id=" . $_GET["group_id"]);
		}
		
	}
	
	
?>
<?php require_once("top.php"); ?>

<h2>
	<?php echo $row_group_view["group_name"]; ?>
</h2>


<form method="post" enctype="multipart/form-data">
		
			<textarea name="post_text" placeholder="Post in this group" rows="4" style="padding:5px 10px;width:100%"></textarea>
			<input style="margin-top:5px;width:200px;float:left;" multiple="multiple" type="file" name="picture[]">
			
			<input type="submit" style="margin-top:1px;" value="Post" class="btn btn-primary btn-sm">
			
			<datalist id="location">
				<?php do { ?>
					<option value="<?php echo $row_location["location_id"]; ?>"><?php echo $row_location["location_name"]; ?></option>
				<?php } while($row_location = mysqli_fetch_assoc($location)); ?>
			</datalist>
			
		</form>
		
<h2>Group Posts</h2>

<?php do { ?>
	
	<div class="alert alert-default">
		<?php echo $row_group_post["post_text"]; ?>
	</div>

<?php } while($row_group_post = mysqli_fetch_assoc($group_post)); ?>

<?php require_once("footer.php"); ?>