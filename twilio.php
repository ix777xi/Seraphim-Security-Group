<?php

include './vendor/autoload.php';
if (isset($_POST['mobile']) && isset($_POST['msg'])) {
    // Your Account Sid and Auth Token get from twilio.com/user/account
    $sid = 'AC6ed4603bc8b996c21e134246c31210ff';
    $token = 'b59ad1eaec902b41e73e233d10788eb6';
    // A Twilio number you own with SMS capabilities (you need to buy from twilio.com while signup)
    $twilio_number = "+000000000";  // replace +000000000 to yours
    $client = new Twilio\Rest\Client($sid, $token);
    $message = $client->message->create(
            $_POST['mobile'], array(
        'from' => $twilio_number,
        'body' => $_POST['msg']
            )
    );
    if ($message->sid) {
        echo "Message sent!";
    }
}