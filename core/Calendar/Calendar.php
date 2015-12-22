<?php

namespace core\Calendar;

use DateTime;

class Calendar
{
	public year;

	public month;

	public day;

	public daysInWeek = 1;

	public firstDay;


	public function create()
	{
		$date = new DateTime();

		$set_month = (isset($_GET['month'])) ? (int) trim($_GET['month']) : '';

		if (!empty($set_month)) {
			$date->setDate(2015, ($set_month+1), 0);
		}

		$month_numeric = $date->format('n');
		$month_name    = $date->format('F');

		$date_prev = ($month_numeric == 1) ? 12 : ($month_numeric-1);
		$date_next = ($month_numeric == 12) ? 1 : ($month_numeric+1);

		$year  = $date->format('Y');

		$this->firstDay    = date('N', mktime(0,0,0, $month_numeric, 1, $year));
		$daysInMonth = date('t', mktime(0,0,0, $month_numeric, 1, $year));
	}

	/**
	 * Get the days leading up to the current month
	 */
	public function prevMonthDays()
	{
		for ($w = 0; $w < $this->firstDay-1; $w++) {
			echo '<td>&nbsp;</td>';
			
			$this->daysInWeek++;
		}	
	}

	/**
	 * Get the days after the current month
	 */
	public function nextMonthDays()
	{
		for ($w = 0; $w <= (7 - $this->daysInWeek); $w++) {
			echo '<td>&nbsp;</td>';
		}	
	}

	/**
	 * Get the number of days in the current month
	 */
	public function currentMonthDays()
	{
		for($day = 1; $day <= $daysInMonth; $day++) {	
			if ($this->daysInWeek > 7) {
				echo "</tr><tr>\n";
				
				$this->daysInWeek = 1;
			}

			$match_date = $year.'-'.$month_numeric.'-'.$day;
			
			if (array_key_exists($match_date, $eventLog)) {
				$padDay = str_pad($day, 2, '0', STR_PAD_LEFT);
				$padMonth = str_pad($month_numeric, 2, '0', STR_PAD_LEFT);
				
				$workoutDate = $year.'-'.$padMonth.'-'.$padDay;
				
				echo '<td class="calendar-day active"><a href="'.$request->url('dashboard?date='.$workoutDate).'" title="View workout for this day">'.$day.'</a></td>';
			} 
			else {
				echo '<td class="calendar-day">'.$day.'</td>';
			}
			
			$this->daysInWeek++;
		}
	}
}
