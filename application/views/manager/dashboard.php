<?php
// HTML title
$head_title = 'Dashboard';

// Get plan category from GET
$wherePlan = (isset($_GET['plan'])) ? $_GET['plan'] : 1;

// User
$userId = $_SESSION['userId'];

// Use date to gt data for certain workout or todays
$today = (isset($_GET['date']) && !empty($_GET['date'])) ? $_GET['date'].'%'  : date('Y-m-d').'%';

$workout_stmt = $db->prepare('SELECT updated_on FROM user_workout WHERE user_id = ? AND created_on LIKE ? LIMIT 1');
$workout_stmt->bind_param('is', $userId, $today);
$workout_stmt->execute();
$workout_stmt->bind_result($updated_on);
$workout_stmt->store_result();
$workout_stmt->fetch();

$countWorkout = $workout_stmt->num_rows;
	
// List inserted user workout exercises
$stmt = $db->prepare("SELECT exercises.exercise_name, uw.user_workout_id, workout_plans.start_sets_reps, workout_plans.start_weight, uw.sets_reps, uw.set_weight 
	FROM user_workout AS uw
	LEFT JOIN workout_plans ON workout_plans.plan_id = uw.workout_plan_id 
	LEFT JOIN exercises ON exercises.exercise_id = workout_plans.exercise_id
	WHERE uw.user_id = ? AND uw.created_on LIKE ?");

$stmt->bind_param('is', $userId, $today);
$stmt->execute();
$stmt->bind_result($exercise_name, $user_workout_id, $start_sets_reps, $start_weight, $sets_reps, $set_weight);

?>

<?php include_once('_header.php'); ?>

		<div id="content">
			<form method="post" action="/dashboard/save">

<?php 
if ($countWorkout < 1) {
?>

	<div style="text-align: center; padding-top: 72px;" class="padding">
		<p>You don't have workout for today.</p>
		<a class="block-button" href="/dashboard/create">Create New Workout</a>
	</div>
	
<?php
}
else {
?>
			<div class="padding">
				<h2>Workout A</h2>
				<span class="updated_on"><?php echo ($updated_on != '0000-00-00 00:00:00') ? 'Workout completed on '.$updated_on : ''; ?></span>
				
				<div class="date"><strong>Todays date:</strong> <?php echo date('d M,Y'); ?></div>
				
				<?php 
				// Loop through exercises for this plan
				while($row = $stmt->fetch()) { 
					$start_sets_reps   = explode(', ', $start_sets_reps);
					$current_sets_reps = ($sets_reps != '') ? explode(', ', $sets_reps) : array();
					$current_weight = ($set_weight == 00.00) ? $start_weight : $set_weight;
					
					$loop_sets = (!empty($current_sets_reps)) ? $current_sets_reps : $start_sets_reps;
				?>

				<div class="exercise">
					<h4>
						<div class="right">
							Weight: <a class="weight" title="change weight" href="#"><?php echo $current_weight; ?> KGS</a>
							<input type="hidden" class="currentWeight" name="currentWeight[<?php echo $user_workout_id; ?>][]" value="<?php echo $current_weight; ?>">
							
							<div class="panelBox">
								<p>Set Weight:</p> 
								<input type="text" name="weight" value="<?php echo $current_weight; ?>"> kgs
								<a href="#" class="submit" title="save changes">Ok</a>
							</div>
						</div>
						
						<a href=""><?php echo $exercise_name; ?></a>
					</h4>
					
					<div class="sets" id="squats">
					
						<?php for ($sets = 0; $sets < count($loop_sets); $sets++) { ?>
						
						<span name="<?php echo 'ex_'.$user_workout_id.'_rep_'.$sets; ?>" data-rep="<?php echo $start_sets_reps[0]; ?>"><?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '&nbsp'; ?></span>
						
						<input type="hidden" id="<?php echo 'val_ex_'.$user_workout_id.'_rep_'.$sets; ?>" name="exercise[<?php echo $user_workout_id; ?>][]" value="<?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '0'; ?>">
						
						<?php } ?>
						
					</div>
				</div>
				
				<?php } ?>
				
			</div>
			
			<div id="finish">
				<input type="submit" name="finish" value="Finish Workout">
			</div>
			
			</form>
		</div>
		
<?php } ?>

<?php include_once('_footer.php'); ?>
