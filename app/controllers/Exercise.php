<?php
namespace App\Controllers;

class Exercise
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
		include('app/views/manager/exercise.php');
	}


	/**
	 * Display Information on exercise
	 */
	public function exercise($db, $myEmail)
	{
		include('app/views/manager/information.php');
	}
}
