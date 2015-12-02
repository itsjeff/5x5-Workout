<?php

require_once 'settings.php';

// User information
if ($user->isSignedIn()) {
    $userId = $user->userId;

    $myEmail = $user->email();
}

// Pages
switch ($request->getBaseUri()) {
    case 'dashboard':
        if (!$user->isSignedIn()) {
            header('Location: /signin');
        }

        $head_title = 'Dashboard';

        $results = $workout->show();

        include_once $view_path.'manager/dashboard.php';
        break;

    case 'dashboard/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$user->isSignedIn()) {
                header('Location: /signin');
            }

            $workout->create();
        }

        header('Location: /dashboard');
        break;

    case 'dashboard/save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$user->isSignedIn()) {
                header('Location: /signin');
            }

            $workout->update();
        }

        header('Location: /dashboard');
        break;

    case 'user/workout/excercise':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$user->isSignedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['response' => 'error', 'msg' => 'Unauthorized action']);
        } 
        else {
            $user_workout_id = (isset($_POST['workout_id'])) ? (int) $_POST['workout_id'] : 0;

            $workout_data = $workout->excercise($user_workout_id);

            header('Content-Type: application/json');

            if ($workout_data) {
                echo json_encode(['response' => 'success', 'msg' => $workout_data]);
            } else {
                echo json_encode(['response' => 'error', 'msg' => 'Excercise does not exist']);
            }
        }
        break;

    case 'calendar':
        if (!$user->isSignedIn()) {
            header('Location: /signin');
        }

        include_once $view_path.'manager/calendar.php';
        break;

    case 'information':
        if (!$user->isSignedIn()) {
            header('Location: /signin');
        }

        include_once $view_path.'manager/information.php';
        break;

    case 'exercise':
        if (!$user->isSignedIn()) {
            header('Location: /signin');
        }

        include_once $view_path.'manager/exercise.php';
        break;

    case 'signin':
        if ($user->isSignedIn()) {
            header('Location: /dashboard');
        }

        include_once $view_path.'signin.php';
        break;

    case 'register':
        if ($user->isSignedIn()) {
            header('Location: /dashboard');
        }

        include_once $view_path.'register.php';
        break;

    case 'signout':
        if ($user->isSignedIn()) {
            $user->signOut();
        }

        header('Location: /signin');
        break;

    default:
        include_once $view_path.'home.php';
        break;
}
