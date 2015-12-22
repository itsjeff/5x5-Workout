<?php

namespace core\Workout;

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
     * [show description]
     * 
     * @return array [description]
     */
    public function show()
    {

        $stmt = $this->db->prepare('SELECT id, name, description FROM workout ORDER BY name ASC');
        $stmt->execute();
        $stmt->bind_result($workout_id, $workout_name, $workout_description);
        $stmt->store_result();

        $workouts = [];

        while($stmt->fetch()) {
            $workouts[] = [
				'id'          => $workout_id,
				'name'        => $workout_name,
				'description' => $workout_description
                ];
        }

        return $workouts;
    }
}
