<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create an Account</title>
    <link rel="stylesheet" href="sign.css">
</head>
<body>
    <div class="signup-container">
        <h2>Create an Account</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>

            <!-- Password is visible -->
            <input type="text" name="password" placeholder="Password" required>

            <!-- Confirm Password is hidden -->
            <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>

            <!-- Show password checkbox -->
            <label class="show-password">
                <input type="checkbox" id="showConfirmPassword" onchange="toggleConfirmPassword()">
                Show Password
            </label>

            <div class="buttons">
                <button type="submit" class="signup-btn">Sign Up</button>
                <a href="login.php" class="back-btn">
                    <img src="b1.png" alt="Back" class="back-img">
                </a>
            </div>
        </form>
    </div>

    <script>
        function toggleConfirmPassword() {
            const confirmPasswordInput = document.getElementById("confirm_password");
            confirmPasswordInput.type = confirmPasswordInput.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
