<?php
session_start();

// TODO: Replace this with your actual PDO connection
// Example:
// $pdo = new PDO("mysql:host=localhost;dbname=your_db", "your_user", "your_pass");
// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo = null; // Placeholder to prevent errors if you haven't set up your DB yet

$polls = [];

// TODO: Replace with actual fetch from your database
// Example:
// $stmt = $pdo->query("SELECT * FROM polls");
// $polls = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Sample placeholder poll for testing without database
$polls[] = [
    'id' => 1,
    'name' => 'Sample Event',
    'date' => '2025-06-15',
    'start_time' => '10:00',
    'end_time' => '14:00',
    'location' => 'Bulacan State University',
    'amount' => 'Free',
    'theme' => 'Innovation and Technology',
    'yes_votes' => 12,
    'no_votes' => 3
];

// Handle voting (simulation only — no DB update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pollId'], $_POST['vote'])) {
    $pollId = (int)$_POST['pollId'];
    $vote = $_POST['vote'];

    // Simulate voting session
    if (!isset($_SESSION['votes'][$pollId])) {
        // TODO: Update your poll's yes/no vote count in the database
        // Example:
        // $pdo->prepare("UPDATE polls SET yes_votes = yes_votes + 1 WHERE id = ?")->execute([$pollId]);

        $_SESSION['votes'][$pollId] = $vote;
        header("Location: poll.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Polls</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e9f0f7;
            color: #004080;
            padding: 30px;
        }
        .container {
            max-width: 700px;
            margin: auto;
        }
        .poll {
            background-color: white;
            color: black;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .poll h3 {
            margin-top: 0;
        }
        .poll p {
            margin: 5px 0;
        }
        .poll button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        .yes { background-color: #28a745; color: white; }
        .no { background-color: #dc3545; color: white; }
        .voted {
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Event Polls</h1>

    <?php if (count($polls) === 0): ?>
        <p>No events available.</p>
    <?php else: ?>
        <?php foreach ($polls as $poll): ?>
            <div class="poll">
                <h3><?= htmlspecialchars($poll['name']) ?></h3>
                <p><strong>Date:</strong> <?= htmlspecialchars($poll['date']) ?></p>
                <p><strong>Time:</strong> <?= htmlspecialchars($poll['start_time']) ?> - <?= htmlspecialchars($poll['end_time']) ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($poll['location']) ?></p>
                <p><strong>Amount:</strong> <?= htmlspecialchars($poll['amount']) ?></p>
                <p><strong>Theme:</strong> <?= htmlspecialchars($poll['theme']) ?></p>
                <p><strong>Votes:</strong> Yes (<?= $poll['yes_votes'] ?>), No (<?= $poll['no_votes'] ?>)</p>

                <?php if (!isset($_SESSION['votes'][$poll['id']])): ?>
                    <form method="post">
                        <input type="hidden" name="pollId" value="<?= $poll['id'] ?>">
                        <button class="yes" name="vote" value="yes">Yes</button>
                        <button class="no" name="vote" value="no">No</button>
                    </form>
                <?php else: ?>
                    <p class="voted">You voted: <strong><?= strtoupper($_SESSION['votes'][$poll['id']]) ?></strong></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
