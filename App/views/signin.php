<?php
$errors = array();
	
if (isset($_POST['signin'])) {
	// Form variables
	$email     = (isset($_POST['email'])) ? trim(htmlspecialchars($_POST['email'])) : '';
	$password  = (isset($_POST['password'])) ? trim(htmlspecialchars($_POST['password'])) : '';
	
	// Check user already exists
	if ($stmt = $db->prepare('SELECT id, email, password FROM users WHERE email = ? LIMIT 1')) {
		$stmt->bind_param('s', $email);	
		$stmt->execute();
		$stmt->bind_result($userId, $userEmail, $userPassword);
		$stmt->store_result();
		$stmt->fetch();
	}

	$countUserRows = $stmt->num_rows();
	
	// Validate credentials
	if ($countUserRows > 0) {}
		
	if (!$email) {
		$errors[] = 'Email field was left empty.';
	}
	else if ($countUserRows < 1) {
		$errors[] = 'Email is not registered.';
	}
	
	if (!$password) {
		$errors[] = 'Password field was left empty.';
	}
	else if ($countUserRows > 0 && !password_verify($password, $userPassword)) {
		$errors[] = 'Credentials do not match.';	
	}
	
	// If all went well sign in user
	if (count($errors) < 1) {
		$_SESSION['userId'] = $userId;
		
		header('Location: '.$request->url('dashboard'));
	}
}
?>

<?php include_once "_header.php"; ?>

		<!-- Login -->
	<div class="content">
		<div class="wrapper">
		
		<div id="formDisplay">
		<div class="padding">
			<h3>Sign In</h3>
			
			<?php 
			if (count($errors) > 0) { 
				echo '<ul class="message error">';
				
				foreach ($errors as $error) {
					echo '<li>' . $error . '</li>';
				}
				
				echo '</ul>';
			}
			?>
		
			<form method="post" action="">
			<div class="row">
				<label for="email">Email</label>
				<input class="input fluid" type="text" name="email" id="email" value="" placeholder="Email Address">
			</div>
			
			<div class="row">
				<label for="password">Password</label>
				<input class="input fluid" type="password" name="password" id="password" value=""placeholder="Password">
			</div>
		 
			<div class="row">
				<input class="button" type="submit" name="signin" value="Sign In"> 
				<a href="<?php echo $request->url('register'); ?>">Not a member? Register now.</a>
			</div>
			</form>
			
		</div>
		</div>
			
		</div>
	</div>
	
<?php include_once "_footer.php"; ?>