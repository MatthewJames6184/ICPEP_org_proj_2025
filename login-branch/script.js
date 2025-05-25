function togglePassword() {
  const passwordInput = document.getElementById("password");
  const checkbox = document.getElementById("showPasswordCheckbox");
  passwordInput.type = checkbox.checked ? "text" : "password";
}
