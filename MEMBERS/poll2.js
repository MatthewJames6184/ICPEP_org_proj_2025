<?php
session_start();

// Database connection - replace with your actual credentials
$servername = "localhost";
$username = "your_db_user";
$password = "your_db_password";
$dbname = "your_db_name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$poll_id = 1; // assuming single poll for simplicity

// Handle vote submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_option'])) {
    $vote_option = $_POST['vote_option'];

    // Prevent multiple voting by same user (simple session check)
    if (!isset($_SESSION['voted_poll_' . $poll_id])) {
        // Increment the vote count in DB
        $stmt = $conn->prepare("UPDATE poll_votes SET votes = votes + 1 WHERE poll_id = ? AND option_name = ?");
        $stmt->bind_param("is", $poll_id, $vote_option);
        $stmt->execute();
        $stmt->close();

        $_SESSION['voted_poll_' . $poll_id] = true; // mark voted
    }
    // Redirect to avoid resubmission on refresh
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Fetch current vote counts from DB
$sql = "SELECT option_name, votes FROM poll_votes WHERE poll_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $poll_id);
$stmt->execute();
$result = $stmt->get_result();

$votes = [];
$total_votes = 0;
while ($row = $result->fetch_assoc()) {
    $votes[$row['option_name']] = (int)$row['votes'];
    $total_votes += (int)$row['votes'];
}
$stmt->close();

function percent($count, $total) {
    if ($total === 0) return 0;
    return round(($count / $total) * 100, 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Poll</title>
  <link rel="stylesheet" href="poll2.css" />
</head>
<body>
  <div class="container">
    <h1>Do you like this poll system?</h1>

    <?php if (isset($_SESSION['voted_poll_' . $poll_id])): ?>
      <p class="voted-msg">Thank you for voting!</p>

      <div class="results-bar">
        <div class="yes-result" style="width: <?= percent($votes['yes'] ?? 0, $total_votes) ?>%">
          Yes (<?= $votes['yes'] ?? 0 ?> votes)
        </div>
        <div class="no-result" style="width: <?= percent($votes['no'] ?? 0, $total_votes) ?>%">
          No (<?= $votes['no'] ?? 0 ?> votes)
        </div>
      </div>
      <p>Total votes: <?= $total_votes ?></p>

    <?php else: ?>
      <form method="post" class="vote-form">
        <button class="btn yes" type="submit" name="vote_option" value="yes">Yes</button>
        <button class="btn no" type="submit" name="vote_option" value="no">No</button>
      </form>
    <?php endif; ?>
  </div>
</body>
</html>
