<?php include_once "_header.php"; ?>

		<!-- Login -->
	<div class="content">
		<div class="wrapper">
		
		<div id="formDisplay">
		<div class="padding">
			<h3>Register</h3>
			
			<?php 
			if (count($errors) > 0) { 
				echo '<ul class="message error">';
				
				foreach ($errors as $error) {
					echo '<li>' . $error . '</li>';
				}
				
				echo '</ul>';
			}
			?>
		
			<form method="post">
			<div class="row">
				<label for="email">Email *</label>
				<input class="input fluid" type="text" name="email" id="email" value="" placeholder="Email Address">
			</div>
			
			<div class="row">
				<label for="fullName">Full Name *</label>
				<input class="input fluid" type="text" name="fullName" id="fullName" value="" placeholder="Full Name">
			</div>
			
			<div class="row">
				<label for="password">Password *</label>
				<input class="input fluid" type="password" name="password" id="password" value=""placeholder="Password">
			</div>
			
			<div class="row">
				<label for="password">Confirm Password *</label>
				<input class="input fluid" type="password" name="password2" id="password2" value=""placeholder="Confirm Password">
			</div>
		 
			<div class="row">
				<input class="button" type="submit" name="register" value="Register"> 
				<a href="?uri=signin">Already a member? Sign In.</a>
			</div>
			</form>
			
		</div>
		</div>
			
		</div>
	</div>
	
<?php include_once "_footer.php"; ?>
