<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['Sesh'])){
	if ($_SESSION['acc_type']=='ADMIN'){
		header("Location: /yasaydps/admin/dashboard.php"); //Ibahin location path neto papuntang dashboard
		exit;
	} else if ($_SESSION['acc_type']=='TENANT'){
		header("Location: /yasaydps/tenant/dashboard.php"); //same dine
		exit;
	}
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
      <div class="container">
        <div class="box form-box" id='main-form'>
            <header>Login</header>
            <form action="" method="post" id='login'>
                <div class="field input">
                    <label for="username">Username</label>
                    <input 
					required
					minlength="1"
					
					type="quantity" 
					name="username" 
					id="username" 
					autocomplete="off"
					/>
					<span style="color: red;" class="error"></span>
					<span class="error-icon"></span>
					<span class="success-icon"></span>
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input 
					required
					minlength="1"
					
					type="password" 
					name="password"
					id="password" 
					autocomplete="off" 
					/>
					<span style="color: red;" class="error"></span>
					<span class="error-icon"></span>
					<span class="success-icon"></span>
                </div>
                <?php
				//session_start();
				include("database.php");

				session_regenerate_id();

				if ($_SERVER["REQUEST_METHOD"] == "POST") {
					// Close the database connection
					$username = $_POST["username"];
					$password = $_POST["password"];
					
					if ($username === "" or $password === ""){header("Location: /yasaydps/login.php");}
					// Prepare a parameterized query
					$stmt = $conn->prepare("SELECT * FROM accounts WHERE username =?");
					$stmt->bind_param("s", $username);
					$stmt->execute();
					$result = $stmt->get_result();
					$user_data = $result->fetch_assoc();
					
					$hashed_pass = password_hash($password, PASSWORD_DEFAULT); 
					// Check if there is a matching record
					if (isset($user_data) &&
						($user_data['username'] == $username 
							&& password_verify($user_data['password'], $hashed_pass))) {
							// Verify the password using a password hashing algorithm
							$_SESSION['Sesh'] = "IN_SESSION";
							$_SESSION['acc_type'] = $user_data['acc_type'];
							$_SESSION['username'] = $user_data['username'];
							if ($user_data['acc_type'] == "ADMIN"){
								header("Location: /yasaydps/admin/dashboard.php");
							}else {
								header("Location: /yasaydps/tenant/dashboard.php");
							}
							session_regenerate_id();
							exit;		 
					} else {
						$login_error = "<div class=\"message\"><p>WRONG USERNAME OR PASSWORD</p></div>";
						echo $login_error;
						$login_error = "";
					}
					$conn->close();
				}
				?>
                <div class="remember_me"> <!--REMEMBER ME!-->
                    <input type="checkbox" name="rememberMe_checkBox"/>
                    <label for="remember_me">Remember Me</label>
                </div>
                <div class="field"> <!--log in button-->
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div> 

            </form>
                <div class="forget_password"> <!--another form nare-->
                    <input type="submit" class="forgetPass_btn" name="forget_pass" value="Forget password">
                </div>
                <div class="sign_up"> <!--Another form narin to-->
                    <input type="submit" class="sign_up_btn" name="signUp" value="Sign up">
                </div>
        </div>
      </div>
</body>
</html>


