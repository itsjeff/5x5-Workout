<?php
namespace App\Controllers;

use App\User;

class Home
{
	public function __construct()
	{

	}

	/**
	 * [index description]
	 * 
	 * @return [type] [description]
	 */
	public function index()
	{
		include('app/views/home.php');
	}


	/**
	 * Show sign in form and process sign in request
	 * 
	 * @param  object $db
	 * @return mixed     
	 */
	public function signin($db) 
	{
		if (isSignedIn()) {
			header('Location: ?uri=dashboard');
		}

		$errors = array();
			
		if (isset($_POST['signin'])) {
			// Form variables
			$email     = (isset($_POST['email'])) ? trim(htmlspecialchars($_POST['email'])) : '';
			$password  = (isset($_POST['password'])) ? trim(htmlspecialchars($_POST['password'])) : '';
			
			// Check user already exists
			if ($stmt = $db->prepare('SELECT id, email, password FROM users WHERE email = ? LIMIT 1')) {
				$stmt->bind_param('s', $email);	
				$stmt->execute();
				$stmt->bind_result($userId, $userEmail, $userPassword);
				$stmt->store_result();
				$stmt->fetch();
			}

			$countUserRows = $stmt->num_rows();
			
			// Validate credentials
			if ($countUserRows > 0) {}
				
			if (!$email) {
				$errors[] = 'Email field was left empty.';
			}
			else if ($countUserRows < 1) {
				$errors[] = 'Email is not registered.';
			}
			
			if (!$password) {
				$errors[] = 'Password field was left empty.';
			}
			else if ($countUserRows > 0 && !password_verify($password, $userPassword)) {
				$errors[] = 'Credentials do not match.';	
			}
			
			// If all went well sign in user
			if (count($errors) < 1) {
				$_SESSION['userId'] = $userId;
				
				header('Location: ?uri=dashboard');
			}
		}
		
		include('app/views/signin.php');
	}


	/**
	 * Sign out user
	 */
	public function signout() 
	{
		if (isSignedIn()) {
			if (isset($_COOKIE[session_name()])) {
				setcookie(session_name(), '', time()-300, '/');
			}
			session_destroy();
		}
		
		header('Location: ?uri=signin');
	}


	/**
	 * Display registration form and process on request
	 * 
	 * @param  object $db
	 * @return mixed    
	 */
	public function register($db) 
	{
		if (isSignedIn()) {
			header('Location: ?uri=dashboard');
		}

		$errors = array();

		if (isset($_POST['register'])) {
			// Form variables
			$fullName  = (isset($_POST['fullName'])) ? trim(htmlspecialchars($_POST['fullName'])) : '';
			$email     = (isset($_POST['email'])) ? trim(htmlspecialchars($_POST['email'])) : '';
			$password  = (isset($_POST['password'])) ? trim(htmlspecialchars($_POST['password'])) : '';
			$password2 = (isset($_POST['password2'])) ? trim(htmlspecialchars($_POST['password2'])) : '';
			
			// Check user already exists
			$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
			$stmt->bind_param('s', $email);	
			$stmt->execute();
			$stmt->store_result();
			
			$countUserRows = $stmt->num_rows();

			
			// Validate information
			if (!$fullName) {
				$errors[] = 'Full Name field was left empty.';
			}
			
			if (!$email) {
				$errors[] = 'Email field was left empty.';
			}
			else if ($countUserRows > 0) {
				$errors[] = 'Email already in use.';
			}
			
			if (!$password) {
				$errors[] = 'Password field was left empty.';
			}
			
			if (!$password2) {
				$errors[] = 'Confirm Password field was left empty.';
			}
			else if ($password != $password2) {
				$errors[] = 'Passwords do not match.';	
			}
			
			// All good? Process registration, else
			// display errors to use
			if (count($errors) < 1) {
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);
				$created_at = date('Y-m-d H:i:s');
				
				$stmt = $db->prepare('INSERT INTO users (email, fullName, password, created_at) VALUES (?, ?, ?, ?)');
				$stmt->bind_param('ssss', $email, $fullName, $passwordHash, $created_at);
				$stmt->execute();
				$stmt->store_result();
				
				// Log in user straight away
				$_SESSION['userId'] = $stmt->insert_id;
				
				header('Location: ?uri=dashboard');
			}
		}
		
		include('app/views/register.php');
	}
}
