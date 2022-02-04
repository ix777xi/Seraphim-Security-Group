<?php
	include('conn.php');
	
	$login_data = ($_SESSION['login_data']);
	$login_name = $login_data["first_name"]." ".$login_data["last_name"];
	$link = $login_data["unique_link"];
	
	if(isset($_POST["login_submit"])){
		$login_mobile = $_POST["login_mobile"];
		$login_pwd = $_POST["login_pwd"];
		$login_query = "select * from user_tbl where mobile_no='" . $login_mobile ."' and password='". $login_pwd  ."' and user_type='user'";
		$rs_query = mysqli_query($conn, $login_query);
		$rs_num_show = mysqli_num_rows($rs_query);
		$login_result = mysqli_fetch_assoc($rs_query);
		if($rs_num_show>0){
			$_SESSION['login_data'] = ($login_result);
			echo "<script>alert('Login successfully.')</script>";
			header("location:dashboard.php");
		}else{
			echo "<script>alert('Invalid credential!')</script>";
		}
	}else{
		if(isset($_POST["signup_submit"])){
			
			$first_name = $_POST["first_name"];
			$last_name = $_POST["last_name"];
			$mobile = $_POST["mobile"];
			$pwd = $_POST["pwd"];
			$confirm_pwd = $_POST["confirm_pwd"];
			$today_date = date('Y-m-d H:i:s');
			$n=10;
			function getName($n) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$randomString = '';
			  
				for ($i = 0; $i < $n; $i++) {
					$index = rand(0, strlen($characters) - 1);
					$randomString .= $characters[$index];
				}
			  
				return $randomString;
			}
			  
			$unique_link = getName($n);
			
			if(!empty($mobile)) 
			{
				if(preg_match('/^\d{10}$/',$mobile)) 
				{
					$check_ph = mysqli_query($conn, "SELECT mobile_no FROM user_tbl where mobile_no = '".$mobile."'");
					if(mysqli_num_rows($check_ph) > 0){
						echo "<script>alert('Mobile Number Already exists')</script>";
					}
					else{
						
						if ($pwd === $confirm_pwd) {
						   
						   $register_query = "INSERT INTO `user_tbl`(`user_type`, `first_name`, `last_name`, `mobile_no`, `password`, `unique_link`,  `created_date`, `updated_date`) VALUES
														('user', '".$first_name."' ,'". $last_name."','". $mobile."','".$pwd."', '".$unique_link."','".$today_date."','". $today_date."')";

							if (mysqli_query($conn, $register_query)) {
							   echo "<script>alert('New record created successfull')</script>";
							} else {
							  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
							}
						}
						else {
						   echo "<script>alert('Invalid Password!')</script>";
						}
						mysqli_close($conn);
					}
				  
				}
				else
				{
				  echo "<script>alert('Phone Enter valid number')</script>";
				}
			}
			else 
			{
			  echo "<script>alert('You must provid a phone number !')</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Mercenary</title>
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
						<?php 
							if(isset($login_data)){
							?>	
								<div class="collapse navbar-collapse" id="navbar-list-2">
									<ul class="navbar-nav">
									    <li class="nav-item">
											<a class="nav-link" href="dashboard.php">Dashboard</a>
										</li>
										<li class="nav-item">
											<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $login_name; ?> <i class="fa fa-user"></i></a>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="change-password.php">Change Password</a>
												<a class="dropdown-item" href="logout.php">Logout</a>
											</div>
										</li>
									</ul>
								</div>
							<?php	
							}
						?>
						
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
					<div class="col-lg-4">
						<div class="features">
							<div class="card">
								<div class="card-body">
									<h4>Features</h4>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
									<ul>
										<li>Lorem ipsum dolor sit amet</li>
										<li>consectetur adipiscing elit</li>
										<li>sed do eiusmod tempor incididunt</li>
										<li>labore et dolore magna aliqua</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-8">
					
						<?php 
							if(isset($login_data)){
							?>	
								<img src="assets/img/banner.png"/>
							<?php	
							}
							else {
							?>	
							<div class="card">
								<div class="card-body p-0">
									<ul class="nav nav-tabs edit_tabs_wrap" role="tablist">
										<li><a href="#tab1" class="active" data-toggle="tab" role="tab">Login</a></li>
										<li><a href="#tab2" data-toggle="tab" role="tab">Sign Up</a></li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane fade show active" id="tab1">
											<div class="login_wrapper">
												<h4>Login</h4>
												<form method="post" action="">
													<div class="form-group">
														<input type="text" name="login_mobile" class="form-control" placeholder="Phone Number">
													</div>
													<div class="form-group">
														<input type="password" name="login_pwd" class="form-control" placeholder="Password">
													</div>
													<div class="form-group">
														<button type="submit" name="login_submit" class="btn btn-dark">Submit</button>
													</div>
													<div class="form-group">
														<a href="forget.php">forgot password?</a>
													</div>
												</form>
											</div>
										</div>
										<div class="tab-pane fade" id="tab2">
											<div class="login_wrapper">
												<h4>Sign Up</h4>
												<form method="post" action="">
													<div class="form-group">
														<input type="text" name="first_name" class="form-control" placeholder="First Name">
													</div>
													<div class="form-group">
														<input type="text" name="last_name" class="form-control" placeholder="Last Name">
													</div>
													<div class="form-group">
														<input type="text" name="mobile" class="form-control" placeholder="Phone Number">
													</div>
													<div class="form-group">
														<input type="password" name="pwd" class="form-control" placeholder="Password">
													</div>
													<div class="form-group">
														<input type="password" name="confirm_pwd" class="form-control" placeholder="Confirm Password">
													</div>
													<div class="form-group">
														<button type="submit" name="signup_submit" class="btn btn-dark">Submit</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php	
							}
						?>
					
						
					</div>
				</div>
			</div>
		</section>

		<section class="payment">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-8">
						<div class="payment_info">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
							<h3>$30.00</h3>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="payment_btn text-center">
							<button class="btn btn-lg btn-light" onclick="mustLogin()">Pay Now</button>
						</div>
					</div>
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

		<script>
			function mustLogin() {
			  alert("Must Be login First");
			}
		</script>
	  	
	</body>
</html>