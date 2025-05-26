<?php
session_start();

// Database connection - replace with your actual credentials
$servername = "localhost"; // or your server name
$username = "u495515480_root"; // your database username
$password = "Voting$123"; // your database password
$dbname = "u495515480_voting_db"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$poll_id = 1; // single poll id

// Handle AJAX vote submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote_option'])) {
    header('Content-Type: application/json');
    
    if (isset($_SESSION['voted_poll_' . $poll_id])) {
        // Already voted
        echo json_encode(['success' => false, 'message' => 'You already voted.']);
        exit();
    }
    
    $vote_option = $_POST['vote_option'];
    if (!in_array($vote_option, ['yes', 'no'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid vote option.']);
        exit();
    }

    // Update vote count in DB
    $stmt = $conn->prepare("UPDATE poll_votes SET votes = votes + 1 WHERE poll_id = ? AND option_name = ?");
    $stmt->bind_param("is", $poll_id, $vote_option);
    $stmt->execute();
    $stmt->close();

    // Mark as voted in session
    $_SESSION['voted_poll_' . $poll_id] = true;

    // Fetch updated votes to return
    $votes = [];
    $total_votes = 0;
    $sql = "SELECT option_name, votes FROM poll_votes WHERE poll_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $poll_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $votes[$row['option_name']] = (int)$row['votes'];
        $total_votes += (int)$row['votes'];
    }
    $stmt->close();

    // Calculate percentages
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

// Function to calculate percentage for initial page load
function percent($count, $total) {
    if ($total === 0) return 0;
    return round(($count / $total) * 100, 1);
}

// Fetch current votes for initial page load
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

$voted = isset($_SESSION['voted_poll_' . $poll_id]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Poll System</title>
<style>
  body { font-family: Arial, sans-serif; background:#f4f4f4; }
  .container { max-width: 500px; margin: 50px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.1);}
  h1 { color: #004080; }
  button { padding: 10px 25px; margin: 10px 10px 10px 0; border: none; border-radius: 6px; font-weight: 600; cursor: pointer; color: white; }
  .btn-yes { background-color: #0073e6; }
  .btn-no { background-color: #d9534f; }
  .voted-msg { color: #28a745; font-weight: 600; margin-bottom: 15px; }
  .results-bar { display: flex; height: 28px; border-radius: 14px; overflow: hidden; background: #ddd; color: white; font-weight: 600; font-size: 13px; width: 100%; }
  .yes-result, .no-result {
    display: flex; align-items: center; justify-content: center; line-height: 1; white-space: nowrap;
    height: 100%; padding: 0 8px; box-sizing: border-box; overflow: hidden;
  }
  .yes-result { background-color: #0073e6; border-top-left-radius: 14px; border-bottom-left-radius: 14px; }
  .no-result { background-color: #d9534f; border-top-right-radius: 14px; border-bottom-right-radius: 14px; }
</style>
</head>
<body>
<div class="container">
  <h1>Are you ready for OJT? <h1>

  <?php if ($voted): ?>
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
    <div id="vote-buttons">
      <button class="btn-yes" data-vote="yes">Yes</button>
      <button class="btn-no" data-vote="no">No</button>
    </div>
    <div id="vote-message" style="margin-top: 15px; font-weight:600;"></div>
  <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const voteButtons = document.querySelectorAll('#vote-buttons button');
  const voteMessage = document.getElementById('vote-message');
  const container = document.querySelector('.container');

  voteButtons.forEach(button => {
    button.addEventListener('click', () => {
      const voteOption = button.getAttribute('data-vote');

      voteMessage.textContent = 'Submitting your vote...';

      fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'vote_option=' + encodeURIComponent(voteOption)
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Replace the vote buttons with results
          container.innerHTML = `
            <h1>Are you Ready For OJT?</h1>
            <p class="voted-msg">Thank you for voting!</p>
            <div class="results-bar">
              <div class="yes-result" style="width: ${data.percent_yes}%">Yes (${data.votes.yes} votes)</div>
              <div class="no-result" style="width: ${data.percent_no}%">No (${data.votes.no} votes)</div>
            </div>
            <p>Total votes: ${data.total_votes}</p>
          `;
        } else {
          voteMessage.textContent = data.message || 'Error submitting vote.';
        }
      })
      .catch(() => {
        voteMessage.textContent = 'Network or server error.';
      });
    });
  });
});
</script>

</body>
</html>