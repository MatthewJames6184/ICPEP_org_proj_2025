document.addEventListener("DOMContentLoaded", async () => {
  const otpInput = document.getElementById('otpInput');
  const verifyBtn = document.getElementById('verifyOtpBtn');
  const resendBtn = document.getElementById('resendOtpBtn');
  const otpError = document.getElementById('otpError');
  const otpSuccess = document.getElementById('otpSuccess');

  // Send OTP as soon as the page loads
  if (typeof userEmail !== "undefined" && userEmail) {
    await fetch('send_otp.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: userEmail })
    });
  }

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
      body: JSON.stringify({ otp: otp })
    });
    const data = await res.json();
    if (data.verified) {
      otpSuccess.textContent = 'OTP verified! Redirecting...';
      setTimeout(() => {
        window.location.href = '../dashboard_dummy.php';
      }, 1500);
    } else {
      otpError.textContent = data.error || 'Invalid OTP. Please try again.';
    }
  });

  resendBtn.addEventListener('click', async () => {
    otpError.textContent = '';
    otpSuccess.textContent = '';
    const res = await fetch('send_otp.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: userEmail })
    });
    const data = await res.json();
    if (data.success) {
      otpSuccess.textContent = 'OTP resent to your email.';
    } else {
      otpError.textContent = data.error || 'Failed to resend OTP.';
    }
  });
});