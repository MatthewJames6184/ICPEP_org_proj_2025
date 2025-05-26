<?php
session_start();

// DB credentials
$servername = "localhost";
$username = "u495515480_root";
$password = "Voting$123";
$dbname = "u495515480_voting_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$pollid = 1;

// Handle AJAX voting
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_option'])) {
    header('Content-Type: application/json');

    if (isset($_SESSION['voted_poll_' . $pollid])) {
        echo json_encode(['success' => false, 'message' => 'You already voted.']);
        exit();
    }

    $vote_option = $_POST['vote_option'];
    if (!in_array($vote_option, ['yes', 'no'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid vote option.']);
        exit();
    }

    // Update vote count
    $stmt = $conn->prepare("UPDATE poll_votes SET votes = votes + 1 WHERE pollid = ? AND option_name = ?");
    $stmt->bind_param("is", $pollid, $vote_option);
    $stmt->execute();
    $stmt->close();

    $_SESSION['voted_poll_' . $pollid] = true;

    // Fetch results
    $stmt = $conn->prepare("SELECT option_name, votes FROM poll_votes WHERE pollid = ?");
    $stmt->bind_param("i", $pollid);
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
        return $total === 0 ? 0 : round(($count / $total) * 100, 1);
    }

    echo json_encode([
        'success' => true,
        'votes' => $votes,
        'total_votes' => $total_votes,
        'percent_yes' => percent($votes['yes'] ?? 0, $total_votes),
        'percent_no' => percent($votes['no'] ?? 0, $total_votes)
    ]);
    exit();
}

// Load vote data for initial display
$stmt = $conn->prepare("SELECT option_name, votes FROM poll_votes WHERE pollid = ?");
$stmt->bind_param("i", $pollid);
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
    return $total === 0 ? 0 : round(($count / $total) * 100, 1);
}

$voted = isset($_SESSION['voted_poll_' . $pollid]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Poll System</title>
  <link rel="stylesheet" href="poll2.css" />
</head>
<body>
<div class="container">
  <h1>Do you like this poll system?</h1>

  <?php if ($voted): ?>
    <p class="voted-msg">Thank you for voting!</p>
    <div class="results-bar">
      <div class="yes-result" style="width: <?= percent($votes['yes'] ?? 0, $total_votes) ?>%">
        Yes (<?= $votes['yes'] ?? 0 ?>)
      </div>
      <div class="no-result" style="width: <?= percent($votes['no'] ?? 0, $total_votes) ?>%">
        No (<?= $votes['no'] ?? 0 ?>)
      </div>
    </div>
    <p>Total votes: <?= $total_votes ?></p>
  <?php else: ?>
    <div class="vote-form" id="vote-buttons">
      <button class="btn yes" data-vote="yes">Yes</button>
      <button class="btn no" data-vote="no">No</button>
    </div>
    <div id="vote-message" style="margin-top: 15px; font-weight:600;"></div>
  <?php endif; ?>
</div>

<script src="poll2.js"></script>
</body>
</html>
