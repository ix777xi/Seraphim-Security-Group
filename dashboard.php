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
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Mercenary</title>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.png" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
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
		<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
		

		<script type="text/javascript" src="assets/js/slick.js"></script>
		<script type="text/javascript" src="assets/js/custom.js"></script>
		
		<script src="https://js.stripe.com/v3/"></script>
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
		
		<section class="payment">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-8">
						<div class="payment_info">
							<h1>Share Your Link</h1>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="payment_btn text-center">
							<a class="copy_text"  data-toggle="tooltip" title="Copy to Clipboard"  class="btn btn-lg btn-light" href="<?php echo $url; ?>shareddata.php?data=<?php echo $link; ?>"><button >Copy Now</button></a>
						
							<script>
							
								$('.copy_text').click(function (e) {
								   e.preventDefault();
								   var copyText = $(this).attr('href');

								   document.addEventListener('copy', function(e) {
									  e.clipboardData.setData('text/plain', copyText);
									  e.preventDefault();
								   }, true);

								   document.execCommand('copy');  
								   console.log('copied text : ', copyText);
								   alert('Text copied Successfully.'); 
								 });
							</script>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="datalist">
			<div class="container">
				<h4>You Shared Data List</h4>
				<table id="example" class="table table-striped table-bordered" style="width:100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Machine Info</th>
							<th>Scan Date</th>
							<th>Lat</th>
							<th>Long</th>
							<th>Remote Ip</th>
							<th>Local Machine Ip</th>
							<th>Browser Name</th>
						</tr>
					</thead>
					<tbody>
						
						<?php 
							$user_id = $login_data["user_id"];
							$sql = "SELECT * FROM user_shared_data_tbl WHERE user_id = '".$user_id."'";
							$result = mysqli_query($conn, $sql);
							$i = 1;	
							if (mysqli_num_rows($result) > 0) {
							  // output data of each row
							  while($row = mysqli_fetch_assoc($result)) {
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $row["machine_info"] ?></td>
									<td><?php echo $row["scan_datetime"] ?></td>
									<td><?php echo $row["lat"] ?></td>
									<td><?php echo $row["long"] ?></td>
									<td><?php echo $row["remote_ip"] ?></td>
									<td><?php echo $row["local_machine_ip"] ?></td>
									<td><?php echo $row["browser_name"] ?></td>
								</tr>	
								<?php
							  }
							} else {
							  echo "0 results";
							}
						?>	
					</tbody>
					<tfoot>
						<tr>
							<th>ID</th>
							<th>Machine Info</th>
							<th>Scan Date</th>
							<th>Lat</th>
							<th>Long</th>
							<th>Remote Ip</th>
							<th>Local Machine Ip</th>
							<th>Browser Name</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</section>
		
		<!--Payment Section Start  -->
		<section class="payment">
			<div class="container">	
				<div class="row">
					<div class="col-sm-12 col-md-3 py-4">
						<div class="payment_btn text-center">
							<!-- Display errors returned by checkout session -->
							<div id="paymentResponse"></div>
						
							<div class="col__box">
								<!-- Buy button -->
								<div id="buynow">
									<button class="btn__default" id="payButton">Pay Now</button>
								</div>
							</div>
						</div>
					</div>	
					<div class="col-sm-12 col-md-9 py-4">
						<h4>You Payments List</h4>
						<table id="payment" class="table table-striped table-bordered" style="width:100%">
							<thead>
								<tr>
									<th>ID</th>
									<th>Payment Date</th>
									<th>Transaction Id</th>
									<th>Payment Status</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$user_id = $login_data["user_id"];
									$sql = "SELECT * FROM payment_tbl WHERE user_id = '".$user_id."'";
									$result = mysqli_query($conn, $sql);
									$i = 1;
									if (mysqli_num_rows($result) > 0) {
									  // output data of each row
									  while($row = mysqli_fetch_assoc($result)) {
										?>
										<tr>
											<td><?php echo $i++; ?></td>
											<td><?php echo $row["payment_date"] ?></td>
											<td><?php echo $row["transaction_id"] ?></td>
											<td><?php echo $row["payment_status"] ?></td>
										</tr>	
										<?php
									  }
									} else {
									  echo "0 results";
									}
								?>	
							</tbody>
							<tfoot>
								<tr>
									<th>ID</th>
									<th>Payment Date</th>
									<th>Transaction Id</th>
									<th>Payment Status</th>
								</tr>
							</tfoot>
						</table>
					</div>					
				</div>
			</div>
		</section>
		<!--Payment Section End  -->
		
		<footer class="footer">
			<div class="container">
				<!-- <hr> -->
				<div class="copyright_txt text-center">
					<p>Copyright © 2022. All Rights Reserved.</p>
				</div>
			</div>
		</footer>
		<script>
			$(document).ready(function() {
				$('#example').DataTable();
			});
			$(document).ready(function() {
				$('#payment').DataTable();
			});
			var buyBtn = document.getElementById('payButton');
			var responseContainer = document.getElementById('paymentResponse');    
			// Create a Checkout Session with the selected product
			var createCheckoutSession = function (stripe) {
				return fetch("stripe_charge.php", {
					method: "POST",
					headers: {
						"Content-Type": "application/json",
					},
					body: JSON.stringify({
						checkoutSession: 1,
						Name:"<?php echo $product_name; ?>",
						ID:"<?php echo $user_id; ?>",
						Price:"<?php echo $product_price; ?>",
						Currency: "USD",
					}),
				}).then(function (result) {
					return result.json();
				});
			};

			// Handle any errors returned from Checkout
			var handleResult = function (result) {
				if (result.error) {
					responseContainer.innerHTML = '<p>'+result.error.message+'</p>';
				}
				buyBtn.disabled = false;
				buyBtn.textContent = 'Buy Now';
			};

			// Specify Stripe publishable key to initialize Stripe.js
			var stripe = Stripe('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

			buyBtn.addEventListener("click", function (evt) {
				buyBtn.disabled = true;
				buyBtn.textContent = 'Please wait...';
				createCheckoutSession().then(function (data) {
					if(data.sessionId){
						stripe.redirectToCheckout({
							sessionId: data.sessionId,
						}).then(handleResult);
					}else{
						handleResult(data);
					}
				});
			});
			
			
			
		</script>

	  	
	</body>
</html>