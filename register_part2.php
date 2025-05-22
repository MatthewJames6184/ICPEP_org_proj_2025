<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_POST['user_email']) && isset($_POST['user_password'])) {
        $_SESSION['user_email'] = $_POST['user_email'];
    } else {
        header("Location: register_part1.php");
        exit();
    }
    ?>
    <div class="container" id="user_additionalInfo">
        <h1 class="form-title">Student Information</h1>
        <form method="post" action="login.php">
            <div class="input-group">
                <input type="text" name="user_fname" id="user_fname" placeholder="Full Name" required />
            </div>
            <div class="input-group">
                <input type="quantity" name="user_studNo" id="user_studNo" placeholder="Student Number" required />
            </div>
            <div class="input-group">
                <input type="date" name="user_birthday" id="user_birthday" required>
            </div>
            <div class="input-group">
                <input type="text" name="user_yearlevel" id="user_yearLevel" placeholder="Year Level" required />
            </div>
            <div>
                <input type="text" name="user_address" id="user_address" placeholder="Address" requrired>
            </div>
            <input type="submit" class="submit_btn" id="submit_btn" value="Submit" />
            <a href="register_part1.php"><button type="button" name="back_btn" id="back_btn">back</button></a>
        </form>
    </div>
</body>

</html>