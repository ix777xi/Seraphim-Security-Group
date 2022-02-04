<?php
date_default_timezone_set('Asia/Kolkata');
//error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();

if (!function_exists('base_url')) {

        function base_url($atRoot = false, $atCore = false, $parse = false) {
            if (isset($_SERVER['HTTP_HOST'])) {
                $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
                $hostname = $_SERVER['HTTP_HOST'];
                $dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

                $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), null, PREG_SPLIT_NO_EMPTY);
                $core = $core[0];

                $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
                $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);

                $base_url = sprintf($tmplt, $http, $hostname, $end);
            } else {
                $base_url = 'http://localhost/';
            }

            if ($parse) {
                $base_url = parse_url($base_url);
                if (isset($base_url['path'])) {
                    if ($base_url['path'] == '/') {
                        $base_url['path'] = '';
                    }
                }
            }

            return $base_url;
        }
    
    }
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $url = "https";
    } else {
        $url = "http";
    }
    $url .= "://";
    $url .= $_SERVER['HTTP_HOST'] . "/";
    $url = base_url();

function errorCode($httpCode) {
    $http_codes = parse_ini_file("code.ini");
    $message = $http_codes[$httpCode];
    return $message;
}

$product_name = "mercenary";
$product_price = 30;

define('STRIPE_API_KEY', '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');  
define('STRIPE_PUBLISHABLE_KEY', 'pk_live_51KIJcGBGfTZXz1kcPqoAec8LaB5AVe9z0vQBN0txW4PA984DZSOsyBsvseKfX3zDrkNdFbmpDC6O1Fp2RyrRdTTl00YWteVi2a'); 

define('STRIPE_SUCCESS_URL', $url.'success.php'); 
define('STRIPE_CANCEL_URL', $url.'cancel.php'); 


$account_sid = 'AC6ed4603bc8b996c21e134246c31210ff';
$auth_token = 'b59ad1eaec902b41e73e233d10788eb6';


define('DB_HOST', 'localhost');
define('DB_USERNAME', 'mercenary');
define('DB_PASSWORD', 'mercenary@123');
define('DB_NAME', 'mercenary');
define('DB_PORT', '3308');

$conn = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// $data = mysqli_fetch_assoc(mysqli_query($conn, "select * from user_tbl"));
// echo json_encode($data);
// print_r($data);



?>