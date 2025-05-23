<?php
// Updated login_process.php with password_verify() and improved feedback
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
            header("Location: dashboard_dummy.php");
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
?>
