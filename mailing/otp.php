<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="input-otp-group">
        <form id="otpForm" autocomplete="off" onsubmit="return false;" method="post" action="send_otp.php">
            <div id="otpModal">
                <h2>Enter OTP</h2>
                <p>An OTP has been sent to your email. Please enter it below:</p>
                <input type="text" id="otpInput" placeholder="Enter OTP" maxlength="6" />
                <button type="button" id="verifyOtpBtn">Verify OTP</button>
                <button type="button" id="resendOtpBtn" disabled>Resend OTP</button>
                <div id="timerDisplay" style="margin-top:10px; color:#333;"></div>
                <div id="otpError" class="error"></div>
                <div id="otpSuccess" class="success"></div>
            </div>
        </form>
    </div>

    <script>
        // Pass the email from session to JS
        const userEmail = "<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>";
        // Pass the OTP expiry from session to JS (if set)
        const otpExpiry = <?php echo isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] : 'null'; ?>;
    </script>
    <script src="otp_verification.js"></script>
</body>
</html>