<?php
	
$apitoken = "";
	
	
// IsItUp service requires a user agent.
$user_agent = "IsitupForSlack/1.0 (https://github.com/mccreath/istiupforslack; mccreath@gmail.com)";


$command = isset($_REQUEST['command']) ? $_REQUEST['command'] : null;
$domain = isset($_REQUEST['text']) ? $_REQUEST['text'] : null;
$token = isset($_REQUEST['token']) ? $_REQUEST['token'] : null;


if ($token == $apitoken) {
	
	$url_to_check = "https://isitup.org/".$domain.".json";
	$ch = curl_init($url_to_check);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  $ch_response = curl_exec($ch);
  $errors = curl_error($ch);
	curl_close($ch);

	$result = json_decode($ch_response, TRUE);
	$reply = '';

var_dump($errors);
	
	if ($ch_response === FALSE) {
		"Isitup.com is DOWN! Yikes!";
	} else {
		switch ($result['status_code']) {
			case 1:
				$reply = "Good news! {$result['domain']} is up! :tada:";
				break;
			case 2:
				$reply = "Uh-oh, {$result['domain']} is down. :frowning:";
				break;
			case 3:
				$reply = "The domain you entered ({$result['domain']}) does not appear to be valid. :bug:";
				
				break;
			default:
				$reply = "Uh... something weird happened. :clown:";
		}
	}
	if ($reply <> '') {
		print $reply;
	} else {
		print "Ruh-roh, shaggy.";
	}
	
} else {
	die("Token does not match.");
}
