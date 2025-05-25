<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Store all registration fields in session
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_password'] = $_POST['user_password'];
    $_SESSION['user_fname'] = $_POST['user_fname'];
    $_SESSION['user_lname'] = $_POST['user_lname'];
    $_SESSION['user_studNo'] = $_POST['user_studNo'];
    $_SESSION['user_yearlevel'] = $_POST['user_yearlevel'];
    $_SESSION['user_section'] = $_POST['user_section'];

    // Redirect to OTP page
    header("Location: mailing/otp.php");
    exit();
}
?>