<?php
// HTML title
$head_title = 'Calendar';

// Get days use went to gym
$userId = trim(htmlspecialchars($_SESSION['userId']));

$calendar_stmt = $db->prepare('SELECT created_on FROM user_workout WHERE user_id = ? GROUP BY created_on');
$calendar_stmt->bind_param('i', $userId);
$calendar_stmt->execute();
$calendar_stmt->bind_result($created_on);
$calendar_stmt->store_result();

$eventLog = array();

// Store event in array to call from looped month later
while ($calendar_stmt->fetch()) {
	$timestamp = strtotime($created_on);
	$day = date('j', $timestamp);
	$eventLog[$day] = true;
}


// Calendar
$date = new DateTime();

$month_numeric = $date->format('n');
$month_name    = $date->format('F');

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
		
		<div class="padding">
			<div class="calendar-wrapper">
				<div class="calendar-month"><?php echo $month_name.' '.$year; ?></div>
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
					
					if (array_key_exists($day, $eventLog)) {
						$padDay = str_pad($day, 2, '0', STR_PAD_LEFT);
						$padMonth = str_pad($month_numeric, 2, '0', STR_PAD_LEFT);
						
						$workoutDate = $year.'-'.$padMonth.'-'.$padDay;
						
						echo "<td class=\"calendar-day active\"><a href=\"/dashboard?date=".$workoutDate."\" title=\"View workout for this day\">".$day."</a></td>\n";
					} else {
						echo "<td class=\"calendar-day\">".$day."</td>\n";
					}
					
					$daysInWeek++;
				}
				
				for ($w = 0; $w <= 7 - $daysInWeek; $w++) {
					echo "<td>&nbsp;</td>\n";
				}	
				?>
				</tr>
				</table>
			</div>
			
		</div>
	</div>   
 
<?php include_once('_footer.php'); ?>
