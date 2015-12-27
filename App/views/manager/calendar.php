<?php
// HTML title
$head_title = 'Calendar';

// Get days use went to gym
$user_id = trim(htmlspecialchars($_SESSION['userId']));

$calendar_stmt = $db->prepare("SELECT created_at FROM user_workout WHERE user_id = ? AND deleted_at = '0000-00-00 00:00:00'");
$calendar_stmt->bind_param('i', $user_id);
$calendar_stmt->execute();
$calendar_stmt->bind_result($created_at);
$calendar_stmt->store_result();

$eventLog = array();

// Store event in array to call from looped month later
while ($calendar_stmt->fetch()) {
	$timestamp   = strtotime($created_at);
	$event_year  = date('Y', $timestamp);
	$event_month = date('m', $timestamp);
	$event_day   = date('j', $timestamp);

	$eventLog[$event_year.'-'.$event_month.'-'.$event_day] = true;
}


// Calendar
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

$firstDay    = date('N', mktime(0,0,0, $month_numeric, 1, $year));
$daysInMonth = date('t', mktime(0,0,0, $month_numeric, 1, $year));

$daysInWeek = 1;
?>

<?php include_once('_header.php'); ?>
		
	<div id="content">
		<div class="page-title">
			<h2>Calendar</h2>
		</div>
		
		<div class="calendar-container">
			<div class="calendar-wrapper">
				<div class="calendar-month">
					<a href="?month=<?php echo $date_next; ?>" class="next">next</a>
					<a href="?month=<?php echo $date_prev; ?>" class="prev">prev</a>
					<?php echo $month_name.' '.$year; ?>
				</div>
				<table class="calendar">
				<tr>
					<th>M</th>
					<th>T</th>
					<th>W</th>
					<th>T</th>
					<th>F</th>
					<th>S</th>
					<th>S</th>
				</tr>
				
				<tr>
				
				<?php 
				// Start with empty days for the month,
				// Before the first day of the month
				for ($w = 0; $w < $firstDay-1; $w++) {
					echo '<td>&nbsp;</td>';
					
					$daysInWeek++;
				}	

				// List days
				for($day = 1; $day <= $daysInMonth; $day++) {	
					if ($daysInWeek > 7) {
						echo "</tr><tr>\n";
						
						$daysInWeek = 1;
					}

					$match_date = $year.'-'.$month_numeric.'-'.$day;
					
					if (array_key_exists($match_date, $eventLog)) {
						$padDay = str_pad($day, 2, '0', STR_PAD_LEFT);
						$padMonth = str_pad($month_numeric, 2, '0', STR_PAD_LEFT);
						
						$workoutDate = $year.'-'.$padMonth.'-'.$padDay;
						
						echo '<td class="calendar-day active"><a href="'.$request->url('dashboard?date='.$workoutDate).'" title="View workout for this day"><span class="day"><span class="circle"><span class="v-align">'.$day.'</span></span></span></a></td>';
					} else {
						echo '<td class="calendar-day"><a href=""><span class="day">'.$day.'</span></a></td>';
					}
					
					$daysInWeek++;
				}
				
				for ($w = 0; $w <= 7 - $daysInWeek; $w++) {
					echo '<td>&nbsp;</td>';
				}	
				?>
				</tr>
				</table>
			</div>
			
		</div>
	</div>   
 
<?php include_once('_footer.php'); ?>
