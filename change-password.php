<?php
	include('conn.php');
	
	$login_data = ($_SESSION['login_data']);
	$login_name = $login_data["first_name"]." ".$login_data["last_name"];
	$link = $login_data["unique_link"];
	$user_id = $login_data["user_id"];
	
	if(!isset($login_data)){
		header('location:index.php');
		exit();
	}
	
	
		if(isset($_POST['Submit']))
		{
			$oldpass=$_POST['opwd'];
			$useremail=$_SESSION['login'];
			$newpassword=$_POST['npwd'];
			
			$sql=mysqli_query($conn,"SELECT * FROM user_tbl where password='".$oldpass."' && user_id='".$user_id."'");
			$num=mysqli_fetch_array($sql);
			if($num>0)
			{
				$con=mysqli_query($conn,"update user_tbl set password='".$newpassword."' where user_id='".$user_id."'");
				$_SESSION['msg']="Password Changed Successfully !!";
			}
			else
			{
				$_SESSION['msg']="Old Password not match !!";
			}
		}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Change Password - Mercenary</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="assets/css/slick.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/style.css" />
		<link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/slick.js"></script>
		<script type="text/javascript" src="assets/js/custom.js"></script>
	</head>
	<body>
		<header class="header" id="top">
			<div class="main_menu">
				<div class="container">
					<nav class="navbar navbar-expand-lg">
						<a class="navbar-brand" href="index.php">
							<img src="assets/img/logo.png" />
						</a>
						<div class="collapse navbar-collapse" id="navbar-list-2">
						    <ul class="navbar-nav">
						      	<li class="nav-item">
						        	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="SolarSolutions.html"><?php echo $login_name; ?> <i class="fa fa-user"></i></a>
						        	<div class="dropdown-menu">
										<a class="dropdown-item" href="change-password.php">Change Password</a>
										<a class="dropdown-item" href="logout.php">Logout</a>
									</div>
						      	</li>
						    </ul>
					  	</div>
					  	<!-- <div class="main_right_menu">
					  		<ul>
					  			<li>
					  				<a href="contact.html" class="header-btn">Get Free Quote</a>
					  			</li>
					  		</ul>
					  	</div> -->
				  	</nav>
				</div>
			</div>
		</header>
		<section class="tabs_wrapper">
			<div class="container">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<div class="card">
							<div class="card-body p-5">
								<div class="login_wrapper">
									<h4>Change Password</h4>
									<p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
									<form method="post" action="">
										<div class="form-group">
											<input type="password" name="opwd" id="opwd" class="form-control" placeholder="Enter Old Password">
										</div>
										<div class="form-group">
											<input type="password" name="npwd" id="npwd" class="form-control" placeholder="Enter New Password">
										</div>
										<div class="form-group">
											<input type="password" name="cpwd" id="cpwd" class="form-control" placeholder="Enter Re Password">
										</div>
										<div class="form-group">
											<button type="submit" name="Submit" class="btn btn-dark">Change Passowrd</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4"></div>
				</div>
			</div>
		</section>
		
		<footer class="footer">
			<div class="container">
				<!-- <hr> -->
				<div class="row">
					<div class="col-lg-6">
						<div class="copyright_txt text-left">
							<p>Copyright © 2022. All Rights Reserved.</p>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="contact-details text-right">
							<ul>
								<li>(+91) 9724305392</li>
								<li>example@abc.com</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<script type="text/javascript">
			function valid()
			{
			if(document.chngpwd.opwd.value=="")
			{
			alert("Old Password Filed is Empty !!");
			document.chngpwd.opwd.focus();
			return false;
			}
			else if(document.chngpwd.npwd.value=="")
			{
			alert("New Password Filed is Empty !!");
			document.chngpwd.npwd.focus();
			return false;
			}
			else if(document.chngpwd.cpwd.value=="")
			{
			alert("Confirm Password Filed is Empty !!");
			document.chngpwd.cpwd.focus();
			return false;
			}
			else if(document.chngpwd.npwd.value!= document.chngpwd.cpwd.value)
			{
			alert("Password and Confirm Password Field do not match  !!");
			document.chngpwd.cpwd.focus();
			return false;
			}
			return true;
			}
		</script>
	</body>
</html>