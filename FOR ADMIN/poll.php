<?php
session_start();

if (!isset($_SESSION['polls'])) {
    $_SESSION['polls'] = [
        [
            'id' => uniqid(),
            'name' => 'CPE NIGHT',
            'date' => '2025-05-20',
            'startTime' => '17:00',
            'endTime' => '21:00',
            'location' => 'VALENCIA HALL',
            'amount' => '650 PHP',
            'theme' => 'DISNEY',
            'yesVotes' => 0,
            'noVotes' => 0,
        ]
    ];
}

$polls = &$_SESSION['polls'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_poll') {
        $name = trim($_POST['eventName'] ?? '');
        $date = $_POST['eventDate'] ?? '';
        $startTime = $_POST['eventStartTime'] ?? '';
        $endTime = $_POST['eventEndTime'] ?? '';
        $location = trim($_POST['eventLocation'] ?? '');
        $amount = trim($_POST['eventAmount'] ?? '');
        $theme = trim($_POST['eventTheme'] ?? '');

        if ($name !== '' && $date !== '' && $startTime !== '' && $endTime !== '' && $location !== '' && $amount !== '' && $theme !== '') {
            $newPoll = [
                'id' => uniqid(),
                'name' => htmlspecialchars($name),
                'date' => $date,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'location' => htmlspecialchars($location),
                'amount' => htmlspecialchars($amount),
                'theme' => htmlspecialchars($theme),
                'yesVotes' => 0,
                'noVotes' => 0,
            ];
            $polls[] = $newPoll;
        }
    }

    if ($action === 'remove_poll' && !empty($_POST['pollId'])) {
        $pollId = $_POST['pollId'];
        foreach ($polls as $key => $poll) {
            if (($poll['id'] ?? '') === $pollId) {
                unset($polls[$key]);
                if (isset($_SESSION['votes'][$pollId])) {
                    unset($_SESSION['votes'][$pollId]);
                }
                break;
            }
        }
        $polls = array_values($polls);
    }

    if ($action === 'vote' && !empty($_POST['pollId']) && !empty($_POST['vote'])) {
        $pollId = $_POST['pollId'];
        $vote = $_POST['vote'];
        if (!isset($_SESSION['votes'][$pollId])) {
            foreach ($polls as &$poll) {
                if (($poll['id'] ?? '') === $pollId) {
                    if ($vote === 'yes') {
                        $poll['yesVotes'] = ($poll['yesVotes'] ?? 0) + 1;
                    } elseif ($vote === 'no') {
                        $poll['noVotes'] = ($poll['noVotes'] ?? 0) + 1;
                    }
                    $_SESSION['votes'][$pollId] = true;
                    break;
                }
            }
            unset($poll);
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Event Polls</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #e9f0f7;
        color: #004080;
        margin: 0; padding: 0;
    }
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 0 18px rgba(0,0,0,0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 40px;
        font-weight: 700;
        font-size: 2.4rem;
    }
    .poll-card {
        border: 3px solid #004080;
        border-radius: 15px;
        padding: 25px 30px;
        margin-bottom: 30px;
        background: #fefefe;
        box-shadow: 0 4px 12px rgba(0, 64, 128, 0.1);
        transition: box-shadow 0.3s ease;
    }
    .poll-card:hover {
        box-shadow: 0 6px 22px rgba(0, 64, 128, 0.2);
    }
    .poll-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .poll-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 700;
    }
    .event-info {
        margin-top: 15px;
        line-height: 1.5;
        color: #222;
        font-size: 1.05rem;
    }
    .event-info p {
        margin: 6px 0;
    }
    .time-info {
        font-weight: 600;
        color: #0059b3;
    }
    .btn {
        padding: 10px 20px;
        margin-right: 12px;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        cursor: pointer;
        color: white;
        font-size: 1rem;
        user-select: none;
        transition: background-color 0.3s ease;
    }
    .btn.yes {
        background-color: #007700;
    }
    .btn.yes:hover {
        background-color: #005500;
    }
    .btn.no {
        background-color: #aa0000;
    }
    .btn.no:hover {
        background-color: #770000;
    }
    .remove-btn {
        background-color: #004080;
        color: white;
        border: none;
        padding: 8px 16px;
        cursor: pointer;
        border-radius: 6px;
        font-size: 0.9rem;
        margin-top: 15px;
        transition: background-color 0.3s ease;
    }
    .remove-btn:hover {
        background-color: #002b5c;
    }
    .voted-msg {
        font-weight: 600;
        margin-bottom: 15px;
        color: #555;
        font-size: 1rem;
    }
    .results-bar {
        display: flex;
        height: 28px;
        border-radius: 6px;
        overflow: hidden;
        background-color: #ddd;
        font-weight: 700;
        color: white;
        font-size: 15px;
        user-select: none;
        margin-top: 10px;
        box-shadow: inset 0 1px 1px rgba(255,255,255,0.2);
    }
    .yes-result {
        background-color: #007700;
        line-height: 28px;
        white-space: nowrap;
        padding-left: 10px;
    }
    .no-result {
        background-color: #aa0000;
        line-height: 28px;
        white-space: nowrap;
        padding-left: 10px;
    }
    form.vote-form {
        margin-top: 18px;
    }
    /* Add Poll Form Styles */
    #addPollForm {
        margin-top: 50px;
        border-top: 2px solid #004080;
        padding-top: 30px;
    }
    #addPollForm label {
        display: block;
        margin-top: 15px;
        font-weight: 700;
        font-size: 1.1rem;
        color: #003366;
    }
    #addPollForm input[type="text"],
    #addPollForm input[type="date"],
    #addPollForm input[type="time"] {
        width: 100%;
        padding: 10px 12px;
        margin-top: 6px;
        box-sizing: border-box;
        border-radius: 8px;
        border: 1.8px solid #004080;
        font-size: 1rem;
        color: #004080;
        transition: border-color 0.3s ease;
    }
    #addPollForm input[type="text"]:focus,
    #addPollForm input[type="date"]:focus,
    #addPollForm input[type="time"]:focus {
        border-color: #007acc;
        outline: none;
    }
    .save-btn {
        margin-top: 28px;
        padding: 14px 0;
        background-color: #004080;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 700;
        font-size: 1.15rem;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    .save-btn:hover {
        background-color: #002b5c;
    }
    @media (max-width: 720px) {
        .container {
            margin: 20px;
            padding: 20px;
            max-width: 95%;
        }
        .poll-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
</head>
<body>
<div class="container">
    <h1>Event Polls</h1>

    <?php if (count($polls) === 0): ?>
        <p>No polls available. Add a new poll below.</p>
    <?php endif; ?>

    <?php foreach ($polls as $poll):
        $yesVotes = $poll['yesVotes'] ?? 0;
        $noVotes = $poll['noVotes'] ?? 0;
        $totalVotes = $yesVotes + $noVotes;
        $yesPercent = $totalVotes ? round(($yesVotes / $totalVotes) * 100) : 0;
        $noPercent = $totalVotes ? round(($noVotes / $totalVotes) * 100) : 0;
        $id = $poll['id'] ?? '';
    ?>
    <div class="poll-card">
        <div class="poll-header">
            <h2><?php echo htmlspecialchars($poll['name'] ?? 'Unnamed Event'); ?></h2>
            <form method="post" onsubmit="return confirm('Are you sure you want to remove this poll?');" style="margin:0;">
                <input type="hidden" name="pollId" value="<?php echo $id; ?>" />
                <input type="hidden" name="action" value="remove_poll" />
                <button type="submit" class="remove-btn">Remove Poll</button>
            </form>
        </div>
        <div class="event-info">
            <p><strong>Date:</strong> <?php echo htmlspecialchars($poll['date'] ?? ''); ?></p>
            <p><strong>Start Time:</strong> <span class="time-info"><?php echo htmlspecialchars($poll['startTime'] ?? ''); ?></span></p>
            <p><strong>End Time:</strong> <span class="time-info"><?php echo htmlspecialchars($poll['endTime'] ?? ''); ?></span></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($poll['location'] ?? ''); ?></p>
            <p><strong>Amount:</strong> <?php echo htmlspecialchars($poll['amount'] ?? ''); ?></p>
            <p><strong>Theme:</strong> <?php echo htmlspecialchars($poll['theme'] ?? ''); ?></p>
        </div>

        <?php if (isset($_SESSION['votes'][$id])): ?>
            <div class="voted-msg">You have voted. Results:</div>
            <div class="results-bar">
                <div class="yes-result" style="width: <?php echo $yesPercent; ?>%">
                    <?php echo $yesPercent; ?>% Yes
                </div>
                <div class="no-result" style="width: <?php echo $noPercent; ?>%">
                    <?php echo $noPercent; ?>% No
                </div>
            </div>
        <?php else: ?>
            <form method="post" class="vote-form" style="margin-top: 12px;">
                <input type="hidden" name="pollId" value="<?php echo $id; ?>" />
                <input type="hidden" name="action" value="vote" />
                <button type="submit" name="vote" value="yes" class="btn yes">Yes</button>
                <button type="submit" name="vote" value="no" class="btn no">No</button>
            </form>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>

    <hr />

    <h2>Add New Poll</h2>
    <form method="post" id="addPollForm">
        <input type="hidden" name="action" value="add_poll" />
        <label for="eventName">Event Name:</label>
        <input type="text" name="eventName" id="eventName" required />
        <label for="eventDate">Date:</label>
        <input type="date" name="eventDate" id="eventDate" required />
        <label for="eventStartTime">Start Time:</label>
        <input type="time" name="eventStartTime" id="eventStartTime" required />
        <label for="eventEndTime">End Time:</label>
        <input type="time" name="eventEndTime" id="eventEndTime" required />
        <label for="eventLocation">Location:</label>
        <input type="text" name="eventLocation" id="eventLocation" required />
        <label for="eventAmount">Amount:</label>
        <input type="text" name="eventAmount" id="eventAmount" required />
        <label for="eventTheme">Theme:</label>
        <input type="text" name="eventTheme" id="eventTheme" required />

        <button type="submit" class="save-btn">Add Poll</button>
    </form>
</div>
</body>

<script>
function initPollFunctions() {
  const openModalBtn = document.getElementById('openModalBtn');
  const modal = document.getElementById('editModal');
  const closeModalBtn = document.getElementById('closeModal');

  if (openModalBtn && modal && closeModalBtn) {
    openModalBtn.addEventListener('click', () => {
      modal.style.display = 'block';
    });

    closeModalBtn.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  }
}
initPollFunctions(); // run immediately when loaded
</script>

</html>
