<?php include_once('_header.php'); ?>

        <div id="content">
<?php 
if ($workout->exists < 1) {
?>
            <form method="post" action="/dashboard/create">
                <div style="text-align: center; padding-top: 72px;" class="padding">
                    <p>You don't have workout for today.</p>
                    <button class="block-button" type="submit">Create New Workout</button>
                </div>
            </form>
<?php
}
else {
?>
            <form method="post" action="/dashboard/save">
                <div class="padding">
                    <h2>Workout A</h2>

                    <span class="updated_on"><?php echo ($results['updated_at'] != '0000-00-00 00:00:00') ? 'Workout completed on '.$results['updated_at'] : ''; ?></span>
                    <div class="date"><strong>Todays date:</strong> <?php echo date('d M,Y'); ?></div>
                    
                    <?php 
                    // Loop through excercises for this plan
                    foreach($results['excercises'] as $exercise) { 
                        $start_sets_reps   = explode(', ', $exercise['start_sets_reps']);
                        $current_sets_reps = ($exercise['sets_reps'] != '') ? explode(', ', $exercise['sets_reps']) : array();
                        $current_weight    = ($exercise['set_weight'] == 00.00) ? $exercise['start_weight'] : $exercise['set_weight'];
                        
                        $loop_sets  = (!empty($current_sets_reps)) ? $current_sets_reps : $start_sets_reps;
                    ?>

                    <div class="exercise">
                        <div>
                            <div class="right">
                                Weight: <a class="weight" title="change weight" href="#"><?php echo $current_weight; ?> KGS</a>
                                <input type="hidden" class="currentWeight" name="currentWeight[<?php echo $exercise['user_workout_id']; ?>][]" value="<?php echo $current_weight; ?>">
                            </div>

                            <strong><a href=""><?php echo $exercise['exercise_name']; ?></a></strong>
                        </div>

                        <div class="sets" id="squats">
                            <?php for ($sets = 0; $sets < count($loop_sets); $sets++) { ?>

                            <span name="<?php echo 'ex_'.$exercise['user_workout_id'].'_rep_'.$sets; ?>" data-rep="<?php echo $start_sets_reps[0]; ?>"><?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '&nbsp'; ?></span>

                            <input type="hidden" id="<?php echo 'val_ex_'.$exercise['user_workout_id'].'_rep_'.$sets; ?>" name="exercise[<?php echo $exercise['user_workout_id']; ?>][]" value="<?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '0'; ?>">

                            <?php } ?>
                        </div>
                    </div>

                    <?php } ?>

                    <div class="panelBox">
                        <p>Set Weight:</p> 
                        <input type="text" name="weight" value=""> kgs
                        <a href="#" class="submit" title="save changes">Ok</a>
                    </div>
                </div>

                <div id="finish">
                    <input type="submit" name="finish" value="Finish Workout">
                </div>
            </form>
        </div>

<?php } ?>

<?php include_once('_footer.php'); ?>
