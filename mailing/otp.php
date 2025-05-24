
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="input-otp-group">
        <form id="otpForm" autocomplete="off" onsubmit="return false;">
            <div id="otpModal">
                <h2>Enter OTP</h2>
                <p>An OTP has been sent to your email. Please enter it below:</p>
                <input type="text" id="otpInput" placeholder="Enter OTP" maxlength="6" />
                <button type="button" id="verifyOtpBtn">Verify OTP</button>
                <button type="button" id="resendOtpBtn">Resend OTP</button>
                <div id="otpError" class="error"></div>
                <div id="otpSuccess" class="success"></div>
            </div>
        </form>
    </div>
    <script>
        // Pass the email from session to JS
        const userEmail = "<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>";
    </script>
    <script src="otp_verification.js"></script>
</body>

</html>