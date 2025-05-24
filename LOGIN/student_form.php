<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Information</title>
  <link rel="stylesheet" href="student_form.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <div class="form-container">
    <h2>Student Information</h2><br>
    <form action="submit_student.php" method="post">

      <div class="row">
        <input type="text" name="first_name" placeholder="First Name" required>
        <input type="text" name="last_name" placeholder="Last Name" required>
      </div>

      <div class="row">
        <input type="text" name="student_number" placeholder="Student Number" required>
      </div>

      <input type="date" name="dob" required>

      <div class="row">
        <select name="sex" required>
          <option value="" disabled selected>Select Sex</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>

        <select name="year_level" required>
          <option value="" disabled selected>Select Year Level</option>
          <option value="1st Year">1st Year</option>
          <option value="2nd Year">2nd Year</option>
          <option value="3rd Year">3rd Year</option>
          <option value="4th Year">4th Year</option>
        </select>
      </div>

      <select name="section" required>
        <option value="" disabled selected>Select Section</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>

      <input type="text" name="address" placeholder="Address" required>

      <div class="buttons">
        <button type="submit" class="submit-btn">Submit</button>
        <a href="index.php" class="back-btn">Back</a>
      </div>

    </form>
  </div>
</body>
</html>
