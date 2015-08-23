<?php
require_once('settings.php');

$urlRequest = (isset($_GET['uri'])) ? htmlspecialchars($_GET['uri']) : '';
$controller = new Core\Routing\Controller;


// quick function
function isSignedIn() {
	if (isset($_SESSION['userId']) && $_SESSION['userId'] > 0) {
		return true;
	}
}


// User information
if (isSignedIn()) {
	$userId = (int)$_SESSION['userId'];

	$user_stmt = $db->prepare("SELECT email FROM users WHERE id = ?");
	$user_stmt->bind_param('i', $userId);
	$user_stmt->execute();
	$user_stmt->bind_result($myEmail);
	$user_stmt->store_result();
	$user_stmt->fetch();
}



// Pages
switch($urlRequest) {
	case 'dashboard':
		$controller->callAction('index', 'Dashboard', ['db' => $db, 'myEmail' => $myEmail]);
		break;
		
	case 'dashboard/create':
		$controller->callAction('create', 'Workout', ['db' => $db]);
		break;
		
	case 'dashboard/save':
		$controller->callAction('save', 'Workout', ['db' => $db]);
		break;
		
	case 'calendar':
		$controller->callAction('index', 'Calendar', ['db' => $db, 'myEmail' => $myEmail]);
		break;
		
	case 'information':
		$controller->callAction('exercise', 'Exercise', ['db' => $db, 'myEmail' => $myEmail]);
		break;
		
	case 'exercise':
		$controller->callAction('index', 'Exercise', ['db' => $db, 'myEmail' => $myEmail]);
		break;
		
	case 'signin':
		$controller->callAction('signin', 'Home', ['db' => $db]);
		break;

	case 'signout':
		$controller->callAction('signout', 'Home', ['db' => $db]);
		break;
		
	case 'register':
		$controller->callAction('register', 'Home', ['db' => $db]);
		break;
		
	default: 
		$controller->callAction('index', 'Home');
		break;
}