<?php
namespace App\Controllers;

class Calendar
{
	public function __construct()
	{
		if (!isSignedIn()) {
			header('Location: ?uri=signin');
		}
	}


	/**
	 * Display calendar
	 */
	public function index($db, $myEmail)
	{
		include('app/views/manager/calendar.php');
	}
}
