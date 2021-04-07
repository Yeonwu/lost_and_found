<?php
// DEV 또는 SER
define('SERVER_TYPE', 'DEV');

// 개발 서버 설정
if (SERVER_TYPE == 'DEV') {
	define('DB_INFO', array(
		'HOST' => 'localhost',
		'USER' => 'admin',
		'PASSWARD' => '1111',
		'NAME' => 'my_db'
	));
	
	define('PRINT_DEBUG', TRUE);
	
	define('GOOGLE_API_TOKEN', '');
	
	define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "/lost_and_found");
}

// 서비스 서버 설정
if (SERVER_TYPE == 'SER') {
	define('DB_INFO', array(
		'HOST' => '',
		'USER' => '',
		'PASSWARD' => '',
		'NAME' => ''
	));
	
	define('PRINT_DEBUG', FALSE);
	
	define('GOOGLE_API_TOKEN', 'Not Yet');
	
	define('ROOT', $_SERVER['DOCUMENT_ROOT'] . "");
}



if (PRINT_DEBUG == TRUE) {
	error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}
?>