<?php include_once('_header.php'); ?>

    <div id="content">
        <form method="post" action="<?php echo $request->url('dashboard/create'); ?>">
            <div style="text-align: center; padding-top: 72px;" class="padding">
                <p>You don't have a workout for today.</p>
                <button class="block-button" type="submit">Start New Workout</button>
            </div>
        </form>
    </div>

<?php include_once('_footer.php'); ?>
