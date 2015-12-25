<?php
// HTML title
$head_title = 'Information';

// Get exercise information
$exercise_id = (isset($_GET['exercise_id'])) ? (int) $_GET['exercise_id'] : null;

// Get all workouts
$results = $db->query("SELECT * FROM exercises ORDER BY exercise_name ASC");

if ($exercise_id) {
	$exercise_stmt = $db->prepare('SELECT exercise_name, exercise_description FROM exercises WHERE exercise_id = ? LIMIT 1');
	$exercise_stmt->bind_param('i', $exercise_id);
	$exercise_stmt->execute();
	$exercise_stmt->bind_result($exercise_name, $exercise_description);
	$exercise_stmt->store_result();
	$exercise_stmt->fetch();
	
	$exists = $exercise_stmt->num_rows;
}
?>

<?php include_once('_header.php'); ?>
			
		<?php if ($exercise_id && $exists > 0) { ?>
			
		<div id="content">
			<div class="page-title">
				<h2><?php echo $exercise_name; ?></h2>
			</div>

			<div class="padding">

				<h4>Description:</h4>
				
				<div>
					<?php echo $exercise_description; ?>
				</div>
			
		<?php } else { ?>

		<div id="content">
			<div class="page-title">
				<h2>Workout Information</h2>
			</div>
		
			<div class="padding">
			
				<h4>Exercise workourts</h4>
				<ol>
					<?php while($row = $results->fetch_object()) { ?>
					<li><a href="<?php echo $request->url('information?exercise_id='.$row->exercise_id); ?>" title="<?php echo $row->exercise_name; ?>"><?php echo $row->exercise_name; ?></a></li>
					<?php } ?>
				</ol>
					
				<h4>Note:</h4>
				
				<p>Remember to always warm up before exercise, everyone.</p>
			
		<?php } ?>
				
			</div>
		</div>   
 
<?php include_once('_footer.php'); ?>
