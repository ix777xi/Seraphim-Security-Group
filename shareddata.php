<?php
		include('conn.php');
		
		require __DIR__ . '/vendor/autoload.php';
		use Twilio\Rest\Client;
		
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		function getOS() { 
			global $user_agent;
			$os_platform    =   "Unknown OS Platform";
			$os_array       =   array(
									'/windows nt 10/i'     =>  'Windows 10',
									'/windows nt 6.3/i'     =>  'Windows 8.1',
									'/windows nt 6.2/i'     =>  'Windows 8',
									'/windows nt 6.1/i'     =>  'Windows 7',
									'/windows nt 6.0/i'     =>  'Windows Vista',
									'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
									'/windows nt 5.1/i'     =>  'Windows XP',
									'/windows xp/i'         =>  'Windows XP',
									'/windows nt 5.0/i'     =>  'Windows 2000',
									'/windows me/i'         =>  'Windows ME',
									'/win98/i'              =>  'Windows 98',
									'/win95/i'              =>  'Windows 95',
									'/win16/i'              =>  'Windows 3.11',
									'/macintosh|mac os x/i' =>  'Mac OS X',
									'/mac_powerpc/i'        =>  'Mac OS 9',
									'/linux/i'              =>  'Linux',
									'/ubuntu/i'             =>  'Ubuntu',
									'/iphone/i'             =>  'iPhone',
									'/ipod/i'               =>  'iPod',
									'/ipad/i'               =>  'iPad',
									'/android/i'            =>  'Android',
									'/blackberry/i'         =>  'BlackBerry',
									'/webos/i'              =>  'Mobile'
								);

			foreach ($os_array as $regex => $value) { 

				if (preg_match($regex, $user_agent)) {
					$os_platform    =   $value;
				}

			}   

			return $os_platform;

		} 
		
		
		$login_data = ($_SESSION['login_data']);
		$login_name = $login_data["first_name"]." ".$login_data["last_name"];
		$link = $login_data["unique_link"];
		
		$data = $_GET['data'];
		$user_id_get = "SELECT * FROM user_tbl WHERE unique_link = '".$data."'";
		$result = mysqli_query($conn, $user_id_get);
		$row = $result->fetch_assoc();
		
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,"http://ip-api.com/json");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result=curl_exec($ch);
		$result=json_decode($result);
		$lat = $result->lat;
		$long = $result->lon;
		$remote_ip = $_SERVER['REMOTE_ADDR'];  
		$system_plateform = $_SERVER["HTTP_USER_AGENT"]; 
		$today_date = date('Y-m-d H:i:s');
		function get_browser_name($user_agent){
			$t = strtolower($user_agent);
			$t = " " . $t;
			if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
			elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
			elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
			elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
			elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
			elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
			return 'Unkown';
		}
		$browser_name = get_browser_name($_SERVER['HTTP_USER_AGENT']);
		$phno = '+1'.$row['mobile_no'];
		$share_query = "INSERT INTO `user_shared_data_tbl`( `user_id`,`machine_info`, `scan_datetime`, `lat`, `long`, `remote_ip`, `local_machine_ip`, `browser_name`) VALUES
													('".$row['user_id']."','". $system_plateform."','". $today_date."','".$lat."', '".$long."','".$remote_ip."','". $local_machine_ip."','". $browser_name."')";
		
		if (mysqli_query($conn, $share_query)) {
			
			
			$twilio_number = "+1 (626) 593-8625";

			$client = new Client($account_sid, $auth_token);
			$message = $client->messages->create(
				// Where to send a text message (your cell phone?)
				$phno,
				array(
					'from' => $twilio_number,
					'body' => 'machine_info : '.$system_plateform.', Scan Datetime : '.$today_date.', Latitude:'.$lat.',Longitude:'.$long.',Remote IP:'.$remote_ip.',Local Machine Ip:'.$local_machine_ip.', Browser Name:'.$browser_name.'.'
							  
					
				)
			);

			if($message){
				// echo 'message sent';
			}
			else {
				echo 'message not send';
			}

			
		} else {
		  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
		<section class="sharedData">
			<div class="fulldiv">
				<h2>Hiii, Welcome to Mercenary.</h2>
			</div>
		</section>
	</body>
</html>