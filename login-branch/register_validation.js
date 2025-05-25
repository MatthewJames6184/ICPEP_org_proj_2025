document.addEventListener("DOMContentLoaded", () => {
  // Set input 'required' attributes initially
  document.querySelectorAll('#step1 input').forEach(input => input.required = false);
  document.querySelectorAll('#step2 input, #step2 select').forEach(input => input.required = true);

  const nextBtn = document.getElementById("nextBtn");
  const backBtn = document.getElementById("backBtn");
  const form = document.getElementById("registerForm");
  const studNoError = document.getElementById("studNoError");
  const passwordError = document.getElementById("passwordError");
  const confirmPasswordError = document.getElementById("confirmPasswordError");
  const emailError = document.getElementById("emailError");
  const fnameError = document.getElementById("fnameError");
  const lnameError = document.getElementById("lnameError");

  nextBtn.addEventListener("click", (e) => {
    const email = get("user_email").value.trim();
    const password = get("user_password").value.trim();
    const confirmPassword = get("user_confirmPassword").value.trim();
    passwordError.textContent = "";
    confirmPasswordError.textContent = "";
    emailError.textContent = "";

    reset(["user_email", "user_password", "user_confirmPassword"]);
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
    } else if (!confirmPasswordValid) {
      mark("user_confirmPassword");
      confirmPasswordError.textContent = "Passwords do not match.";
      errors.push("Passwords do not match.");
    }

    if (errors.length > 0) {
      e.preventDefault();
    } else {
      document.getElementById("step1").classList.add("hidden");
      document.getElementById("step2").classList.remove("hidden");
    }
  });

  backBtn.addEventListener("click", () => {
    document.getElementById("step2").classList.add("hidden");
    document.getElementById("step1").classList.remove("hidden");
  });

  form.addEventListener("submit", async (e) => {
    if (document.getElementById("step2").classList.contains("hidden")) return;
    e.preventDefault(); // stop form submission until we check

    studNoError.textContent = "";
    fnameError.textContent = "";
    lnameError.textContent = "";

    const studentNo = get("user_studNo").value.trim();
    const firstName = get("user_fname").value.trim();
    const lastName = get("user_lname").value.trim();

    const errors = [];

    reset(["user_studNo", "user_fname", "user_lname"]);

    const studNoValid = /^20\d{8}$/.test(studentNo);
    const firstNameValid = /^[A-Za-z]+([-' ][A-Za-z]+)*$/.test(firstName);
    const lastNameValid = /^[A-Za-z]+([-' ][A-Za-z]+)*$/.test(lastName);

    if (!studNoValid) {
      mark("user_studNo");
      studNoError.textContent = "Invalid Student Number.";
      errors.push("Invalid Student Number.");
    }

    if (!firstNameValid) {
      mark("user_fname");
      fnameError.textContent = "Invalid First name.";
      errors.push("Invalid First name.");
    }

    if (!lastNameValid) {
      mark("user_lname");
      lnameError.textContent = "Invalid Last name.";
      errors.push("Invalid Last name.");
    }

    // Inline check if student number already exists
    if (studNoValid) {
      const exists = await checkStudentNumber(studentNo);
      if (exists) {
        mark("user_studNo");
        studNoError.textContent = "Student number already exists.";
        e.preventDefault();
        errors.push("Student number already exists.");
      }
    }

    if (errors.length === 0) {
      form.submit(); // everything is valid — now submit
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

  // AJAX: Check if student number exists
  async function checkStudentNumber(studNo) {
    try {
      const res = await fetch('check_student_no.php?studNo=' + encodeURIComponent(studNo));
      const data = await res.json();
      return data.exists;
    } catch {
      return false;
    }
  }
});
