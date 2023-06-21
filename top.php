<?php
	require_once("connection.php");
	
	$profile = mysqli_query($con, "SELECT firstname, lastname, picture FROM users INNER JOIN profile ON users.user_id = profile.user_id WHERE users.user_id = " . $_SESSION["user_id"]); 
	$row_profile = mysqli_fetch_assoc($profile);
	
	
	$friend = mysqli_query($con, "SELECT * FROM friend WHERE receiver_id = " . $_SESSION["user_id"] . " AND status = 0 AND seen = 0");
	$row_friend = mysqli_fetch_assoc($friend);
	$totalRows_friend = mysqli_num_rows($friend);
	
	$group = mysqli_query($con, "SELECT * FROM groups INNER JOIN group_admin ON groups.group_id = group_admin.group_id WHERE user_id = " . $_SESSION["user_id"]); 
	$row_group = mysqli_fetch_assoc($group);	
	
	
?>
<html>
<head>

	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/script1.js"></script>
	
</head>

<body>

	<div class="container">
	
		<div id="main" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div id="banner" STYLE="min-height:100px;">
			
				<div id="logo" class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
					<img src="images/logo2.png" style="height:11%; width:110%; padding-top:4px; left:-10px;">
				</div>
				<div id="notif" class="col-lg-5 col-md-5 col-sm-4 col-xs-12 " style="padding-top:20px; height:10%;">
					
				<h2 Style="color:white; float:left;"> Ask For Answer ! </h2> 
					
					
					
				</div>
				
				
				<div id="search" class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
					<form method="get" action="search.php">
						<div class="input-group">
							<span class="input-group-addon" style="width:60px;">
								Search: 
							</span>
							<input name="q" placeholder="Search here ..." type="text" class="form-control">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-info" style="padding-top:9px;padding-bottom:9px;">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</div>
					</form>
						<div id="today"  style="color:white; float:right; margin-right:20px;">
				Today:
				<?php echo date("l, d, F ,Y"); ?><br>
				
				</div>
				</div>
				
			
				
				
			</div>
			
			<div id="menu">
			
		<nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="collapse">
            	
			
				
				<ul class="nav navbar-nav" id="nav-top">
				
                	<li><a href="home.php" >Home <span class="glyphicon glyphicon-home"></span></a></li>
					
                	
					
					<li>
					<a href="friend_request.php">Friend Requests
					<span class="glyphicon glyphicon-user" ></span>
					<?php if($totalRows_friend > 0) { ?>
					<span class="badge btn-danger" style="position:relative; top:-10px; left:-10px; font-size:10px;">
						<?php echo $totalRows_friend; ?>
					</span>
					<?php } ?>
					</a></li>
					
					
                	<li class="dropdown"><a href="#" data-toggle="dropdown">Questions <span class="caret"></span></a>
                    	<ul class="dropdown-menu">
                        	 <li><a href="question_list.php">Your question List  </a></li>
                        	<li><a href="employee_add.php">Edit question</a></li>
                          
                        </ul>                    
                    </li>
				
					
					<li>
					<a href="logout.php">
					logout
						<span class="glyphicon glyphicon-log-out"  ></span>
					</a></li>
					
                </ul>
				
				
				
			</span>
            </div>  
        </nav>
		</div>
		
		
		<?php
		$users = mysqli_query($con, "Select * from users  INNER JOIN Profile ON profile.user_id = users.user_id  ");
		$row_users = mysqli_fetch_assoc($users);
		?>
		
		
		<div id="profile" class="col-lg-2 col-md-3 col-sm-3 hidden-xs" style="min-height:700px;">
			<h2> Users</h2>
		
			<?php do { ?>
			
				<div style="margin-bottom:10px;">
					<img src="<?php echo $row_users["picture"]; ?>" width="40" style="width:40px; height:40px; margin-right:5px;" class="img-circle">
					<?php echo $row_users["firstname"]; ?>
					<?php echo $row_users["lastname"]; ?>
				</div>
			
			<?php } while($row_users = mysqli_fetch_assoc($users)); ?>
			
			<div class="clearfix"></div>
	
		</div>
		
		<div id="timeline" class="col-lg-8 col-md-8 col-sm-7 col-xs-12">