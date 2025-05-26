<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "u495515480_voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if the user has already voted
function hasUser Voted($conn, $userId) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM votes WHERE user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0; // Return true if the user has voted
}

// Get the user ID from the request (this should be securely managed)
$userId = $_POST['userId']; // Ensure this is securely handled in your application

// Check if the user has already voted
if (hasUser Voted($conn, $userId) || isset($_COOKIE['hasVoted'])) {
    echo json_encode(['success' => false, 'message' => 'You have already voted.']);
    exit();
}

// Array to hold voted candidates
$voted = [];

// Process the vote data
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

// Store the voted status in the session
$_SESSION['voted'] = $voted;

// Set a cookie to indicate the user has voted
setcookie('hasVoted', 'true', time() + (86400 * 365), "/"); // 1 year expiration

$conn->close();

// Redirect to thank you page
header("Location: thank_you.php");
exit();
?>
