<?php
// filepath: c:\xampp\htdocs\ICPEP_org_website\mailing\verify_otp.php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../database.php';

$data = json_decode(file_get_contents('php://input'), true);
$otp = $data['otp'] ?? '';

if (!isset($_SESSION['otp'], $_SESSION['otp_expiry'])) {
    echo json_encode(['verified' => false, 'error' => 'No OTP requested.']);
    exit;
}

if (time() > $_SESSION['otp_expiry']) {
    unset($_SESSION['otp'], $_SESSION['otp_expiry']);
    echo json_encode(['verified' => false, 'error' => 'OTP expired.']);
    exit;
}

if ($otp == $_SESSION['otp']) {
    // Insert registration data into database
    $email = $_SESSION['user_email'];
    $password = password_hash($_SESSION['user_password'], PASSWORD_DEFAULT);
    $firstName = $_SESSION['user_fname'];
    $lastName = $_SESSION['user_lname'];
    $studNo = $_SESSION['user_studNo'];
    $yearLevel = $_SESSION['user_yearlevel'];
    $section = $_SESSION['user_section'];

    // Check if student number already exists
    $stmt = $conn->prepare("SELECT student_number FROM user_account WHERE student_number = ?");
    $stmt->bind_param("s", $studNo);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['verified' => false, 'error' => 'Student number already exists.']);
        exit;
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO user_account (student_number, email, password, first_name, last_name, year_level, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $studNo,  $email, $password, $firstName, $lastName, $yearLevel, $section);
    if ($stmt->execute()) {
        unset($_SESSION['otp'], $_SESSION['otp_expiry']);
        echo json_encode(['verified' => true]);
    } else {
        echo json_encode(['verified' => false, 'error' => 'Database error.']);
    }
    $stmt->close();
} else {
    echo json_encode(['verified' => false, 'error' => 'Invalid OTP.']);
}
