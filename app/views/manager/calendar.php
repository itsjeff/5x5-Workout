<?php include_once('_header.php'); ?>
		
	<div id="content">
		<div class="padding">
			<h2>Calendar</h2>
			
			<div class="date center">
				<form method="post">
					<select name="month">
						<?php foreach ($monthArray as $key => $val) {
							$selectMonth = ($key == $currentMonth) ? ' selected' : '';
							echo '<option value="'.$key.'"'.$selectMonth.'>'.$val.'</option>';
						}
						?>
					</select>

					<select name="year">
						<?php 
						for ($i = 1988; $i <= date('Y'); $i++) {
							$selectYear = ($i == $currentYear) ? ' selected' : '';
							echo '<option value="'.$i.'"'.$selectYear.'>'.$i.'</option>';
						}
						?>
					</select>
					<input name="submit" type="submit" value="go">
				</form>
			</div>
			
			<table id="calendar">
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

				$padDay   = str_pad($day, 2, '0', STR_PAD_LEFT);
				$padMonth = str_pad($currentMonth, 2, '0', STR_PAD_LEFT);

				$fullDate = $currentYear.'-'.$padMonth.'-'.$padDay;
				
				if (array_key_exists($fullDate, $eventLog)) {
					$workoutDate = $currentYear.'-'.$padMonth.'-'.$padDay;
					
					echo "<td class=\"calendar-day active\"><a href=\"?uri=dashboard&amp;date=".$workoutDate."\" title=\"View workout for this day\">".$day."</a></td>\n";
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
 
<?php include_once('_footer.php'); ?>
