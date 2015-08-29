<?php
namespace App\Controllers;

class Dashboard
{
	public function __construct()
	{
		if (!isSignedIn()) {
			header('Location: ?uri=signin');
		}
	}


	/**
	 * Display list of Exercises
	 */
	public function index($db, $myEmail)
	{
		include('app/Views/manager/dashboard.php');
	}
}
