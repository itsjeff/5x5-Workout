<!doctype html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo $head_title; ?> | 5x5 Workout Manager</title>

	<link rel="stylesheet" href="assets/css/manager.css">
	
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/5x5.js"></script>
</head>
<body>
	<header>
    	<div class="wrapper">
			<div class="userSign">
				<a id="drop" href="#">Menu</a>
				<ul>
					<li><a href="">Welcome, <strong><?php echo $myEmail; ?></strong></a></li>
					<li><a href="?uri=signout">Sign out</a></li>
				</ul>
			</div>
			
			<h1><a href="index.php">5x5 Workout Manager</a></h1>
        </div>
    </header>
	
	<div class="backNav"></div>

	<div class="row">	
		<div id="nav">
			<ul>
				<li><a class="ico-workout" href="?uri=dashboard" title="Start Workout">Start Workout</a></li>
				<li><a class="ico-calendar" href="?uri=calendar" title="Calendar">Calendar History</a></li>
				<li><a class="ico-workout-info" href="?uri=information" title="Information">Workout Information</a></li>
			</ul>
		</div>