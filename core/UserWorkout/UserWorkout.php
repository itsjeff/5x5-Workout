<?php
namespace core\UserWorkout;

use core\Workout\Workout;

class UserWorkout 
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
        $user_id = $this->user->userId;

        // Use date to get data for certain workout or todays
        $today = (isset($_GET['date']) && !empty($_GET['date'])) ? $_GET['date'].'%'  : date('Y-m-d').'%';

        // Select workout data based on calendar date or today's date
        $workout_stmt = $this->db->prepare('SELECT uw.id, uw.updated_at, w.id, w.name, wc.name FROM user_workout AS uw 
            LEFT JOIN workout_cycles AS wc ON wc.id = uw.workout_cycle_id 
            LEFT JOIN workout AS w ON w.id = wc.workout_id 
            WHERE uw.user_id = ? AND uw.created_at LIKE ? AND uw.deleted_at = "0000-00=00 00:00:00" 
            LIMIT 1');
        $workout_stmt->bind_param('is', $user_id, $today);
        $workout_stmt->execute();
        $workout_stmt->bind_result($user_workout_id, $updated_at, $workout_id, $workout_name, $cycle_name);
        $workout_stmt->store_result();
        $workout_stmt->fetch();

        // 1 if there is a workout today, 0 if not
        $this->exists = $workout_stmt->num_rows;

        if ($this->exists > 0) {
            // List excercises based off user's selected workout routine 
            $stmt = $this->db->prepare("SELECT e.exercise_id, e.exercise_name, wp.start_sets_reps, wp.start_weight, uwe.sets_reps, uwe.set_weight, uwe.workout_plan_id   
                FROM user_workout_excercises AS uwe 
                LEFT JOIN workout_plans AS wp ON wp.plan_id = uwe.workout_plan_id 
                LEFT JOIN exercises AS e ON e.exercise_id = wp.exercise_id 
                WHERE uwe.user_workout_id = ?");

            $stmt->bind_param('i', $user_workout_id);
            $stmt->execute();
            $stmt->bind_result($excercise_id, $excercise_name, $start_sets_reps, $start_weight, $user_sets_reps, $user_weight, $workout_plan_id);
            $stmt->store_result();

            $excercises = [];

            while($stmt->fetch()){
                $excercises[] = [
                    'workout_plan_id' => $workout_plan_id, 
                    'excercise_id'    => $excercise_id,
                    'excercise_name'  => $excercise_name,
                    'start_sets_reps' => $start_sets_reps,
                    'start_weight'    => $start_weight,
                    'sets_reps'       => $user_sets_reps,
                    'set_weight'      => $user_weight,
                    ];
            }

            $results = [
                'user_workout_id' => $user_workout_id,
                'workout_name' => $workout_name,
                'cycle_name' => $cycle_name,
                'updated_at' => $updated_at,
                'excercises' => $excercises
                ];

            return $results;
        } 
        else {
            return [];
        }
    }

    /**
     * Start new workout
     */
    public function create() 
    {
        // User details
        $user_id = $this->user->userId;

        // Get user's prefered workout routine
        $workout_cycle_id = $this->userSelectedWorkout();

        // Todays date
        $created_at = date('Y-m-d H:i:s');

        //Insert user workout
        $stmt = $this->db->prepare("INSERT INTO user_workout (user_id, workout_cycle_id, created_at) VALUES (?, ?, ?)");
        $stmt->bind_param('iis', $user_id, $workout_cycle_id, $created_at);
        $stmt->execute();

        // Select workout planto get start weights
        $wp = $this->db->prepare("SELECT start_weight, plan_id FROM workout_plans WHERE workout_cycle_id = ?");
        $wp->bind_param('i', $workout_cycle_id);
        $wp->execute();
        $wp->bind_result($start_weight, $plan_id);
        $wp->store_result();

        $user_workout_id = $wp->insert_id;

        //Insert user workout excercises
        $stmt = $this->db->prepare("INSERT INTO user_workout_excercises (set_weight, user_workout_id, workout_plan_id) VALUES (?, ?, ?)");

        while ($wp->fetch()) {
            $stmt->bind_param('sii', $start_weight, $user_workout_id, $plan_id);
            $stmt->execute();
        }

        return true;    
    }

    /**
     * Finish workout or update workout
     */
    public function update() 
    {
        // User
        $user_id = $this->user->userId;

        // Post date
        $user_workout_id  = (int) $_POST['user_workout_id'];
        $workout_data     = $_POST['excercise'];
        $excercise_weight = $_POST['currentWeight'];

        // Insert userssets, reps and weight
        $stmt = $this->db->prepare("UPDATE user_workout_excercises SET sets_reps = ?, set_weight = ? WHERE workout_plan_id = ?");

        foreach ($workout_data as $excercise => $reps) {
            $set_weight = $excercise_weight[$excercise][0];
            $sets_reps = implode(', ', $reps);

            $stmt->bind_param('ssi', $sets_reps, $set_weight, $excercise);
            $stmt->execute();
        }

        // Update user workout date
        $updated_at = date('Y-m-d H:i:s');

        $stmt = $this->db->prepare("UPDATE user_workout SET updated_at = ? WHERE id = ?");
        $stmt->bind_param('si', $updated_at, $user_workout_id);
        $stmt->execute();
    }

    /**
     * Soft delete user workout
     */
    public function delete()
    {
        $user_workout_id = 0;

        $user_id = $this->user->userId;

        $date = date('Y-m-d H:i:s');

        // Update delete at
        $stmt = $this->db->prepare("UPDATE user_workout SET deleted_at = ? WHERE id = ? AND user_id = ? LIMIT 1");
        $stmt->bind_param('sii', $date, $user_workout_id, $user_id);
        $stmt->execute();   
    }

    /**
     * Get excercise data
     * 
     * @return array  return excercise data from workout as an array
     */
    public function excercise($excercise_id = 0)
    {
        // User
        $user_id = $this->user->userId;

        if ($excercise_id != 0) {
            $stmt = $this->db->prepare("SELECT exercises.exercise_name, uw.user_workout_id, workout_plans.start_sets_reps, workout_plans.start_weight, uw.sets_reps, uw.set_weight 
                FROM user_workout_excercises AS uw
                LEFT JOIN workout_plans ON workout_plans.plan_id = uw.workout_plan_id 
                LEFT JOIN exercises ON exercises.exercise_id = workout_plans.exercise_id
                WHERE uw.user_id = ? AND uw.user_workout_id = ? LIMIT 1"); 

                $stmt->bind_param('ii', $user_id, $excercise_id);
                $stmt->execute();
                $stmt->bind_result($exercise_name, $user_workout_id, $start_sets_reps, $start_weight, $sets_reps, $set_weight);
                $stmt->fetch();

            $results = [
                'id'              => $excercise_id,
                'exercise_name'   => $exercise_name,
                'user_workout_id' => $user_workout_id,
                'start_sets_reps' => $start_sets_reps,
                'start_weight'    => $start_weight,
                'sets_reps'       => $sets_reps,
                'set_weight'      => $set_weight
                ];

            return $results;
        } 

        return false;
    }

    /**
     * Get users selected workout information
     *
     * @return  int  Return user's next cycle id from workout
     */
    public function userSelectedWorkout()
    {
        $user_id = $this->user->userId;
        $selected_workout = $this->user->workout();
        $recent_cycle = 0;

        // Get cycle
        $stmt = $this->db->prepare("SELECT uw.workout_cycle_id FROM user_workout AS uw WHERE uw.user_id = ? ORDER BY uw.id DESC LIMIT 1");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->bind_result($recent_cycle);
        $stmt->store_result();
        $stmt->fetch();

        // Get cycle
        $stmt = $this->db->prepare("SELECT wc.id FROM workout_cycles AS wc 
            WHERE (
                wc.workout_id = ? 
                AND wc.id = IFNULL((select min(id) from workout_cycles where id > ?), 0)
                OR wc.id = IFNULL((select max(id) from workout_cycles where id > ?), 
                    (select min(id) from workout_cycles where workout_id = ?))
            )
            LIMIT 1");
        $stmt->bind_param('iiii', $selected_workout, $recent_cycle, $recent_cycle, $selected_workout);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->store_result();

        $stmt->fetch();

        return $id;
    }
}