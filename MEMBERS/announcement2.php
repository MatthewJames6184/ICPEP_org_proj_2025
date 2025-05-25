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
    ["title" => "Reminder: OJT PAPERS!", "content" => "Internships are coming for 3rd Years! Get ready and do your best."],
    ["title" => "FINALS WEEK DONE!", "content" => "Manifesting good grades for everyone! <3"],
    ["title" => "World Champions", "content" => "𝗙𝗥𝗢𝗠 𝗕𝗨𝗟𝗦𝗨 𝗧𝗢 𝗧𝗛𝗘 𝗪𝗢𝗥𝗟𝗗, 𝗧𝗘𝗔𝗠 𝗭-𝗠𝗘𝗡 𝗛𝗔𝗩𝗘 𝗠𝗔𝗗𝗘 𝗛𝗜𝗦𝗧𝗢𝗥𝗬!🌍🏆
After claiming 3rd Prize in the Asia Pacific Regionals in Kuala Lumpur, our very own BulSU Computer Engineering Delegates have soared to the top, bringing home the 𝗚𝗥𝗔𝗡𝗗 𝗣𝗥𝗜𝗭𝗘 at the 𝟵𝘁𝗵 𝗛𝘂𝗮𝘄𝗲𝗶 𝗜𝗖𝗧 𝗖𝗼𝗺𝗽𝗲𝘁𝗶𝘁𝗶𝗼𝗻 𝗚𝗹𝗼𝗯𝗮𝗹 𝗙𝗶𝗻𝗮𝗹 – 𝗜𝗻𝗻𝗼𝘃𝗮𝘁𝗶𝗼𝗻 𝗧𝗿𝗮𝗰𝗸, held on 𝗠𝗮𝘆 𝟮𝟰, 𝟮𝟬𝟮𝟱 in 𝗦𝗵𝗲𝗻𝘇𝗵𝗲𝗻, 𝗖𝗵𝗶𝗻𝗮! 
Introducing your 𝗪𝗢𝗥𝗟𝗗 𝗖𝗛𝗔𝗠𝗣𝗜𝗢𝗡𝗦:
🔹 Ian Kenneth Agustin
🔹 Aaron Gabriel Ersando
🔹 John Orrin Acuyong
𝗖𝗼𝗮𝗰𝗵: Engr. Alberto C. Cruz Jr."],
    ["title" => "CpE Night Done!", "content" => "Thank you to everyone who believed in the magic, dressed the part, and made memories that will live happily ever after in our hearts. Whether you danced under the lights or laughed with friends, your story became part of ours."]
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
      background-color:rgb(170, 212, 254);
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
