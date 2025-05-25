<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>Login</title>
</head>

<body>
	<div class="container" id="signIn_form">
		<h1 class="form-title">Sign in</h1>
		<?php if (isset($_GET['error'])): ?>
			<div class="error">
				<?php
				if ($_GET['error'] === 'incorrect_password') echo "Incorrect password. Please try again.";
				if ($_GET['error'] === 'not_found') echo "Student number not found. Please register.";
				?>
			</div>
		<?php endif; ?>

		<form method="post" action="login_process.php">
			<div class="input-group">
				<label for="user_studNo">Username</label>
				<input type="text" name="user_studNo" id="user_studNo" placeholder="Student Number" autocomplete="off" required/>
				<div class="error" id="studNoError"></div>
			</div>
			
			<div class="input-group">
				<label for="user_password">Password</label>
				<input type="password" name="user_password" id="user_password" placeholder="password" minlength="8" required>
				<br>
				<label><input type="checkbox" id="togglePassword"> Show Password</label>
				<div class="error" id="passwordError"></div>
			</div>
			
			
			<input type="submit" class="SignIn_btn" id="SignIn_btn" value="Sign in" />
		</form>

		<p class="dont-have-account">
			<a href="register.php" id="Sign Up">Create an account</a>
		</p>
	</div>
	<script src="login_validation.js"></script>
</body>

</html>