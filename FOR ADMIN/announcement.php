<?php
session_start();

// Initialize announcements array if not set
if (!isset($_SESSION['announcements'])) {
    $_SESSION['announcements'] = [
        ["title" => "Reminder: Exam Week!", "content" => "Exams start next Monday. Please check your schedule and arrive early."],
        ["title" => "School Fair This Friday", "content" => "Don’t miss the school fair! Booths, food, and games from 10am–4pm."],
        ["title" => "Library Renovation", "content" => "The library will be closed for renovation until next month. Visit the digital library instead."]
    ];
}

// On form submit, add new announcement at the end of array
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newTitle = trim($_POST['title'] ?? '');
    $newContent = trim($_POST['content'] ?? '');

    if ($newTitle !== '' && $newContent !== '') {
        // Add new announcement to the END (to add boxes below existing)
        $_SESSION['announcements'][] = [
            "title" => $newTitle,
            "content" => $newContent
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>School Announcements</title>
  <link rel="stylesheet" href="announcement.css" />
  <style>
    /* Minimal inline styling, you can keep your announcement.css */
    #content-area {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      margin: 20px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 1000px;
      margin-left: auto;
      margin-right: auto;
    }
    .announcement {
      background-color: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
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
    }
    .announcement-row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }
    /* Form styling */
    .announcement-form {
      margin-top: 30px;
      padding: 15px;
      background: #f9f9f9;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }
    .announcement-form h3 {
      margin-top: 0;
      color: #004080;
    }
    .announcement-form input[type="text"],
    .announcement-form textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      box-sizing: border-box;
      font-size: 16px;
      font-family: Arial, sans-serif;
    }
    .announcement-form button {
      background-color: #004080;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }
    .announcement-form button:hover {
      background-color: #0066cc;
    }
  </style>
</head>
<body>

<div id="content-area">
  <?php
  // Show announcements:
  // First announcement is large and full width,
  // others are inside a flex row with small boxes.
  if (count($_SESSION['announcements']) > 0) {
      // Show first announcement large:
      $first = $_SESSION['announcements'][0];
      echo "<div class='announcement large'>";
      echo "<h2>" . htmlspecialchars($first['title']) . "</h2>";
      echo "<p>" . nl2br(htmlspecialchars($first['content'])) . "</p>";
      echo "</div>";

      // Show others in a flex container as small announcements
      if (count($_SESSION['announcements']) > 1) {
          echo "<div class='announcement-row'>";
          for ($i = 1; $i < count($_SESSION['announcements']); $i++) {
              $ann = $_SESSION['announcements'][$i];
              echo "<div class='announcement small'>";
              echo "<h3>" . htmlspecialchars($ann['title']) . "</h3>";
              echo "<p>" . nl2br(htmlspecialchars($ann['content'])) . "</p>";
              echo "</div>";
          }
          echo "</div>";
      }
  }
  ?>

  <!-- Form to add new announcement -->
  <form class="announcement-form" method="POST" action="">
    <h3>Add a New Announcement</h3>
    <input type="text" name="title" placeholder="Announcement title..." required>
    <textarea name="content" rows="3" placeholder="Announcement details..." required></textarea>
    <button type="submit">Add Announcement</button>
  </form>
</div>

</body>
</html>
