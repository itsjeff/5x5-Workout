<?php
namespace core;

use ReflectionClass;

class Workout 
{
    private $db;

    private $user;

    public $exists;

    /**
     * Construct
     */
    public function __construct($db, $user) 
    {
        $this->db = $db;

        $this->user = $user;
    }

    /**
     * Show current workout
     */
    public function show()
    {
        // User
        $userId = $this->user->userId;

        // Use date to get data for certain workout or todays
        $today = (isset($_GET['date']) && !empty($_GET['date'])) ? $_GET['date'].'%'  : date('Y-m-d').'%';

        $workout_stmt = $this->db->prepare('SELECT updated_on FROM user_workout WHERE user_id = ? AND created_on LIKE ? LIMIT 1');
        $workout_stmt->bind_param('is', $userId, $today);
        $workout_stmt->execute();
        $workout_stmt->bind_result($updated_at);
        $workout_stmt->store_result();
        $workout_stmt->fetch();

        // 1 if there is a workout today, 0 if not
        $this->exists = $workout_stmt->num_rows;

        // List inserted user workout exercises
        $stmt = $this->db->prepare("SELECT exercises.exercise_name, uw.user_workout_id, workout_plans.start_sets_reps, workout_plans.start_weight, uw.sets_reps, uw.set_weight 
            FROM user_workout AS uw
            LEFT JOIN workout_plans ON workout_plans.plan_id = uw.workout_plan_id 
            LEFT JOIN exercises ON exercises.exercise_id = workout_plans.exercise_id
            WHERE uw.user_id = ? AND uw.created_on LIKE ?");

        $stmt->bind_param('is', $userId, $today);
        $stmt->execute();
        $stmt->bind_result($exercise_name, $user_workout_id, $start_sets_reps, $start_weight, $sets_reps, $set_weight);

        $excercises = [];

        while($stmt->fetch()){
            $excercises[] = [
                'exercise_name'   => $exercise_name,
                'user_workout_id' => $user_workout_id,
                'start_sets_reps' => $start_sets_reps,
                'start_weight'    => $start_weight,
                'sets_reps'       => $sets_reps,
                'set_weight'      => $set_weight,
                ];
        }

        $results = [
            'updated_at' => $updated_at,
            'excercises' => $excercises
            ];

        return $results;
    }

    /**
     * Start new workout
     */
    public function create() 
    {
        $userId = $this->user->userId;
        $values = '';
        $limit = 8;
        $created_on = date('Y-m-d H:i:s');

        for ($i = 1; $i <= $limit; $i++) {
            $values .= '('.$userId.', '.$i.', \''.$created_on.'\')';
            
            if ($i < $limit) {
                $values .= ', ';
            }
        }

        if (!$this->db->query("INSERT INTO user_workout (user_id, workout_plan_id, created_on) VALUES $values")) {
            return false;
        }

        return true;  
        echo "'zdd'";  
    }

    /**
     * Finish workout
     */
    public function update() 
    {
        // User id
        $userId = $this->user->userId;

        // Updated on
        $updateTodaysWorkout = date('Y-m-d H:i:s');

        // Array list of excercises, sets and reps
        $workout_data = $_POST['exercise'];

        // Array list of added weight to each excercise
        $workout_weight = $_POST['currentWeight'];
        
        foreach ($workout_data as $user_workout_id => $sets) {
            $user_workout_id = (int) $user_workout_id;

            $set_weight = $workout_weight[$user_workout_id][0];

            $sets_reps = '';

            for ($i = 0; $i < count($sets); $i++) {
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