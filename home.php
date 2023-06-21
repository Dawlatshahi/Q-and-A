<?php require_once("connection.php"); ?>
<?php

	$location = mysqli_query($con, "SELECT * FROM location ORDER BY location_name ASC");
	$row_location = mysqli_fetch_assoc($location);

	$user_id = $_SESSION["user_id"];

	$post = mysqli_query($con, "SELECT ' ' AS group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id IN ( SELECT sender_id FROM friend WHERE receiver_id = " . $_SESSION["user_id"] . " AND status = 1 UNION SELECT receiver_id FROM friend WHERE sender_id = " . $_SESSION["user_id"] . " AND status = 1 ) UNION SELECT ' ' AS group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id = " . $_SESSION["user_id"] . " 
	UNION SELECT ' ', post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post_share INNER JOIN post ON post.post_id = post_share.post_id INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id IN ( SELECT sender_id FROM friend WHERE receiver_id = " . $_SESSION["user_id"] . " AND status = 1 UNION SELECT receiver_id FROM friend WHERE sender_id = " . $_SESSION["user_id"] . " AND status = 1 ) UNION SELECT ' ' AS group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post_share INNER JOIN post ON post.post_id = post_share.post_id INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id = " . $_SESSION["user_id"] . "
	UNION SELECT group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id INNER JOIN groups ON groups.group_id = post.group_id WHERE (post.group_id IN (SELECT group_id FROM group_admin WHERE user_id = $user_id UNION SELECT group_member.group_id FROM group_member WHERE user_id = $user_id))
	UNION SELECT ' ' AS group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post_share INNER JOIN post ON post.post_id = post_share.post_id INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id IN ( SELECT sender_id FROM friend WHERE receiver_id = " . $_SESSION["user_id"] . " AND status = 1 UNION SELECT receiver_id FROM friend WHERE sender_id = " . $_SESSION["user_id"] . " AND status = 1 ) UNION SELECT ' ' AS group_name, post.post_id, users.user_id, firstname, lastname, profile.picture, post_date, post_text, (SELECT post_id FROM post_like WHERE post_like.post_id = post.post_id AND user_id = " . $_SESSION["user_id"] . ") AS like_status, (SELECT COUNT(post_id) FROM post_like WHERE post_id = post.post_id) AS total_like FROM post_share INNER JOIN post ON post.post_id = post_share.post_id INNER JOIN users ON users.user_id = post.user_id INNER JOIN profile ON users.user_id = profile.user_id WHERE post.group_id IS NULL AND post.user_id = " . $_SESSION["user_id"] . " 
	ORDER BY post_id DESC");
	$row_post = mysqli_fetch_assoc($post);
	$totalRows_post = mysqli_num_rows($post);
	
	if(!isset($_SESSION["user_id"])) {
		header("location:index.php");
	}
	
	if(isset($_POST["post_text"])) { 
	
		$post_text = $_POST["post_text"];
		
		$location_id = $_POST["location_id"];
		if($location_id == "") {
			$location_id = "NULL";
		}
		
		$user_id = $_SESSION["user_id"];
		$post_date = time();
		$privacy = $_POST["privacy"];
		
		$result = mysqli_query($con, "INSERT INTO post VALUES (NULL, $user_id, '$post_text', $post_date, $privacy, NULL, NULL)");
		
		$post_id = mysqli_insert_id($con);
		
		if($result) {

			if(count($_FILES["picture"]["name"]) > 0) {
				$totalfiles = count($_FILES["picture"]["name"]);
				for($x=0; $x < $totalfiles; $x++) {
					$path = "images/post/" . time() . $_FILES["picture"]["name"][$x];				
					move_uploaded_file($_FILES["picture"]["tmp_name"][$x], $path);				
					resizeImage($path, 400, 300);
					mysqli_query($con, "INSERT INTO post_picture VALUES (NULL, $post_id, '$path')");
				}
			}
			
			header("location:home.php?posted=true");
		}
		else {
			header("location:home.php?post=notsaved");
		}
		
	}
	

	$profile = mysqli_query($con, "SELECT * FROM profile WHERE user_id = (SELECT user_id FROM users WHERE user_id = " . $_SESSION["user_id"] . ")");
	$row_profile = mysqli_fetch_assoc($profile);
	
	
	if(isset($_POST["job_title"])) {
		$job_title = $_POST["job_title"];
		$job_organization = $_POST["job_orgazation"];
		$hire_date = $_POST["hire_date"];
		$end_date = $_POST["end_date"];
		$status = $_POST["status"];
		$marital = $_POST["marital"];
		$country = $_POST["country"];
		$province = $_POST["province"];
		$district = $_POST["district"];
		
		if($_FILES["picture"]["name"] != "") {
			$picture_path = "images/profile/" . time() . $_FILES["picture"]["name"];
			move_uploaded_file($_FILES["picture"]["tmp_name"], $picture_path);
		}
		
		if($_FILES["cover_photo"]["name"] != "") {
			$cover_path = "images/cover/" . time() . $_FILES["cover_photo"]["name"];
			move_uploaded_file($_FILES["cover_photo"]["tmp_name"], $cover_path);
		}

		$uid = $_SESSION["user_id"];
		
		$result = mysqli_query($con, "INSERT INTO profile VALUES ($uid, '$cover_path', '$picture_path', '$job_title', '$job_organization', '$hire_date', '$end_date', '$status', '$marital', '$country', '$province', '$district')");

		if($result) {
			header("location:home.php?profile=saved");
		}
		else {
			header("location:home.php?error=profilenotsaved");
		}
	}
	
	
?>
<?php require_once("top.php"); ?>


	<?php
	if(mysqli_num_rows($profile) == 1) { ?>
		
		<br>
		
	<form method="post" enctype="multipart/form-data">
		
			<textarea name="post_text" placeholder="Ask your question here....!" rows="4" style="padding:5px 10px;width:100%"></textarea>
			<input style="margin-top:5px;width:200px;float:left;" multiple="multiple" type="file" name="picture[]">
			
			<input style="margin-top:3px;margin-right:5px;width:40px;float:left;" type="text" list="location" name="location_id">
			
			<select name="privacy" style="float:left;margin-right:3px;width:50px;margin-top:5px;">
				<option value="1">Public</option>
				<option value="2">Friends</option>
				<option value="3">Only Me</option>
			</select>
			
			<input type="submit" style="margin-top:1px;" value="Post" class="btn btn-primary btn-sm">
			
			<datalist id="location">
				<?php do { ?>
					<option value="<?php echo $row_location["location_id"]; ?>"><?php echo $row_location["location_name"]; ?></option>
				<?php } while($row_location = mysqli_fetch_assoc($location)); ?>
			</datalist>
			
		</form>
		
		
		<BR>
		<br>
		
		
		<?php if($totalRows_post > 0) { ?>
		
		<?php do { ?>
		
			<div style="background-color:white;padding:10px;border-radius:3px;">
			
			<span style="float:right;">
				<?php echo $row_post["group_name"]; ?>
			</span>
			
		
			
			<img style="float:left;margin-right:5px;" src="<?php echo $row_post["picture"]; ?>" width="50" height="50">
			
			<?php echo $row_post["firstname"]; ?> 
			<?php echo $row_post["lastname"]; ?> 
			<br>
			
			<?php 
				echo convertTimestamp($row_post["post_date"]);
			?>
			
			<div class="clearfix"></div>
			
			<div>
			
			<div class="post_text" style="margin-top:5px;"><?php echo $row_post["post_text"]; ?></div>
			<div class="post_photo" style="margin-bottom:5px;">
			<?php 
				$picture = mysqli_query($con, "SELECT * FROM post_picture WHERE post_id = " . $row_post["post_id"]);
				$row_picture = mysqli_fetch_assoc($picture);
				$totalRows_picture = mysqli_num_rows($picture);
				
				if($totalRows_picture > 0) { ?>
				<?php do { ?>
					<img src="<?php echo $row_picture["picture"]; ?>" style="width:50%;float:left;">
				<?php 
			
				} 
			
				while($row_picture = mysqli_fetch_assoc($picture)); ?>

				<?php } ?>
				
				<div class="clearfix"></div>
				
			</div>			


			<div class="clearfix"></div>
			
			<span style="color:#888;">
			<span class="glyphicon glyphicon-thumbs-up"></span>
				<span id="<?php echo $row_post["post_id"]; ?>" class="total_like"><?php echo $row_post["total_like"]; ?></span>
			</span>
			
				
				<div class="clearfix" style="margin-bottom:5px;"></div>
			
				<?php if($row_post["like_status"] != "") { ?>
				<a href="#" class="btn_unlike" id="<?php echo $row_post["post_id"]; ?>">
					<span class="glyphicon glyphicon-thumbs-up"></span>
					Unlike 
				</a>
				<?php } else { ?>
					<a href="#" class="btn_like" id="<?php echo $row_post["post_id"]; ?>" style="margin-right:10px;">
							<span class="glyphicon glyphicon-thumbs-up"></span>
					Like</a>
				<?php } ?>
			
			
			
			<a href="#" class="btn_comment">
				<span class="glyphicon glyphicon-comment"></span>
			Add answer
				
			</a>
			
			<?php
				$post_comment = mysqli_query($con, "SELECT * FROM post_comment INNER JOIN profile ON profile.user_id = post_comment.user_id WHERE post_id = " . $row_post["post_id"]);
				$row_post_comment = mysqli_fetch_assoc($post_comment);
				$totalRows_post_comment = mysqli_num_rows($post_comment);
			?>
			
			<?php if($totalRows_post_comment > 0) { ?>
			(<?php echo $totalRows_post_comment; ?>)
			<?php } ?>
			
			
			</div>
			
			
			<div>
				<input type="textbox" size="70" id="<?php echo $row_post["post_id"]; ?>" class="txt_comment">
				
			<div class="post_comment">
				<?php 
					
					if($totalRows_post_comment > 0) {
					do { ?>
						<div class="comment" style="padding:5px;">
							<img src="<?php echo $row_post_comment["picture"]; ?>" style="float:left;width:30px;margin-right:5px;" class="img-circle">
							<div style="float:right;">
								<?php echo convertTimestamp($row_post_comment["comment_date"]); ?>
							</div>
							<?php echo $row_post_comment["comment_text"]; ?>
							<div class="clearfix"></div>
						</div>
					<?php } while($row_post_comment = mysqli_fetch_assoc($post_comment)); ?>
			
				<a href="#" class="more_comment">
					View More Answer
				</a>

					<?php } ?>
			</div>
			
			
			
			</div>
			
			</div>
			
			<div style="height:10px;"></div>
			
		<?php } while($row_post = mysqli_fetch_assoc($post)); ?>
			
			<div class="modal fade" id="mydialog" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">	
						<div class="modal-header">
							<a href="#" id="btn_share" class="btn btn-primary pull-right">Share</a>
							<h4 class="modal-title">Share This Post</h4>
						</div>
						<div class="modal-body">
							<textarea id="share_text" class="form-control" placeholder="Say something about this link" style="width:100%;max-width:100%;margin-bottom:10px;"></textarea>
							<div class="clearfix"></div>
							<div id="post_content">
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		
		<?php } ?>
		
		
	<?php } else { ?> 
	
		<h3>Your Profile</h3>
		
		<form method="post" enctype="multipart/form-data">
			
			<div class="input-group">
				<span class="input-group-addon">
					Profile Picture: 
				</span>
				<input class="form-control" type="file" name="picture">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Cover Photo:
				</span>
				<input class="form-control" type="file" name="cover_photo">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Job Title:
				</span>
				<input class="form-control" type="text" name="job_title">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Job Organization:
				</span>
				<input class="form-control" type="text" name="job_orgazation">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Hire Date:
				</span>
				<input class="form-control" type="text" name="hire_date">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					End Date:
				</span>
				<input class="form-control" type="text" name="end_date">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Status:
				</span>
				<input class="form-control" type="text" name="status">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Marital Status:
				</span>
				<input type="radio" name="marital" value="0"> Single 
				<input type="radio" name="marital" value="1"> Married 
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Country:
				</span>
				<select name="country" class="form-control">
					<option value="Afghanistan">Afghanistan</option> 
					<option value="Albania">Albania</option> 
					<option value="Algeria">Algeria</option> 
					<option value="American Samoa">American Samoa</option> 
					<option value="Andorra">Andorra</option> 
					<option value="Angola">Angola</option> 
					<option value="Anguilla">Anguilla</option> 
					<option value="Antarctica">Antarctica</option> 
					<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
					<option value="Argentina">Argentina</option> 
					<option value="Armenia">Armenia</option> 
					<option value="Aruba">Aruba</option> 
					<option value="Australia">Australia</option> 
					<option value="Austria">Austria</option> 
					<option value="Azerbaijan">Azerbaijan</option> 
					<option value="Bahamas">Bahamas</option> 
					<option value="Bahrain">Bahrain</option> 
					<option value="Bangladesh">Bangladesh</option> 
					<option value="Barbados">Barbados</option> 
					<option value="Belarus">Belarus</option> 
					<option value="Belgium">Belgium</option> 
					<option value="Belize">Belize</option> 
					<option value="Benin">Benin</option> 
					<option value="Bermuda">Bermuda</option> 
					<option value="Bhutan">Bhutan</option> 
					<option value="Bolivia">Bolivia</option> 
					<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
					<option value="Botswana">Botswana</option> 
					<option value="Bouvet Island">Bouvet Island</option> 
					<option value="Brazil">Brazil</option> 
					<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
					<option value="Brunei Darussalam">Brunei Darussalam</option> 
					<option value="Bulgaria">Bulgaria</option> 
					<option value="Burkina Faso">Burkina Faso</option> 
					<option value="Burundi">Burundi</option> 
					<option value="Cambodia">Cambodia</option> 
					<option value="Cameroon">Cameroon</option> 
					<option value="Canada">Canada</option> 
					<option value="Cape Verde">Cape Verde</option> 
					<option value="Cayman Islands">Cayman Islands</option> 
					<option value="Central African Republic">Central African Republic</option> 
					<option value="Chad">Chad</option> 
					<option value="Chile">Chile</option> 
					<option value="China">China</option> 
					<option value="Christmas Island">Christmas Island</option> 
					<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
					<option value="Colombia">Colombia</option> 
					<option value="Comoros">Comoros</option> 
					<option value="Congo">Congo</option> 
					<option value="Congo">Congo</option> 
					<option value="Cook Islands">Cook Islands</option> 
					<option value="Costa Rica">Costa Rica</option> 
					<option value="Cote D'ivoire">Cote Divoire</option> 
					<option value="Croatia">Croatia</option> 
					<option value="Cuba">Cuba</option> 
					<option value="Cyprus">Cyprus</option> 
					<option value="Czech Republic">Czech Republic</option> 
					<option value="Denmark">Denmark</option> 
					<option value="Djibouti">Djibouti</option> 
					<option value="Dominica">Dominica</option> 
					<option value="Dominican Republic">Dominican Republic</option> 
					<option value="Ecuador">Ecuador</option> 
					<option value="Egypt">Egypt</option> 
					<option value="El Salvador">El Salvador</option> 
					<option value="Equatorial Guinea">Equatorial Guinea</option> 
					<option value="Eritrea">Eritrea</option> 
					<option value="Estonia">Estonia</option> 
					<option value="Ethiopia">Ethiopia</option> 
					<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
					<option value="Faroe Islands">Faroe Islands</option> 
					<option value="Fiji">Fiji</option> 
					<option value="Finland">Finland</option> 
					<option value="France">France</option> 
					<option value="French Guiana">French Guiana</option> 
					<option value="French Polynesia">French Polynesia</option> 
					<option value="French Southern Territories">French Southern Territories</option> 
					<option value="Gabon">Gabon</option> 
					<option value="Gambia">Gambia</option> 
					<option value="Georgia">Georgia</option> 
					<option value="Germany">Germany</option> 
					<option value="Ghana">Ghana</option> 
					<option value="Gibraltar">Gibraltar</option> 
					<option value="Greece">Greece</option> 
					<option value="Greenland">Greenland</option> 
					<option value="Grenada">Grenada</option> 
					<option value="Guadeloupe">Guadeloupe</option> 
					<option value="Guam">Guam</option> 
					<option value="Guatemala">Guatemala</option> 
					<option value="Guinea">Guinea</option> 
					<option value="Guinea-bissau">Guinea-bissau</option> 
					<option value="Guyana">Guyana</option> 
					<option value="Haiti">Haiti</option> 
					<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
					<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
					<option value="Honduras">Honduras</option> 
					<option value="Hong Kong">Hong Kong</option> 
					<option value="Hungary">Hungary</option> 
					<option value="Iceland">Iceland</option> 
					<option value="India">India</option> 
					<option value="Indonesia">Indonesia</option> 
					<option value="Iran">Iran</option> 
					<option value="Iraq">Iraq</option> 
					<option value="Ireland">Ireland</option> 
					<option value="Israel">Israel</option> 
					<option value="Italy">Italy</option> 
					<option value="Jamaica">Jamaica</option> 
					<option value="Japan">Japan</option> 
					<option value="Jordan">Jordan</option> 
					<option value="Kazakhstan">Kazakhstan</option> 
					<option value="Kenya">Kenya</option> 
					<option value="Kiribati">Kiribati</option> 
					<option value="Korea">Korea</option> 
					<option value="Kuwait">Kuwait</option> 
					<option value="Kyrgyzstan">Kyrgyzstan</option> 
					<option value="Lao">Lao</option> 
					<option value="Latvia">Latvia</option> 
					<option value="Lebanon">Lebanon</option> 
					<option value="Lesotho">Lesotho</option> 
					<option value="Liberia">Liberia</option> 
					<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
					<option value="Liechtenstein">Liechtenstein</option> 
					<option value="Lithuania">Lithuania</option> 
					<option value="Luxembourg">Luxembourg</option> 
					<option value="Macao">Macao</option> 
					<option value="Macedonia">Macedonia</option> 
					<option value="Madagascar">Madagascar</option> 
					<option value="Malawi">Malawi</option> 
					<option value="Malaysia">Malaysia</option> 
					<option value="Maldives">Maldives</option> 
					<option value="Mali">Mali</option> 
					<option value="Malta">Malta</option> 
					<option value="Marshall Islands">Marshall Islands</option> 
					<option value="Martinique">Martinique</option> 
					<option value="Mauritania">Mauritania</option> 
					<option value="Mauritius">Mauritius</option> 
					<option value="Mayotte">Mayotte</option> 
					<option value="Mexico">Mexico</option> 
					<option value="Micronesia">Micronesia</option> 
					<option value="Moldova">Moldova</option> 
					<option value="Monaco">Monaco</option> 
					<option value="Mongolia">Mongolia</option> 
					<option value="Montserrat">Montserrat</option> 
					<option value="Morocco">Morocco</option> 
					<option value="Mozambique">Mozambique</option> 
					<option value="Myanmar">Myanmar</option> 
					<option value="Namibia">Namibia</option> 
					<option value="Nauru">Nauru</option> 
					<option value="Nepal">Nepal</option> 
					<option value="Netherlands">Netherlands</option> 
					<option value="Netherlands Antilles">Netherlands Antilles</option> 
					<option value="New Caledonia">New Caledonia</option> 
					<option value="New Zealand">New Zealand</option> 
					<option value="Nicaragua">Nicaragua</option> 
					<option value="Niger">Niger</option> 
					<option value="Nigeria">Nigeria</option> 
					<option value="Niue">Niue</option> 
					<option value="Norfolk Island">Norfolk Island</option> 
					<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
					<option value="Norway">Norway</option> 
					<option value="Oman">Oman</option> 
					<option value="Pakistan">Pakistan</option> 
					<option value="Palau">Palau</option> 
					<option value="Palestinian">Palestinian</option> 
					<option value="Panama">Panama</option> 
					<option value="Papua New Guinea">Papua New Guinea</option> 
					<option value="Paraguay">Paraguay</option> 
					<option value="Peru">Peru</option> 
					<option value="Philippines">Philippines</option> 
					<option value="Pitcairn">Pitcairn</option> 
					<option value="Poland">Poland</option> 
					<option value="Portugal">Portugal</option> 
					<option value="Puerto Rico">Puerto Rico</option> 
					<option value="Qatar">Qatar</option> 
					<option value="Reunion">Reunion</option> 
					<option value="Romania">Romania</option> 
					<option value="Russian Federation">Russian Federation</option> 
					<option value="Rwanda">Rwanda</option> 
					<option value="Saint Helena">Saint Helena</option> 
					<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
					<option value="Saint Lucia">Saint Lucia</option> 
					<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
					<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
					<option value="Samoa">Samoa</option> 
					<option value="San Marino">San Marino</option> 
					<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
					<option value="Saudi Arabia">Saudi Arabia</option> 
					<option value="Senegal">Senegal</option> 
					<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
					<option value="Seychelles">Seychelles</option> 
					<option value="Sierra Leone">Sierra Leone</option> 
					<option value="Singapore">Singapore</option> 
					<option value="Slovakia">Slovakia</option> 
					<option value="Slovenia">Slovenia</option> 
					<option value="Solomon Islands">Solomon Islands</option> 
					<option value="Somalia">Somalia</option> 
					<option value="South Africa">South Africa</option> 
					<option value="South Georgia">South Georgia</option> 
					<option value="Spain">Spain</option> 
					<option value="Sri Lanka">Sri Lanka</option> 
					<option value="Sudan">Sudan</option> 
					<option value="Suriname">Suriname</option> 
					<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
					<option value="Swaziland">Swaziland</option> 
					<option value="Sweden">Sweden</option> 
					<option value="Switzerland">Switzerland</option> 
					<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
					<option value="Taiwan">Taiwan</option> 
					<option value="Tajikistan">Tajikistan</option> 
					<option value="Tanzania">Tanzania</option> 
					<option value="Thailand">Thailand</option> 
					<option value="Timor-leste">Timor-leste</option> 
					<option value="Togo">Togo</option> 
					<option value="Tokelau">Tokelau</option> 
					<option value="Tonga">Tonga</option> 
					<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
					<option value="Tunisia">Tunisia</option> 
					<option value="Turkey">Turkey</option> 
					<option value="Turkmenistan">Turkmenistan</option> 
					<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
					<option value="Tuvalu">Tuvalu</option> 
					<option value="Uganda">Uganda</option> 
					<option value="Ukraine">Ukraine</option> 
					<option value="United Arab Emirates">United Arab Emirates</option> 
					<option value="United Kingdom">United Kingdom</option> 
					<option value="United States">United States</option> 
					<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
					<option value="Uruguay">Uruguay</option> 
					<option value="Uzbekistan">Uzbekistan</option> 
					<option value="Vanuatu">Vanuatu</option> 
					<option value="Venezuela">Venezuela</option> 
					<option value="Viet Nam">Viet Nam</option> 
					<option value="Virgin Islands, British">Virgin Islands, British</option> 
					<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
					<option value="Wallis and Futuna">Wallis and Futuna</option> 
					<option value="Western Sahara">Western Sahara</option> 
					<option value="Yemen">Yemen</option> 
					<option value="Zambia">Zambia</option> 
					<option value="Zimbabwe">Zimbabwe</option>
                	</select>
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					Province:
				</span>
				<input class="form-control" type="text" name="province">
			</div>
			
			<div class="input-group">
				<span class="input-group-addon">
					District:
				</span>
				<input class="form-control" type="text" name="district">
			</div>
			
			<input type="submit" value="Save" class="btn btn-primary">
			
		</form>
	<?php } ?>

<?php require_once("footer.php"); ?>>