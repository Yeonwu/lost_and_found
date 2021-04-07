<?php
//sudo chmod 775 -R google-api-php-client--PHP7.0

header('Content-Type: application/json; charset=utf8');

require_once $_SERVER['DOCUMENT_ROOT'] . "/BMR_WEB_FRAMEWORK/config.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/BMR_WEB_FRAMEWORK/model/google-api-php-client--PHP7.0/vendor/autoload.php";

$id_token = $_POST['idtoken'];

$client = new Google_Client(['client_id' => GOOGLE_API_TOKEN]);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($id_token);


if ($payload) {
	$verify_token = hash('sha256', $payload['email']);
	$json = json_encode(array('success' => TRUE, 'verify_token' => $verify_token));
	print_r($json);
} else {
	echo "{'success':false}";
}
?>