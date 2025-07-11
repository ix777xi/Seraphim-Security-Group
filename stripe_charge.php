<?php
// Include configuration file  
require_once 'conn.php';
// Include Stripe PHP library 
require_once 'stripe-php/init.php';
// Set API key
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);
$response = array(
    'status' => 0,
    'error' => array(
        'message' => 'Invalid Request!'   
    )
);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$input = file_get_contents('php://input');
	$request = json_decode($input);	
}
if (json_last_error() !== JSON_ERROR_NONE) {
	http_response_code(400);
	echo json_encode($response);
	exit;
}
$productName = $request->Name; 
$userID = $request->ID;
$productPrice = $request->Price; 
$currency = $request->Currency;
 
// Convert product price to cent 
$stripeAmount = round($productPrice*100, 2); 

if(!empty($request->checkoutSession)){
    // Create new Checkout Session for the order
    try {
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'product_data' => [
                        'name' => $productName,
                        'metadata' => [
                            'pro_id' => $userID
                        ]
                    ],
                    'unit_amount' => $stripeAmount,
                    'currency' => $currency,
                ],
                'quantity' => 1,
                'description' => $productName,
            ]],
            'mode' => 'payment',
            'success_url' => STRIPE_SUCCESS_URL.'?session_id={CHECKOUT_SESSION_ID}&getID='.$userID,
            'cancel_url' => STRIPE_CANCEL_URL,
        ]);
    }catch(Exception $e) { 
        $api_error = $e->getMessage(); 
    }
    
    if(empty($api_error) && $session){
        $response = array(
            'status' => 1,
            'message' => 'Checkout Session created successfully!',
            'sessionId' => $session['id']
        );
    }else{
        $response = array(
            'status' => 0,
            'error' => array(
                'message' => 'Checkout Session creation failed! '.$api_error   
            )
        );
    }
}

// Return response
echo json_encode($response);