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
            header('Location: '.$request->url('signin'));
        }

        $head_title = 'Dashboard';

        $results = $user_workout->show();

        include_once $view_path.'manager/dashboard.php';
        break;

    case 'dashboard/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$user->isSignedIn()) {
                header('Location: '.$request->url('signin'));
            }

            $user_workout->create();
        }

        header('Location: '.$request->url('dashboard'));
        break;

    case 'dashboard/save':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$user->isSignedIn()) {
                header('Location: '.$request->url('signin'));
            }

            $user_workout->update();
        }

        header('Location: '.$request->url('dashboard'));
        break;

    case 'user/workout/excercise':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$user->isSignedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['response' => 'error', 'msg' => 'Unauthorized action']);
        } 
        else {
            $user_workout_id = (isset($_POST['workout_id'])) ? (int) $_POST['workout_id'] : 0;

            $workout_data = $user_workout->excercise($user_workout_id);

            header('Content-Type: application/json');

            if ($workout_data) {
                echo json_encode(['response' => 'success', 'msg' => $workout_data]);
            } else {
                echo json_encode(['response' => 'error', 'msg' => 'Excercise does not exist']);
            }
        }
        break;

    case 'workouts':
        if (!$user->isSignedIn()) {
            header('Location: '.$request->url('signin'));
        }

        $head_title = 'Workouts';
        $workouts = $workout->show();

        include_once $view_path.'manager/workouts.php';
        break;

    case 'calendar':
        if (!$user->isSignedIn()) {
            header('Location: '.$request->url('signin'));
        }

        include_once $view_path.'manager/calendar.php';
        break;

    case 'information':
        if (!$user->isSignedIn()) {
            header('Location: '.$request->url('signin'));
        }

        include_once $view_path.'manager/information.php';
        break;

    case 'exercise':
        if (!$user->isSignedIn()) {
            header('Location: '.$request->url('signin'));
        }

        include_once $view_path.'manager/exercise.php';
        break;

    case 'signin':
        if ($user->isSignedIn()) {
            header('Location: '.$request->url('dashboard'));
        }

        include_once $view_path.'signin.php';
        break;

    case 'register':
        if ($user->isSignedIn()) {
            header('Location: '.$request->url('dashboard'));
        }

        include_once $view_path.'register.php';
        break;

    case 'signout':
        if ($user->isSignedIn()) {
            $user->signOut();
        }

        header('Location: '.$request->url('signin'));
        break;

    default:
        include_once $view_path.'home.php';
        break;
}
