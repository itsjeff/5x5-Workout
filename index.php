<?php
require_once('settings.php');

// User information
if ($user->isSignedIn()) {
	$userId = (int)$_SESSION['userId'];

	$user_stmt = $db->prepare("SELECT email FROM users WHERE id = ?");
	$user_stmt->bind_param('i', $userId);
	$user_stmt->execute();
	$user_stmt->bind_result($myEmail);
	$user_stmt->store_result();
	$user_stmt->fetch();
}

// Get uri for pretty urls
$end_uri     = (!isset($_SERVER['REQUEST_URI'])) ?: ltrim(htmlspecialchars($_SERVER['REQUEST_URI']), '/');
$current_uri = explode('?', $end_uri);

// Pages
switch($current_uri[0]) {
	case 'dashboard':
		if (!$user->isSignedIn()) {
			header('Location: /signin');
		}
		
		require_once($view_path . 'manager/dashboard.php');
		break;
		
	case 'dashboard/create':
		if (!$user->isSignedIn()) {
			header('Location: /signin');
		}
		
		$userId = $_SESSION['userId'];
		$values = '';
		$limit  = 8;
		$created_on = date('Y-m-d H:i:s');
		
		for($i = 1; $i <= $limit; $i++) {
			$values .= '('.$userId.', '.$i.', \''.$created_on.'\')';
			
			if ($i < $limit) {
				$values .= ', ';
			}
		}
		
		if($db->query("INSERT INTO user_workout (user_id, workout_plan_id, created_on) VALUES $values")) {
			header('Location: /dashboard');
		} else {
			$db->error;
		}		
		break;
		
	case 'dashboard/save':			
		$userId = $_SESSION['userId'];
		$updateTodaysWorkout = date('Y-m-d H:i:s');
		
		// Check if user_workout row exists and update
		// Place update code below here later
		$workout_data   = $_POST['exercise'];
		$workout_weight = $_POST['currentWeight'];
		
		foreach ($workout_data as $user_workout_id => $sets) {
			$user_workout_id = (int) $user_workout_id;

			$set_weight = $workout_weight[$user_workout_id][0];
			$sets_reps  = '';
			
			for($i = 0; $i < count($sets); $i++) {
				$sets_reps .= $sets[$i];
				
				$sets_reps .= ($i < count($sets) - 1) ? ', ' : '';
			}
			
			// Update query
			$stmt = $db->prepare("UPDATE user_workout SET sets_reps = ?, set_weight = ?, updated_on = ? WHERE user_workout_id = ?");
			$stmt->bind_param('sssi', $sets_reps, $set_weight, $updateTodaysWorkout, $user_workout_id);
			$stmt->execute();
			
			header('Location: /dashboard');
		}
		break;
		
	case 'calendar':
		if (!$user->isSignedIn()) {
			header('Location: /signin');
		}
		
		require_once($view_path . 'manager/calendar.php');
		break;
		
	case 'information':
		if (!$user->isSignedIn()) {
			header('Location: /signin');
		}
		
		require_once($view_path . 'manager/information.php');
		break;
		
	case 'exercise':
		if (!$user->isSignedIn()) {
			header('Location: /signin');
		}
		
		require_once($view_path . 'manager/exercise.php');
		break;
		
	case 'signin':
		if ($user->isSignedIn()) {
			header('Location: /dashboard');
		}
		
		require_once($view_path . 'signin.php');
		break;
		
	case 'register':
		if ($user->isSignedIn()) {
			header('Location: /dashboard');
		}
		
		require_once($view_path . 'register.php');
		break;
		
	case 'signout':
		if ($user->isSignedIn()) {
			$user->signOut();
		}
		
		header('Location: /signin');
		break;
		
	default: 
		require_once($view_path . 'home.php');
		break;
}
