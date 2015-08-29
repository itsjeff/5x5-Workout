<?php
define('ENVIROMENT', 'dev');

switch(ENVIROMENT) {
	case 'dev':
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(-1);
		break;

	default:
		//
		break;
}


// Connect to database
$db = new mysqli('localhost', 'root', '', '5x5');

//  Bring in the spl_loader
require_once __DIR__ . '/vendor/autoload.php';

// Timezone
date_default_timezone_set('Australia/Sydney');

// Start session to allow login and such
session_start();


// SOme quick functions that need to be reorganized
function isSignedIn() {
	if (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) {
		return true;
	}
}

if (isSignedIn()) {
	$userId = (int)$_SESSION['userId'];

	$user_stmt = $db->prepare("SELECT email FROM users WHERE id = ?");
	$user_stmt->bind_param('i', $userId);
	$user_stmt->execute();
	$user_stmt->bind_result($myEmail);
	$user_stmt->store_result();
	$user_stmt->fetch();
}

?>