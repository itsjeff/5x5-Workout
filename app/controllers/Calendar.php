<?php
namespace App\Controllers;

use DateTime;

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
		// HTML title
		$head_title = 'Calendar';

		if (isset($_POST) && $_POST) {
			$postMonth = (!$_POST['month']) ? date('m') : htmlspecialchars($_POST['month']);
			$postYear  = (!$_POST['year']) ? date('Y') : htmlspecialchars($_POST['year']);

			header('location: ?uri=calendar&month='.$postMonth.'&year='.$postYear);
		}

		// Get days use went to gym
		$userId = trim(htmlspecialchars($_SESSION['userId']));

		$calendar_stmt = $db->prepare('SELECT created_on FROM user_workout WHERE user_id = ? GROUP BY created_on');
		$calendar_stmt->bind_param('i', $userId);
		$calendar_stmt->execute();
		$calendar_stmt->bind_result($created_on);
		$calendar_stmt->store_result();

		$eventLog = array();

		// Loop through workout dates, explode to break of time from date
		// an then store date in array to reference with calendar day
		while ($calendar_stmt->fetch()) {
			$explodeCreatedAt = explode(' ', $created_on);

			$eventLog[$explodeCreatedAt[0]] = true;
		}

		// Get another month or year if user needs to view old workouts
		$currentMonth = (isset($_GET['month'])) ? htmlspecialchars($_GET['month']) : date('m');
		$currentYear  = (isset($_GET['year'])) ? htmlspecialchars($_GET['year']) : date('Y');

		$dateObj   = DateTime::createFromFormat('!m', $currentMonth);
		$monthName = $dateObj->format('F');
		
		// Get months days
		$firstDay    = date('N', mktime(0,0,0, $currentMonth, 1, $currentYear));
		$daysInMonth = date('t', mktime(0,0,0, $currentMonth, 1, $currentYear));
		$daysInWeek  = 1;

		// selectMonth
		$monthArray = [
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December'
			];


		include('app/views/manager/calendar.php');
	}
}
