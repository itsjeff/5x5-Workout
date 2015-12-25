<?php
$errors = array();

if (isset($_POST['register'])) {
	// Form variables
	$fullName  = (isset($_POST['fullName'])) ? trim(htmlspecialchars($_POST['fullName'])) : '';
	$email     = (isset($_POST['email'])) ? trim(htmlspecialchars($_POST['email'])) : '';
	$password  = (isset($_POST['password'])) ? trim(htmlspecialchars($_POST['password'])) : '';
	$password2 = (isset($_POST['password2'])) ? trim(htmlspecialchars($_POST['password2'])) : '';
	
	// Check user already exists
	$stmt = $db->prepare('SELECT * FROM users WHERE email = ?');
	$stmt->bind_param('s', $email);	
	$stmt->execute();
	$stmt->store_result();
	
	$countUserRows = $stmt->num_rows();

	
	// Validate information
	if (!$fullName) {
		$errors[] = 'Full Name field was left empty.';
	}
	
	if (!$email) {
		$errors[] = 'Email field was left empty.';
	}
	else if ($countUserRows > 0) {
		$errors[] = 'Email already in use.';
	}
	
	if (!$password) {
		$errors[] = 'Password field was left empty.';
	}
	
	if (!$password2) {
		$errors[] = 'Confirm Password field was left empty.';
	}
	else if ($password != $password2) {
		$errors[] = 'Passwords do not match.';	
	}
	
	// All good? Process registration, else
	// display errors to use
	if (count($errors) < 1) {
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
		$created_at = date('Y-m-d H:i:s');
		
		$stmt = $db->prepare('INSERT INTO users (email, fullName, password, created_at) VALUES (?, ?, ?, ?)');
		$stmt->bind_param('ssss', $email, $fullName, $passwordHash, $created_at);
		$stmt->execute();
		$stmt->store_result();
		
		// Log in user straight away
		$_SESSION['userId'] = $stmt->insert_id;
		
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
				<a href="<?php echo $request->url('signin'); ?>">Already a member? Sign In.</a>
			</div>
			</form>
			
		</div>
		</div>
			
		</div>
	</div>
	
<?php include_once "_footer.php"; ?>
