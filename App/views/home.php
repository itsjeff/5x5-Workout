<?php include_once  "_header.php"; ?>
 	<div id="heroImage">
		<div class="overlay">
			<div class="wrapper">
				<p><h3>Push for</h3></p>
				<p><h2>Achievments</h2></p>
			</div>
		</div>
	
		<img src="<?php echo $request->url('assets/images/olympic-pull.jpg'); ?>">
	</div>

	
	<div class="content dark">
		<div class="wrapper">
			<h2>What is 5x5?</h2>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed aliquam orci. Donec at nunc porttitor, semper sem sed, ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vulputate malesuada dignissim.</p>

			<p>Donec venenatis orci in turpis fringilla placerat. Mauris sit amet ligula laoreet, elementum magna in, sollicitudin libero. Vivamus ultrices, dui sollicitudin accumsan placerat, eros nibh fermentum est, vel pharetra metus quam vel nisi. Aenean a urna in lectus ornare gravida.</p>
		</div>
	</div>
	
	<!-- Preview Dashboard -->
	<div class="content preview">
		<div class="wrapper">
		
			<div class="row">
				<div class="left">
					<div class="push">
					<h2>Start Working Out</h2>
				
					<p>Get straight into working out with the 5x5 Workout. With this specially</p>
					</div>
				</div>
				
				<div class="right">
					<img class="frame" src="<?php echo $request->url('assets/images/preview-dashboard.jpg'); ?>" alt="5x5 manager - dashboard">
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- Preview Calendar -->
	<div class="content preview">
		<div class="wrapper">
		
			<div class="row">
				<div class="right">
					<div class="push">
					<h2>Keep Track of Workouts</h2>
				
					<ul class="list">
						<li>Check out previous workouts</li>
						<li>Compare progress ...</li>
						<li>and more.</li>
					</ul>
					</div>
				</div>
				
				<div class="left">
					<img class="frame" src="<?php echo $request->url('assets/images/preview-calendar.jpg'); ?>" alt="5x5 manager - dashboard">
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- Workout Information -->
	<div class="content preview">
		<div class="wrapper">
		
			<div class="row">
				<div class="left">
				<div class="push">
					<h2>Information On All Workouts</h2>
				
					<p>Each workout exercise is accompanied with information on performing a specific exercise, which uscles they target, etc.</p>
				</div>
				</div>
				
				<div class="right">
					<img class="frame" src="<?php echo $request->url('assets/images/preview-information.jpg'); ?>" alt="5x5 manager - dashboard">
				</div>
			</div>
			
		</div>
	</div>
	
	<!-- Workout Information -->
	<div class="content preview">
		<div class="wrapper">
		
			<div class="row">
				
				<div class="right">
				<div class="push">
					<h2>Responsive For On-the-Go</h2>
				
					<p>We know you'll always be on the go when it comes to working out, that's why the 5x5 Workout Manager is 
					also viewable on all devices. So now you can track you workouts where ever you go.</p>
				</div>
				</div>
				
				<div class="left">
					<img src="<?php echo $request->url('assets/images/preview-repsonsive.png'); ?>" alt="5x5 manager - dashboard">
				</div>
				
			</div>
			
		</div>
	</div>
	
	
	<!-- Take the Challenege -->
	<div class="content gray border-top">
		<div class="wrapper">
			<h2>Get Results</h2>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed aliquam orci. Donec at nunc porttitor, semper sem sed, ornare odio. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nunc vulputate malesuada dignissim.</p>
			
			<ul class="list">
				<li>To start, it's Free!</li>
				<li>Lose weight without cardio</li>
				<li>Build strength quickly</li>
				<li>Feel better than youever have before</li>
			</ul>
		</div>
	</div>
	
	<div class="content gray center">
		<div class="wrapper">
			<p><a class="button" href="<?php echo $request->url('register'); ?>" title="Take the challenge!">Take the challenge and sign up</a></p>
		</div>
	</div>
	
<?php include_once "_footer.php"; ?>