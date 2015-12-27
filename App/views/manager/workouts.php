<?php include_once('_header.php'); ?>

		<div id="content">
			<div class="page-title">
				<h2>Workouts</h2>
			</div>
		
			<div class="padding">
				<p>Select a workout you would like to use: </p>

				<?php $selected_workout = $user->data('routine'); ?>
				
				<ul class="workout-list">
					<?php 
					foreach($workouts as $workout) { 
						$selected = ($selected_workout == $workout['id']) ? ' checked="checked"' : '';
					?>

					<li>
						<input type="radio" name="select_workout" id="<?php echo $workout['id']; ?>" value="<?php echo $workout['id']; ?>" <?php echo $selected; ?>>
						<label for="<?php echo $workout['id']; ?>"><?php echo $workout['name']; ?></label>
					</li>
					
					<?php } ?>
				</ul>
			</div>
		</div>   
 
<?php include_once('_footer.php'); ?>