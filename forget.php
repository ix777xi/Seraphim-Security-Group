<?php
	include('conn.php');
	
	require __DIR__ . '/vendor/autoload.php';
	use Twilio\Rest\Client;
		
	$login_data = ($_SESSION['login_data']);
	$login_name = $login_data["first_name"]." ".$login_data["last_name"];
	$link = $login_data["unique_link"];
	$user_id = $login_data["user_id"];
	
		 
	
		if(isset($_POST['Submit']))
		{
			$mb_no=$_POST['mb_no'];
			$pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 8);
			$phno = '+1'.$mb_no;
			$sql=mysqli_query($conn,"SELECT * FROM user_tbl where mobile_no='".$mb_no."'");
			$num=mysqli_fetch_array($sql);
			if($num>0)
			{
				$con=mysqli_query($conn,"update user_tbl set password='".$pass."' where mobile_no='".$mb_no."'");
				
				$twilio_number = "+1 (626) 593-8625";

				$client = new Client($account_sid, $auth_token);
				$message = $client->messages->create(
					// Where to send a text message (your cell phone?)
					$phno,
					array(
						'from' => $twilio_number,
						'body' => 'your Login password : '.$pass
								  
						
					)
				);

				if($message){
					$_SESSION['msg']="Password sent Successfully !!";
				}
				else {
					echo 'message not send';
					$_SESSION['msg']="Password not sent Successfully !!";
				}
				
			}
			else
			{
				$_SESSION['msg']="Mobile not match !!";
			}
		}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Forget Password - Mercenary</title>
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
						    <!-- <ul class="navbar-nav">
						      	<li class="nav-item active">
						        	<a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="SolarSolutions.html">Solar Solutions</a>
						        	<div class="dropdown-menu">
										<a class="dropdown-item" href="SolarSolutions.html">Residential Solar Rooftop</a>
										<a class="dropdown-item" href="commSolarSolution.html">Commercial Solar Rooftop</a>
										<a class="dropdown-item" href="IndSolarSolution.html">Industrial Solar Rooftop</a>
									</div>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="SecurityAutomation.html">Security & Automation</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="Gallery.html">Gallery</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="Blog.html">Blog</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="Faq.html">FAQ</a>
						      	</li>
						      	<li class="nav-item">
						        	<a class="nav-link" href="#">Download</a>
						      	</li>
						    </ul> -->
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
									<h4>Forget Password</h4>
									<p style="color:red;"><?php echo $_SESSION['msg'];?><?php echo $_SESSION['msg']="";?></p>
									<form method="post" action="">
										<div class="form-group">
											<input type="text" name="mb_no" class="form-control" placeholder="Enter Mobile Number..">
										</div>
										<div class="form-group">
											<button type="submit" name="Submit" class="btn btn-dark">Submit</button>
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
	</body>
</html>