<?php
session_start();
$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "u495515480_voting_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming user_id is stored in session after user logs in
$user_id = $_SESSION['user_id']; // Make sure to set this when the user logs in

// Check if the user has already voted
$checkVoteQuery = $conn->prepare("SELECT COUNT(*) FROM votes WHERE user_id = ?");
$checkVoteQuery->bind_param("i", $user_id);
$checkVoteQuery->execute();
$checkVoteQuery->bind_result($voteCount);
$checkVoteQuery->fetch();
$checkVoteQuery->close();

if ($voteCount > 0) {
    // User has already voted
    echo "You have already voted. Thank you!";
    exit();
}

$voted = [];
foreach ($_POST as $position => $candidate_id) {
    if (is_array($candidate_id)) {
        $abstainOnly = count($candidate_id) === 1 && $candidate_id[0] === "abstain";
        $abstainMixed = in_array("abstain", $candidate_id) && count($candidate_id) > 1;

        if ($abstainMixed) {
            // Skip mixed abstain + candidate votes
            continue;
        }

        if ($abstainOnly) {
            $voted[$position] = "abstained";
            continue;
        }

        foreach ($candidate_id as $id) {
            if ($id === "abstain") continue; // already handled above
            $stmt = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $voted[$position][] = $id;
        }
    } else {
        if ($candidate_id === "abstain") {
            $voted[$position] = "abstained";
            continue;
        }
        $stmt = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
        $stmt->bind_param("i", $candidate_id);
        $stmt->execute();
        $voted[$position] = $candidate_id;
    }
}

// Record the vote in the votes table
$insertVoteQuery = $conn->prepare("INSERT INTO votes (user_id, voted_data) VALUES (?, ?)");
$votedData = json_encode($voted); // Store the voted data as JSON
$insertVoteQuery->bind_param("is", $user_id, $votedData);
$insertVoteQuery->execute();
$insertVoteQuery->close();

$_SESSION['voted'] = $voted;

$conn->close();

header("Location: thank_you.php");
exit();
?>
