<?php
// Include configuration file 
require_once 'conn.php';

    $pageview = $_GET['getID']; 
	$selectproduct =mysqli_query($conn, "select * from user_tbl where user_id = '$pageview' ");
    $rowproduct =mysqli_fetch_array($selectproduct,MYSQLI_ASSOC); 			
			
    $payment_id = $statusMsg = '';
    $ordStatus = 'error';

// Check whether stripe checkout session is not empty
if(!empty($_GET['session_id'])){
    $session_id = $_GET['session_id'];
    
    // Fetch transaction data from the database if already exists
    $sql = "SELECT * FROM payment_tbl WHERE checkout_session_id = '".$session_id."'";
    $result = $conn->query($sql);
	if ( !empty($result->num_rows) && $result->num_rows > 0) {
        $paymentData = $result->fetch_assoc();
        
        $userID = $paymentData['user_id'];
        $transactionID = $paymentData['transaction_id'];
        $paidAmount = $paymentData['paid_amount'];
        $paymentStatus = $paymentData['payment_status'];
        
        $ordStatus = 'success';
        $statusMsg = 'Your Payment has been Successful!';
    }else{
        // Include Stripe PHP library 
        require_once 'stripe-php/init.php';
        
        // Set API key
        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
        
        // Fetch the Checkout Session to display the JSON result on the success page
        try {
            $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
        }catch(Exception $e) { 
            $api_error = $e->getMessage(); 
        }
        
        if(empty($api_error) && $checkout_session){
            // Retrieve the details of a PaymentIntent
            try {
                $intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
            } catch (\Stripe\Exception\ApiErrorException $e) {
                $api_error = $e->getMessage();
            }
            
         
            
            if(empty($api_error) && $intent){ 
                // Check whether the charge is successful
                if($intent->status == 'succeeded'){
              
                    // Transaction details 
                    $transactionID = $intent->id;
                    $paidAmount = $intent->amount;
                    $paidAmount = ($paidAmount/100);
                    $paidCurrency = $intent->currency;
                    $paymentStatus = 'successful';
					$today_date = date('Y-m-d H:i:s');
					 // Insert transaction data into the database 
                    
					$sql = "INSERT INTO `payment_tbl`(`user_id`, `payment_date`, `transaction_id`, `payment_status`, `paid_amount`, `checkout_session_id`) VALUES 
													 ('".$pageview."','".$today_date."','".$transactionID."','".$paymentStatus."','".$paidAmount."','".$session_id."')"; 
					
                    $insert = $conn->query($sql);
                    $userID = $conn->insert_id;
					
					
                    
						$ordStatus = 'success';
						$statusMsg = 'Your Payment has been Successful!';
                   
                }else{
                    $statusMsg = "Transaction has been failed!";
                }
            }else{
                $statusMsg = "Unable to fetch the transaction details! $api_error"; 
            }
            
            $ordStatus = 'success';
        }else{
            $statusMsg = "Transaction has been failed! $api_error"; 
        }
    }
}else{
	$statusMsg = "Invalid Request!";
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Stripe Payment Status - Mercenary</title>
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
		<section class="sharedData">
			<div class="fulldiv">
				<h2 class="<?php echo $ordStatus; ?>"><?php echo $statusMsg; ?></h2>
			</div>
		</section>
		
		<script>
			window.setTimeout(function(){
				 window.location.href = "<?php echo $url; ?>dashboard.php";
			}, 3000);

		</script>
		
	</body>
</html>
