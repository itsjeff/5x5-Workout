<?php include_once('_header.php'); ?>

        <div id="content">
<?php 
if ($workout->exists < 1) {
?>
            <form method="post" action="<?php echo $request->url('dashboard/create'); ?>">
                <div style="text-align: center; padding-top: 72px;" class="padding">
                    <p>You don't have a workout for today.</p>
                    <button class="block-button" type="submit">Create New Workout</button>
                </div>
            </form>
<?php
}
else {
?>
            <form method="post" action="<?php echo $request->url('dashboard/save'); ?>">
                <div class="page-title">
                    <h2>Workout name</h2>

                    <div class="date">
                        <?php if ($results['updated_at'] != '0000-00-00 00:00:00') { ?>
                            <?php
                            $date = new DateTime($results['updated_at']);
                            ?>
                            <span class="text"><strong>Workout completed on</strong> <?php echo $date->format('d F'); ?></span>
                        <?php 
                        } else { 
                        ?>  
                            <span class="text"><strong>Today is</strong> <?php echo date('d F'); ?></span>
                        <?php } ?>
                    </div>
                </div> <!-- end page title -->

                <div class="padding">
                    <?php 
                    // Loop through excercises for this plan
                    foreach($results['excercises'] as $exercise) { 
                        $start_sets_reps   = explode(', ', $exercise['start_sets_reps']);
                        $current_sets_reps = ($exercise['sets_reps'] != '') ? explode(', ', $exercise['sets_reps']) : array();
                        $current_weight    = ($exercise['set_weight'] == 00.00) ? $exercise['start_weight'] : $exercise['set_weight'];
                        
                        $loop_sets  = (!empty($current_sets_reps)) ? $current_sets_reps : $start_sets_reps;
                    ?>

                        <div class="excercise" id="excercise_<?php echo $exercise['user_workout_id']; ?>" data-workout-id="<?php echo $exercise['user_workout_id']; ?>">
                            <div class="title">
                                <div class="right">
                                    Weight: 
                                    <a class="weight" title="Change weight" href="#">
                                        <span><?php echo $current_weight; ?></span> KGS
                                    </a>
                                    <input type="hidden" class="weight-input" name="currentWeight[<?php echo $exercise['user_workout_id']; ?>][]" value="<?php echo $current_weight; ?>">
                                </div>

                                <a class="excercise-name" href="#<?php echo $exercise['exercise_name']; ?>"><?php echo $exercise['exercise_name']; ?></a>
                            </div>

                            <div class="sets" id="squats">
                                <?php for ($sets = 0; $sets < count($loop_sets); $sets++) { ?>

                                <span name="<?php echo 'ex_'.$exercise['user_workout_id'].'_rep_'.$sets; ?>" data-rep="<?php echo $start_sets_reps[0]; ?>">
                                    <?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '&nbsp'; ?>
                                </span>
                                <input type="hidden" id="<?php echo 'val_ex_'.$exercise['user_workout_id'].'_rep_'.$sets; ?>" name="exercise[<?php echo $exercise['user_workout_id']; ?>][]" value="<?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '0'; ?>">

                                <?php } ?>
                            </div>
                        </div>

                    <?php } ?>

                    <div class="panel-box-wrapper">
                        <div class="panel-box">
                            <h4 class="excercise-name">Excercise name</h4>

                            <div class="text">
                                Place <span class="add-weight">0.00</span> kg on both sides.
                            </div>

                            <label>Total Weight:</label> 
                            <div class="weight-input">
                                <input type="text" name="weight" value="0.00">
                                <button name="subtract">-</button>
                                <button name="add">+</button>
                            </div>

                            <div class="update-wrapper">
                                <button class="update" title="save changes">Update weight</button>
                            </div>
                        </div>

                        <div class="panel-box-overlay"></div>
                    </div>
                </div>

                <div id="finish">
                    <input type="submit" name="finish" value="Finish Workout">
                </div>
            </form>
        </div>

<?php } ?>

<?php include_once('_footer.php'); ?>
