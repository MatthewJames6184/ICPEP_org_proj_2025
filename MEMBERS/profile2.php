
<?php
session_start(); // Always start the session


$db_server = "localhost";	
$db_user   = "u495515480_ICPEP_dbs";			
$db_pass   = "icpepElec_se#2025";			
$db_name   = "u495515480_icpep_web_dbms";

// Create connection
try {
    $conn = new mysqli($db_server, $db_user, $db_pass, $db_name);
    $conn->set_charset("utf8mb4"); // Optional: sets charset for security and compatibility
} catch (mysqli_sql_exception $e) {
    // Custom error message (better than just "Connection Unsuccessful")
    die("Database connection failed: " . $e->getMessage());
}

$studentNumber = $_SESSION['user_studNo'] ?? null;
if (!$studentNumber) {
    die("You are not logged in.");
}
// Fetch user data

$sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name, email, year_level, section, membership_status
        FROM user_account 
        WHERE student_number = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $studentNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $userData = $result->fetch_assoc();

    $name = $userData['full_name'];
    $email = $userData['email'];
    $yearLevel = $userData['year_level'];
    $section = $userData['section'];
    $MembershipStatus = $userData['membership_status'];
} else {
    // Default fallback values
    $name = "John Doe";
    $email = "jondoe@gmail.com";
    $yearLevel = "3rd Year";
    $profilePhoto = "default-avatar.png";
    $MembershipStatus = "Inactive";
    $joined = "May 2025";
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>User Profile</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      padding: 40px 20px;
      min-height: 100vh;
    background: #0e0837;
    background-size: 600% 600%;
    min-height: 100vh;
    display: block;
    place-items: center;
    overflow: auto;
    position: relative;
    }

    
.content {
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: relative;
    z-index: 1;
}

.content .quote {
    color: white;
    font-weight: bold;
    font-style: italic;
    font-size: 64px;
    padding: 10px;
    background-color: #101010;
    border-radius: 10px;
}

.content .by {
    color: #00e1ff;
}

.blob-outer-container {
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: -1;
    inset: 0;
    margin: auto;
    filter: blur(100px);
    /*opacity: 0.5;*/
}

.blob-inner-container {
    border-radius: 99999px;
    position: absolute;
    inset: 0;
    margin: auto;
    width: 100vw;
    height: 100vh;
    min-width: 1000px;
    overflow: hidden;
    background-color: #fff;
    transform: scale(0.8);
}

.blob {
    position: absolute;
    width: 100vw;
    height: 100vh;
    inset: 0;
    margin: auto;
    background: conic-gradient(from 0deg, #08f, rgb(16, 33, 74), #26f1ff, #4c00ff, #3e0d87, #09f);
    animation: spinBlob 8s linear infinite;
}

@keyframes spinBlob {
    0% {
        transform: rotate(0deg) scale(2);
    }

    100% {
        transform: rotate(1turn) scale(2);
    }
}



    .profile-container {
      background-color: white;
      padding: 40px 50px 50px 50px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
      min-width: 800px;
      width: 90vw;
      overflow-y: auto;
      max-height: 90vh;
      box-sizing: border-box;
      position: relative;
    }

    h2 {
      margin-top: 0;
      color: #004080;
      font-size: 38px;
      text-align: center;
      margin-bottom: 30px;
    }

    .profile-photo {
      display: block;
      width: 180px;
      height: 180px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #004080;
      margin: 0 auto 30px auto;
      background-color: #ddd;
    }

    .profile-info p {
      font-size: 22px;
      margin: 15px 0;
      border-bottom: 2px solid #ddd;
      padding-bottom: 12px;
      text-align: left;
      font-weight: 600;
    }

    .membership-status {
      font-weight: 700;
      margin: 30px 0 40px 0;
      text-align: center;
      font-size: 24px;
      color: #008000;
    }

    .membership-status.inactive {
      color: #cc0000;
    }

    .back-btn {
      position: absolute;
      top: 20px;
      right: 25px;
      background: none;
      border: none;
      color: #004080;
      font-size: 32px;
      cursor: pointer;
      font-weight: bold;
      line-height: 1;
      padding: 0;
    }

    .back-btn:hover {
      color: #002050;
    }

    form {
      margin-top: 30px;
      font-size: 20px;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 700;
      color: #004080;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    input[type="file"],
    select,
    textarea {
      width: 100%;
      padding: 12px 15px;
      font-size: 20px;
      margin-bottom: 25px;
      border: 2px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      transition: border-color 0.3s ease;
      font-family: Arial, sans-serif;
      resize: vertical;
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus,
    select:focus,
    textarea:focus {
      border-color: #004080;
      outline: none;
    }

    input[type="submit"],
    button[type="submit"] {
      background-color: #004080;
      border: none;
      padding: 15px 30px;
      color: white;
      font-weight: 700;
      font-size: 22px;
      cursor: pointer;
      border-radius: 10px;
      margin-top: 10px;
      width: 100%;
      box-sizing: border-box;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover,
    button[type="submit"]:hover {
      background-color: #002050;
    }

    .logout-bottom {
      margin-top: 40px;
    }

    hr {
      margin: 50px 0;
      border: none;
      border-top: 2px solid #eee;
    }
  </style>
</head>
<body>

  <div class="profile-container">
    <h2>User Profile</h2>
    <img src="sadwolf.jpg" alt="Profile Photo"
      class="profile-photo" id="profilePhoto"
    />
    <div class="profile-info">
      <p><strong>Name:</strong> <?php echo htmlspecialchars($name ?? 'John Doe'); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($email ?? 'jondoe@gmail.com'); ?></p>
      <p><strong>Year Level:</strong> <?php echo htmlspecialchars($yearLevel ?? '3rd Year'); ?></p>
      <p><strong>Section:</strong> <?php echo htmlspecialchars($section ?? 'A'); ?></p>
      <p><strong>Joined: </strong>May 2025</p>

    </div>

    <?php 
      $isActive = isset($MembershipStatus) && strtolower($MembershipStatus) === 'active';
    ?>
    <p class="membership-status <?php echo $isActive ? '' : 'inactive'; ?>">
      Membership Status: <?php echo htmlspecialchars($MembershipStatus ?? 'Inactive'); ?>
    </p>

    <!-- Logout Button at the Bottom -->
    <div class="logout-bottom">
      <form action="/login-branch/logout.php" method="POST">
        <input type="submit" value="Logout" />
      </form>
    </div>

  </div>

</body>
</html>
