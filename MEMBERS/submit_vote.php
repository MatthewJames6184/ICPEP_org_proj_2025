<?php
session_start();

$conn = new mysqli("localhost", "root", "", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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

$_SESSION['voted'] = $voted;

$conn->close();

header("Location: thank_you.php");
exit();
?>
