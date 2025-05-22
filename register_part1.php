<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Register & Login</title>
</head>

<body>
	<div class="container" id="signUp">
		<h1 class="form-title">Register</h1>
		<form method="post" action="register_part2.php">
			<div class="input-group">
				<label for="user_gmail">Email</label>
				<input type="text" name="user_email" id="user_email" placeholder="userAcc@gmail.com" required />
			</div>
			<div class="input-group">
				<label for="user_password">Password</label>
				<input type="password" name="user_password" id="user_password" placeholder="password" minlength="8" required>
			</div>
			<input type="submit" class="next_btn" id="next_btn" value="next"/>
			
		</form>
		<p class="or_gmail">
			----or-----
			<br>
			<a href="">GOOGLE</a>
		</p>
		<p class="already-account">
			Already have an account? <a href="login.php">Sign in</a>
		</p>
	</div>
	<script src="register.js"></script>
</body>

</html>