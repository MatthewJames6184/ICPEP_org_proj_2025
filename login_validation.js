document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.querySelector("form");
  const studNoInput = document.getElementById("user_studNo");
  const passwordInput = document.getElementById("user_password");
  const studNoError = document.getElementById("studNoError");
  const passwordError = document.getElementById("passwordError");

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      let valid = true;
      studNoError.textContent = "";
      passwordError.textContent = "";

      if (!/^20\d{8}$/.test(studNoInput.value.trim())) {
        studNoError.textContent = "Student number must be 10 digits starting with 20.";
        valid = false;
      }

      if (passwordInput.value.length < 8) {
        passwordError.textContent = "Password must be at least 8 characters.";
        valid = false;
      }

      if (!valid) {
        e.preventDefault(); // Stop form submission
      }
    });
  }
});
