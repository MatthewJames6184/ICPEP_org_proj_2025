<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>

<body>
	<div class="container" id="signIn">
		<h1 class="form-title">Sign in</h1>
		<form method="post" action="">
			<div class="input-group">
				<label for="user_gmail">Email</label>
				<input type="text" name="user_email" id="user_email" placeholder="userAcc@gmail.com" required />
			</div>
			<div class="input-group">
				<label for="user_password">Password</label>
				<input type="password" name="user_password" id="user_password" placeholder="password" minlength="8" required>
			</div>
			<div class="link_recovery">
				<a href="recovery.php">Forgot password?</a> <!--recovery.php ala pa-->
			</div>
			<input type="submit" class="SignIn_btn" id="SignIn_btn" value="Sign in"/>
		</form>
		<p class="or_gmail">
			----or-----
			<br>
			<a href="">GOOGLE</a>
		</p>
		<p class="dont-have-account" >
			Don't have an account?
			<a href="register_part1.php"><button id="SignIn"> Sign In</button></a>
		</p>
	</div>

</body>
</html>