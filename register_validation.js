document.addEventListener("DOMContentLoaded", () => {
  const nextBtn = document.getElementById("nextBtn");
  const backBtn = document.getElementById("backBtn");
  const form = document.getElementById("registerForm");
  const studNoError = document.getElementById("studNoError");
  const passwordError = document.getElementById("passwordError");
  const confirmPasswordError = document.getElementById("confirmPasswordError");
  const emailError = document.getElementById("emailError");

  nextBtn.addEventListener("click", () => {
    const email = get("user_email").value.trim();
    const password = get("user_password").value.trim();
    const confirmPassword = get("user_confirmPassword").value.trim();
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";
    emailError.textContent = "";
    reset(["user_email", "user_password"]);
    const errors = [];

    const emailValid = /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email);
    const passwordValid = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*]).{8,}$/.test(password);
    const confirmPasswordValid = password === confirmPassword;



    if (!emailValid) {
      mark("user_email");

      errors.push("Enter a valid email.");
      emailError.textContent = "Enter a valid email.";

    }

    if (!passwordValid) {
      mark("user_password");
      passwordError.textContent = "Password must be 8+ chars, with uppercase, number, and special character.";
      errors.push("Password must be 8+ chars, with uppercase, number, and special character.");

    }
    else if (passwordValid) {
      if (!confirmPasswordValid) {
        mark("user_confirmPassword");
        confirmPasswordError.textContent = "Passwords do not match.";
        errors.push("Passwords do not match.");

      }
    }


    if (errors.length > 0) {
      e.preventDefault();
      errors.join("\n");
    } else {
      document.getElementById("step1").classList.add("hidden");
      document.getElementById("step2").classList.remove("hidden");
    }
  });

  backBtn.addEventListener("click", () => {
    document.getElementById("step2").classList.add("hidden");
    document.getElementById("step1").classList.remove("hidden");
  });

  form.addEventListener("submit", (e) => {
    if (document.getElementById("step2").classList.contains("hidden")) return;
    studNoError.textContent = "";
    const errors = [];
    const studentNo = get("user_studNo").value.trim();
    const fullName = get("user_fname").value.trim();

    reset(["user_studNo", "user_fname", "user_yearLevel", "user_section"]);

    if (!/^20\d{8}$/.test(studentNo)) {
      mark("user_studNo");
      errors.push("Student number must be 10 digits starting with 20.");
    }

    if (!/^[A-Za-z\s.]+$/.test(fullName)) {
      mark("user_fname");
      errors.push("Full name can only include letters, spaces, and periods.");
    }

    if (errors.length > 0) {
      e.preventDefault();
      errors.join("\n")
      studNoError.textContent = "Student number must be 10 digits starting with 20.";

    }
  });

  function get(id) {
    return document.getElementById(id);
  }

  function mark(id) {
    get(id).classList.add("invalid");
  }

  function reset(ids) {
    ids.forEach(id => get(id).classList.remove("invalid"));
  }
});
