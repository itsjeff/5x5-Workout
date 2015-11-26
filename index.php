<?php
require_once('settings.php');

// User information
if ($user->isSignedIn()) {
    $userId = $user->userId;

    $myEmail = $user->email();
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
