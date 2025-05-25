document.addEventListener("DOMContentLoaded", async () => {
    const otpInput = document.getElementById('otpInput');
    const verifyBtn = document.getElementById('verifyOtpBtn');
    const resendBtn = document.getElementById('resendOtpBtn');
    const otpError = document.getElementById('otpError');
    const otpSuccess = document.getElementById('otpSuccess');
    const timerDisplay = document.getElementById('timerDisplay');

    // Helper to format seconds as mm:ss
    function formatTime(secs) {
        const m = Math.floor(secs / 60).toString().padStart(2, '0');
        const s = (secs % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    }

    // Send OTP as soon as the page loads
    if (typeof userEmail !== "undefined" && userEmail) {
        await fetch('send_otp.php');
    }

    // Get expiry from PHP session (set in otp.php)
    let now = Math.floor(Date.now() / 1000);
    let resendAllowedAt = typeof otpExpiry !== "undefined" && otpExpiry
        ? (parseInt(otpExpiry) + 120)
        : (now + 120);
    let interval;

    function updateTimer() {
        now = Math.floor(Date.now() / 1000);
        let secondsLeft = resendAllowedAt - now;
        if (secondsLeft > 0) {
            timerDisplay.textContent = `Resend OTP available in: ${formatTime(secondsLeft)}`;
            resendBtn.disabled = true;
        } else {
            timerDisplay.textContent = "You can now resend the OTP.";
            resendBtn.disabled = false;
            clearInterval(interval);
        }
    }

    // Start timer if needed
    updateTimer();
    interval = setInterval(updateTimer, 1000);

    verifyBtn.addEventListener('click', async () => {
        otpError.textContent = '';
        otpSuccess.textContent = '';
        const otp = otpInput.value.trim();
        if (!otp) {
            otpError.textContent = 'Please enter the OTP.';
            return;
        }
        const res = await fetch('verify_otp.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ otp })
        });
        const data = await res.json();
        if (data.verified) {
            otpSuccess.textContent = 'OTP verified! Redirecting...';
            setTimeout(() => {
                window.location.href = '../dashboard_dummy.php';
            }, 1500);
        } else {
            otpError.textContent = data.error || 'Invalid OTP.';
        }
    });

    resendBtn.addEventListener('click', async () => {
        otpError.textContent = '';
        otpSuccess.textContent = '';
        resendBtn.disabled = true;
        timerDisplay.textContent = "Sending new OTP...";

        const res = await fetch('send_otp.php');
        const data = await res.json();

        if (data.success) {
            otpSuccess.textContent = 'OTP resent!';
            // Use new expiry from server
            let newExpiry = data.otp_expiry ? parseInt(data.otp_expiry) : Math.floor(Date.now() / 1000) + 300;
            resendAllowedAt = newExpiry + 120;
            clearInterval(interval);
            updateTimer();
            interval = setInterval(updateTimer, 1000);
        } else {
            otpError.textContent = data.error || 'Failed to resend OTP.';
            resendBtn.disabled = false;
        }
    });
});