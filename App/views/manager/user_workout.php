<?php include_once('_header.php'); ?>

    <div id="content">
        <form method="post" action="<?php echo $request->url('dashboard/save'); ?>">
            <input type="hidden" name="user_workout_id" value="<?php echo $results['user_workout_id']; ?>">
            
            <div class="page-title user-workout-title">
                <div class="delete">
                    <a href="<?php echo $request->url('dashboard/delete'); ?>" title="Delete workout" data-user-workout="<?php echo $results['user_workout_id']; ?>">(delete)</a>
                </div>

                <h2><?php echo $results['workout_name']; ?> (<?php echo $results['cycle_name']; ?>)</h2>

                <div class="date">
                    <?php if ($results['updated_at'] != '0000-00-00 00:00:00') { ?>
                        <?php
                        $date = new DateTime($results['updated_at']);
                        ?>
                        <span class="text"><strong>Completed:</strong> <?php echo $date->format('d F'); ?></span>
                    <?php 
                    } else { 
                    ?>  
                        <span class="text"><?php echo date('d F'); ?></span>
                    <?php } ?>
                </div>
            </div> <!-- end page title -->

            <div class="padding">
                <?php 
                // Loop through excercises for this plan
                foreach($results['excercises'] as $excercise) { 
                    $start_sets_reps   = explode(', ', $excercise['start_sets_reps']);
                    $current_sets_reps = ($excercise['sets_reps'] != '') ? explode(', ', $excercise['sets_reps']) : array();
                    $current_weight    = ($excercise['set_weight'] == 00.00) ? $excercise['start_weight'] : $excercise['set_weight'];
                    
                    $loop_sets  = (!empty($current_sets_reps)) ? $current_sets_reps : $start_sets_reps;
                ?>

                    <div class="excercise" id="excercise_<?php echo $excercise['workout_plan_id']; ?>" data-workout-id="<?php echo $excercise['workout_plan_id']; ?>">
                        <div class="title">
                            <div class="right">
                                <span class="text">Weight: </span>
                                <a class="weight" title="Change weight" href="#">
                                    <span><?php echo $current_weight; ?></span> KGS
                                </a>
                                <input type="hidden" class="weight-input" name="currentWeight[<?php echo $excercise['workout_plan_id']; ?>][]" value="<?php echo $current_weight; ?>">
                            </div>

                            <a class="excercise-name" href="#<?php echo $excercise['excercise_name']; ?>"><?php echo $excercise['excercise_name']; ?></a>
                        </div>

                        <div class="sets" id="squats">
                            <?php for ($sets = 0; $sets < count($loop_sets); $sets++) { ?>

                            <span name="<?php echo 'ex_'.$excercise['workout_plan_id'].'_rep_'.$sets; ?>" data-rep="<?php echo $start_sets_reps[0]; ?>">
                                <?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '&nbsp'; ?>
                            </span>
                            <input type="hidden" id="<?php echo 'val_ex_'.$excercise['workout_plan_id'].'_rep_'.$sets; ?>" name="excercise[<?php echo $excercise['workout_plan_id']; ?>][]" value="<?php echo (!empty($current_sets_reps)) ? $current_sets_reps[$sets] : '0'; ?>">

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

<?php include_once('_footer.php'); ?>
