<?php
// Replace these with your actual database credentials
// $host = 'localhost';
// $user = 'your_db_user';
// $pass = 'your_db_password';
// $dbname = 'your_db_name';

// $conn = new mysqli($host, $user, $pass, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $sql = "SELECT title, content FROM announcements ORDER BY id ASC";
// $result = $conn->query($sql);

// $announcements = [];
// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         $announcements[] = $row;
//     }
// }

// $conn->close();

// Temporary static data as fallback if DB is not used
$announcements = [
    ["title" => "Reminder: Exam Week!", "content" => "Exams start next Monday. Please check your schedule and arrive early."],
    ["title" => "School Fair This Friday", "content" => "Don’t miss the school fair! Booths, food, and games from 10am–4pm."],
    ["title" => "Library Renovation", "content" => "The library will be closed for renovation until next month. Visit the digital library instead."]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>School Announcements</title>
  <link rel="stylesheet" href="announcement2.css" />
  <style>
    #content-area {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      margin: 20px auto;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 1000px;
    }
    .announcement {
      background-color: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
      position: relative;
    }
    .announcement:hover {
      transform: scale(1.02);
    }
    .large {
      border-left: 5px solid #004080;
      font-size: 1.2em;
    }
    .small {
      font-size: 1em;
      flex: 1 1 300px;
    }
    .announcement-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
  </style>
</head>
<body>

<div id="content-area">
  <?php if (count($announcements) > 0): ?>
    <!-- First announcement -->
    <div class="announcement large">
      <h2><?= htmlspecialchars($announcements[0]['title']) ?></h2>
      <p><?= nl2br(htmlspecialchars($announcements[0]['content'])) ?></p>
    </div>

    <?php if (count($announcements) > 1): ?>
      <div class="announcement-row">
        <?php for ($i = 1; $i < count($announcements); $i++): ?>
          <div class="announcement small">
            <h3><?= htmlspecialchars($announcements[$i]['title']) ?></h3>
            <p><?= nl2br(htmlspecialchars($announcements[$i]['content'])) ?></p>
          </div>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</div>

</body>
</html>
