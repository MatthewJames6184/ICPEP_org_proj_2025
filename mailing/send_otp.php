<?php
session_start();
header('Content-Type: application/json');



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Ensure you have PHPMailer installed via Composer

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['user_email'] ?? '';

if (!$email) {
    echo json_encode(['success' => false, 'error' => 'No email provided.']);
    exit;
}

$otp = rand(100000, 999999);
$_SESSION['otp'] = $otp;
$_SESSION['otp_expiry'] = time() + 300; // 5 minutes

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'arias.james18@gmail.com'; // Your email
    $mail->Password   = 'outt nigv gwka nrgp';    // Your app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('arias.james18@gmail.com', 'ICPEP Registration');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Your OTP Code';
    $mail->Body    = "Your OTP code is: <b>$otp</b>";

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $mail->ErrorInfo]);
}
?>