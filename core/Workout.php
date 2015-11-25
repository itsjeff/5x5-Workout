<?php
namespace core;

class Workout 
{
	private $db;

	private $user;

	/**
	 * Construct
	 */
	public function __construct($db, $user) 
	{
		$this->db = $db;

		$this->user = $user;
	}


	/**
	 * Save current workout
	 */
	function updateWorkout() 
	{
		// User id
		$userId = $this->user->userId;

		// Updated on
		$updateTodaysWorkout = date('Y-m-d H:i:s');

		// Array list of excerices, sets and reps
		$workout_data   = $_POST['exercise'];

		// Array list of added weight to each excercise
		$workout_weight = $_POST['currentWeight'];
		
		foreach ($workout_data as $user_workout_id => $sets) {
			$user_workout_id = (int) $user_workout_id;

			$set_weight = $workout_weight[$user_workout_id][0];
			$sets_reps  = '';
			
			for($i = 0; $i < count($sets); $i++) {
				$sets_reps .= $sets[$i];
				
				$sets_reps .= ($i < count($sets) - 1) ? ', ' : '';
			}
			
			// Update query
			$stmt = $this->db->prepare("UPDATE user_workout SET sets_reps = ?, set_weight = ?, updated_on = ? WHERE user_workout_id = ?");
			$stmt->bind_param('sssi', $sets_reps, $set_weight, $updateTodaysWorkout, $user_workout_id);
			$stmt->execute();
		}
	}
}