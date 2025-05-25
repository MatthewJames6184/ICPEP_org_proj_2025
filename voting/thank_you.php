<?php
$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Helper function to safely flatten votes if nested accidentally
function flatten_votes($votes) {
    $flat = [];
    foreach ($votes as $key => $value) {
        if (is_array($value)) {
            // If nested array, flatten recursively and merge values
            $flat[$key] = [];
            array_walk_recursive($value, function($v) use (&$flat, $key) {
                $flat[$key][] = $v;
            });
            // Remove duplicates and reset keys
            $flat[$key] = array_values(array_unique($flat[$key]));
        } else {
            $flat[$key] = $value;
        }
    }
    return $flat;
}

if (isset($_SESSION['voted']) && is_array($_SESSION['voted'])) {
    // Flatten the votes array to avoid nesting problems
    $voted = flatten_votes($_SESSION['voted']);
} else {
    $voted = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Thank You</title>
    <link rel="stylesheet" href="styleV.css" />
</head>
<body>
<div class="container">
    <h1>Thank You for Voting!</h1>

    <?php if (!empty($voted)): ?>
        <?php foreach ($voted as $position => $candidate_ids): ?>
            <div class="position">
                <h2><?= htmlspecialchars($position) ?></h2>

                <?php if ($candidate_ids === "abstained" || $candidate_ids === "abstain"): ?>
                    <p class="abstained">🚫 Abstained</p>
                <?php else: ?>
                    <?php
                    // Normalize to array if single vote
                    if (!is_array($candidate_ids)) {
                        $candidate_ids = [$candidate_ids];
                    }

                    foreach ($candidate_ids as $id):
                        if ($id === "abstain" || $id === "abstained") {
                            echo '<p class="abstained">🚫 Abstained</p>';
                            continue;
                        }

                        $id = intval($id);
                        $result = $conn->query("SELECT name FROM candidates WHERE id = $id");
                        if ($result && $row = $result->fetch_assoc()):
                    ?>
                        <p>✔ <?= htmlspecialchars($row['name']) ?></p>
                    <?php
                        else:
                            // Candidate not found
                            echo '<p>(Candidate not found)</p>';
                        endif;
                    endforeach;
                    ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No votes were recorded.</p>
    <?php endif; ?>
</div>
</body>
</html>

<?php
$conn->close();
?>
