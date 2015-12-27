<!doctype html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $head_title; ?> | Workout Manager</title>

	<link rel="stylesheet" href="<?php echo $request->url('assets/css/manager.css'); ?>">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	
	<script src="<?php echo $request->url('assets/js/jquery.js'); ?>"></script>
	<script src="<?php echo $request->url('assets/js/5x5.js'); ?>"></script>
</head>
<body>
	<header>
    	<div class="wrapper">
			<div class="userSign">
				<a id="drop" href="#"><span class="hamburger-wrapper"><span class="hamburger"></span></span></a>
				<ul>
					<li><a href="<?php echo $request->url(); ?>">Welcome, <strong><?php echo $user->data('email'); ?></strong></a></li>
					<li><a href="<?php echo $request->url('signout'); ?>">Sign out</a></li>
				</ul>
			</div>
			
			<h1>WM - <?php echo $head_title; ?></h1>
        </div>
    </header>
	
	<div class="backNav"></div>

	<div class="row">	
		<div id="nav">
			<ul>
				<li><a class="ico-workout" href="<?php echo $request->url('dashboard'); ?>" title="Start Workout">Start Workout</a></li>
				<li><a class="ico-workouts" href="<?php echo $request->url('workouts'); ?>" title="Choose or create a workout">Workouts</a></li>
				<li><a class="ico-calendar" href="<?php echo $request->url('calendar'); ?>" title="Calendar">Calendar History</a></li>
				<li><a class="ico-workout-info" href="<?php echo $request->url('information'); ?>" title="Information">Workout Information</a></li>
			</ul>
		</div>