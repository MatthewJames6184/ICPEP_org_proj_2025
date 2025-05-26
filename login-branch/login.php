<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="stylesheet" href="style.css" />
	<link rel="icon" href="/images/logo.png">
	<title>Login</title>
	<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
		integrity="sha512-vN6EppN8xv7E3nZbU9ErvAFNZRZ0dWq+xLSfwD7vGm4fU5+AvZCd/91d6i8r84kVcnpJbM3WJPBbhvZ4zC4U8g=="
		crossorigin="anonymous"
		referrerpolicy="no-referrer" />
</head>

<body>

	<div class="container multi-class-layout">
		<div class="form-container">
			<a href="/index.html" class="close-button" title="Close">&times;</a>
			<div class="profile-container"></div>

			<!-- Error Messages -->
			<?php if (isset($_GET['error'])): ?>
				<div class="error">
					<?php
					if ($_GET['error'] === 'incorrect_password') echo "Incorrect password. Please try again.";
					if ($_GET['error'] === 'not_found') echo "Student number not found. Please register.";
					?>
				</div>
			<?php endif; ?>

			<form action="login_process.php" method="POST">
				<img src="LOGO.png" alt="Logo" style="display:block; margin: 0 auto 15px auto; width: 80px; height: auto;" />

				<input
					type="text"
					name="user_studNo"
					placeholder="Student Number"
					autocomplete="off"
					required />

				<div class="password-wrapper">
					<input
						type="password"
						name="user_password"
						id="password"
						placeholder="Password"
						minlength="8"
						required />
				</div>

				<label class="show-password" for="showPasswordCheckbox">
					<input
						type="checkbox"
						id="showPasswordCheckbox"
						onchange="togglePassword()" />
					Show Password
				</label>

				<button type="submit">Login</button>

				<div class="form-links">
					<a href="register.php">Create an Account</a>
				</div>
			</form>
		</div>

		<!-- Info Panel -->
		<div class="info-container">
			<h1>What’s up, Lycan?</h1>
			<p>
				Welcome to the official page of ICpEP.SE BulSU, the student chapter of the
				Institute of Computer Engineers of the Philippines at Bulacan State University.
				We aim to empower future computer engineers through academic excellence, technical training, and collaborative activities.
			</p>
		</div>
	</div>

	<script>
		function togglePassword() {
			const passwordInput = document.getElementById("password");
			const checkbox = document.getElementById("showPasswordCheckbox");
			passwordInput.type = checkbox.checked ? "text" : "password";
		}
	</script>
</body>

</html>