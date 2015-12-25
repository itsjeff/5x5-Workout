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

        $results = $user_workout->show();

        if ($user_workout->exists < 1) {
            $head_title = 'Dashboard';

            include_once $view_path.'manager/dashboard.php';
        }
        else {
            $head_title = 'Workout';

            include_once $view_path.'manager/user_workout.php';
        }
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

    case 'dashboard/delete':
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$user->isSignedIn()) {
            echo json_encode(['response' => 'error', 'msg' => 'Unauthorized action']);
        }
        else {
            $user_workout_id = (isset($_POST['user_workout_id']) ? (int) $_POST['user_workout_id'] : 0);

            if ($user_workout_id > 0) {
                if ($user_workout->delete($user_workout_id)) {
                    echo json_encode(['response' => 'success', 'msg' => 'User Workout #'.$user_workout_id.' was removed.']);
                } else {
                    echo json_encode(['response' => 'error', 'msg' => 'Record did not exist, or user workout #'.$user_workout_id.' does not belong to user.']);
                }
            }
            else {
                echo json_encode(['response' => 'error', 'msg' => 'Please provide an Id']);    
            }
        }
        break;

    case 'user/workout/excercise':
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$user->isSignedIn()) {
            echo json_encode(['response' => 'error', 'msg' => 'Unauthorized action']);
        } 
        else {
            $user_workout_id = (isset($_POST['workout_id'])) ? (int) $_POST['workout_id'] : 0;

            $workout_data = $user_workout->excercise($user_workout_id);

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
