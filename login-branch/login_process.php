<?php
// filepath: c:\xampp\htdocs\ICPEP_org_website\login_process.php
include 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studNo = $_POST['user_studNo'];
    $password = $_POST['user_password'];

    $stmt = $conn->prepare("SELECT * FROM user_account WHERE student_number = ?");
    $stmt->bind_param("s", $studNo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_studNo'] = $row['student_number'];
            $_SESSION['user_type'] = $row['user_type']; // Save user_type in session

            // Redirect based on user_type
            if (isset($row['user_type']) && strtolower(trim($row['user_type'])) === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard_dummy.php");
            }
            exit();
        } else {
            header("Location: login.php?error=incorrect_password");
            exit();
        }
    } else {
        header("Location: login.php?error=not_found");
        exit();
    }
}