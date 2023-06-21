<?php
	require_once("connection.php");

	if(isset($_SESSION["user_id"])) {
		header("location:home.php");
	}
	
	
	if(isset($_POST["username"])) {
		$user = mysqli_real_escape_string($con, $_POST["username"]);
		$pass = mysqli_real_escape_string($con, $_POST["password"]);
		
		if(filter_var($user, FILTER_VALIDATE_EMAIL)) {
			$email = $user;
			$phone = "";
		}
		else {
			$phone = $user;
			$email = "";
		}
		
		$login = mysqli_query($con, "SELECT * FROM users WHERE (email='$email' OR phone='$phone') AND password=PASSWORD('$pass')");
		if(mysqli_num_rows($login) == 1) {
			
			$row_login = mysqli_fetch_assoc($login);
			
			$_SESSION["user_id"] = $row_login["user_id"];
			header("location:home.php");
		}
		else {
			header("location:index.php?login=failed");
		}
		
		
	}
	
	
	if(isset($_POST["firstname"])) {
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$gender = $_POST["gender"];
		$emailorphone = $_POST["emailorphone"];
		$password = $_POST["password"];
		$dob = $_POST["dob_year"] . "-" . $_POST["dob_month"] . "-" . $_POST["dob_day"];
		
		// check phone number or email address
		
		if(filter_var($emailorphone, FILTER_VALIDATE_EMAIL)) {
			$email = "'" . $emailorphone . "'";
			$phone = "NULL";
		}
		else {
			$phone = "'" . $emailorphone . "'";
			$email = "NULL";
		}

		$result = mysqli_query($con, "INSERT INTO users VALUES (NULL, '$firstname', '$lastname', $gender, '$dob', $email, $phone, PASSWORD('$password'))"); 
	
		if($result) {
		
			$last_user = mysqli_query($con, "SELECT user_id FROM users ORDER BY user_id DESC LIMIT 1");
			$row_last_user = mysqli_fetch_assoc($last_user);
			
			$_SESSION["user_id"] = $row_last_user["user_id"];
			
			header("location:home.php"); // redirect
		}
		else {
			header("location:index.php?registration=failed");
		}
	
	}		
	

?>
<html>
<head>

	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
		
</head>

<body >


	<div class="container">
	
		<div id="main">
			<div id="banner">
			
				<div id="logo" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" >
					<h3> Welcome to our website!</h3>
				</div>
				
				
				
			</div>
		
			<div id="login" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left" style="padding-top:30px; padding-right: 50px;">
						
					<h3> Log in here</h3>
					<br>
					
					<form method="post">
						<input placeholder="Your Email or Phone" type="text" name="username" class="form-control">
						<input placeholder="Enter Your Password" type="password" name="password" class="form-control " style="margin-top: 8px;" ><br>
						<input class="btn btn-primary btn-sm pull-right" type="submit" value="Login">
					</form>
					
					<?php if(isset($_GET["login"])) { ?>
						<span class="text-danger">
							Incorrect Username or Password!
						</span>
					<?php } ?>
					<img src="images/2.png" height="250px" width="400px" >
				</div>
			<div id="signup" style="min-height:400px; padding-top:30px;" class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				
				<h3>Create New Account</h3>
				

				<br>
				
				
					<?php if(isset($_GET["registration"])) { ?>
						<div class="alert alert-danger">
							<button class="close" area-hidden="true" data-dismiss="alert">&times;</button>
							Error! Registration Failed!
						</div>
					<?php } ?>
					
				
				<form method="post">
					
					<div class="input-group">
						<span class="input-group-addon">
							Firstname:
						</span>
						<input class="form-control" type="text" name="firstname">
					</div>
					
					
					<div class="input-group">
						<span class="input-group-addon">
							Lastname:
						</span>
						<input class="form-control" type="text" name="lastname">
					</div>
					
					<div class="input-group">
						<span class="input-group-addon">
							Gender:
						</span>
						&nbsp; 
						<label><input checked type="radio" name="gender" value="0"> Male</label>  &nbsp;
						<label><input type="radio" name="gender" value="1"> Female</label>
					</div>
					
					<div class="input-group">
						<span class="input-group-addon">
							Birth Date:
						</span>
						<select name="dob_day" class="form-control" style="width:20%">
							<?php for($x=1; $x<=31; $x++) { ?>
								<option><?php echo $x; ?></option>
							<?php } ?>
						</select>
						
						<select name="dob_month" class="form-control" style="width:50%">
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">November</option>
							<option value="11">October</option>
							<option value="12">December</option>
						</select>
						
						<select name="dob_year" class="form-control" style="width:30%">
							<?php
								$max = date("Y") - 13;
								$min = date("Y") - 100;
								
								for($x=$max; $x>=$min; $x--) { ?>
									<option><?php echo $x; ?></option>
								<?php } ?>
						</select>
					</div>
					
					<div class="input-group">
						<span class="input-group-addon">
							Email/Phone:
						</span>
						<input class="form-control" type="text" name="emailorphone">
					</div>
					
					<div class="input-group">
						<span class="input-group-addon">
							Password:
						</span>
						<input class="form-control" type="password" name="password">
					</div>
					
					<input class="btn btn-primary pull-right" type="submit" value="Register">
					
				</form>
				
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