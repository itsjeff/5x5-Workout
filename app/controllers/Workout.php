<?php
namespace App\Controllers;

class Workout
{
	public function __construct()
	{
		if (!isSignedIn()) {
			header('Location: ?uri=signin');
		}
	}


	/**
	 * Create new exercise for today
	 */
	public function create($db)
	{
		$userId     = $_SESSION['userId'];
		$values     = '';
		$limit      = 8;
		$created_on = date('Y-m-d H:i:s');
		
		for($i = 1; $i <= $limit; $i++) {
			$values .= '('.$userId.', '.$i.', \''.$created_on.'\')';
			
			if ($i < $limit) {
				$values .= ', ';
			}
		}
		
		//var_dump($values);
		
		if($db->query("INSERT INTO user_workout (user_id, workout_plan_id, created_on) VALUES $values")) {
			header('Location: ?uri=dashboard');
		} else {
			$db->error;
		}		
	}


	/**
	 * Update/Save current workout
	 * 
	 * @param  [type] $db [description]
	 */
	public function save($db)
	{
		$userId = $_SESSION['userId'];
		$updateTodaysWorkout = date('Y-m-d H:i:s');
		
		// Check if user_workout row exists and update
		// Place update code below here later
		$workout_data   = $_POST['exercise'];
		$workout_weight = $_POST['currentWeight'];
		
		foreach ($workout_data as $user_workout_id => $sets) {
			$user_workout_id = (int) $user_workout_id;
			$set_weight      = $workout_weight[$user_workout_id][0];

			$sets_reps       = '';
			for($i = 0; $i < count($sets); $i++) {
				$sets_reps .= $sets[$i];
				$sets_reps .= ($i < count($sets) - 1) ? ', ' : '';
			}
			
			// Update query
			$stmt = $db->prepare("UPDATE user_workout SET sets_reps = ?, set_weight = ?, updated_on = ? WHERE user_workout_id = ?");
			$stmt->bind_param('sssi', $sets_reps, $set_weight, $updateTodaysWorkout, $user_workout_id);
			$stmt->execute();
			
			header('Location: ?uri=dashboard');
		}
	}
}
