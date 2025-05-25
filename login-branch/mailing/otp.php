<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>OTP Verification</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            height: 100vh;
            background: linear-gradient(to bottom right, #0a1d57, #0b235c);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .otp-container {
            background-color: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .otp-container h2 {
            margin-bottom: 0.5rem;
            font-size: 24px;
        }

        .otp-container p {
            font-size: 14px;
            color: #555;
            margin-bottom: 1.5rem;
        }

        .otp-container input {
            width: 100%;
            padding: 0.75rem;
            font-size: 16px;
            border-radius: 30px;
            border: 1px solid #ccc;
            margin-bottom: 1.5rem;
        }

        .otp-container button {
            padding: 0.6rem 1.5rem;
            font-size: 15px;
            background-color: #f6b10e;
            color: #fff;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .otp-container button:hover {
            background-color: #e0a909;
        }

        #timerDisplay {
            margin-top: 10px;
            color: #333;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        @media (max-width: 500px) {
            .otp-container {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <form id="otpForm" autocomplete="off">
            <h2>Enter OTP</h2>
            <p>An OTP has been sent to your email. Please enter it below:</p>
            <input type="text" id="otpInput" name="otp" placeholder="Enter OTP" maxlength="6" required />
            <div>
                <button type="button" id="verifyOtpBtn">Verify OTP</button>
                <button type="button" id="resendOtpBtn" disabled>Resend OTP</button>
            </div>
            <div id="timerDisplay"></div>
            <div id="otpError" class="error"></div>
            <div id="otpSuccess" class="success"></div>
        </form>
    </div>

    <script>
        const userEmail = "<?php echo isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''; ?>";
        const otpExpiry = <?php echo isset($_SESSION['otp_expiry']) ? $_SESSION['otp_expiry'] : 'null'; ?>;
    </script>
    <script src="otp_verification.js"></script>
</body>

</html>