<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Register</title>
	<link rel="stylesheet" href="style.css" />
</head>

<body>
	<form id="registerForm" method="post" action="register_session.php">
		<!-- Step 1 -->
		<div id="step1">
			<h2>Step 1: Account Info</h2>
			<div class="input-group">
				<label>Email:</label>
				<input type="email" id="user_email" name="user_email" required />
				<div class="error" id="emailError"></div>
			</div>
			<div class="input-group">
				<label>Password:</label>
				<input type="password" id="user_password" name="user_password" required />
				<div class="error" id="passwordError"></div>
			</div>
			<div class="input-group">
				<label>Confirm Password:</label>
				<input type="password" id="user_confirmPassword" name="user_confirmPassword" required />
				<div class="error" id="confirmPasswordError"></div>
			</div>
			<button type="button" id="nextBtn">Next</button>
		</div>

		<!-- Step 2 -->
		<div id="step2" class="hidden">
			<h2>Step 2: Student Info</h2>
			<div class="input-group">
				<input type="text" name="user_fname" id="user_fname" placeholder="Full Name" required />
			</div>
			<div class="input-group">
				<input type="text" name="user_studNo" id="user_studNo" placeholder="Student Number" required />
				<div class="error" id="studNoError"></div>
			</div>
			<div class="input-group">
				<input type="date" name="user_birthday" id="user_birthday" required />
			</div>
			<div class="input-group">
				<label for="user_yearLevel">Year Level:</label>
				<select name="user_yearlevel" id="user_yearLevel" required>
					<option value="">-- Select Year Level --</option>
					<option value="1st Year">1st Year</option>
					<option value="2nd Year">2nd Year</option>
					<option value="3rd Year">3rd Year</option>
					<option value="4th Year">4th Year</option>
				</select>
			</div>
			<div class="input-group">
				<label for="user_section">Section:</label>
				<select name="user_section" id="user_section" required>
					<option value="">-- Select Section --</option>
					<option value="CpE-3A">CpE-3A</option>
					<option value="CpE-3B">CpE-3B</option>
					<option value="CpE-3C">CpE-3C</option>
					<option value="CpE-3D">CpE-3D</option>
				</select>
			</div>
			<div class="input-group">
				<input type="text" name="user_address" id="user_address" placeholder="Address" required />
			</div>
			<button type="button" id="backBtn">Back</button>
			<button type="submit">Submit</button>
		</div>
	</form>
	<div class="already-have-account">
		<a href="login.php" id="SignIn">Already have an account?</a>

	</div>
	<script src="validation.js"></script>
</body>

</html>