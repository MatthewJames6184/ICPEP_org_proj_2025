<?php
include 'database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user_email'];
    $password = md5($_SESSION['user_password']);
    $fullName = $_POST['user_fname'];
    $studNo = $_POST['user_studNo'];
    $birthday = date('Y-m-d', strtotime($_POST['user_birthday']));
    $yearLevel = $_POST['user_yearlevel'];
    $section = $_POST['user_section'];
    $address = $_POST['user_address'];

    $checkStudentNo = "SELECT * FROM user_account WHERE student_number = '$studNo'";
    $result = mysqli_query($conn, $checkStudentNo);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Student Number already exists!');</script>";
        echo "<script>window.location.href='register.php';</script>";
    } else {
        $query = "INSERT INTO user_account (student_number, birthday, email, password, full_name, year_level, section, address)
                  VALUES ('$studNo', '$birthday', '$email', '$password', '$fullName', '$yearLevel', '$section', '$address')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful!');</script>";
            header("Location: login.php");
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
