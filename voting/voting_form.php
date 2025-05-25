<?php
$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$multiVotePositions = [
    'Business Manager',
    'P. R. O',
    'Property Custodian',
    'Quizzer Head',
    'Sports Head',
    'Multimedia Head'
];

$sql = "SELECT * FROM candidates ORDER BY FIELD(position,
    'President', 'Vice-President', 'External', 'Internal', 'Secretary',
    'Assistant Secretary', 'Treasurer', 'Assistant Treasurer', 'Auditor',
    'Business Manager', 'P. R. O', 'Property Custodian', 'Quizzer Head',
    'Sports Head', 'Multimedia Head'), name";
$result = $conn->query($sql);

$candidatesByPosition = [];
while ($row = $result->fetch_assoc()) {
    $candidatesByPosition[$row['position']][] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voting Form</title>
    <link rel="stylesheet" href="styleV.css">
</head>
<body>
<div class="container">
    <h1>Student Council Voting Form</h1>
    <form method="POST" action="submit_vote.php" id="votingForm">
        <?php foreach ($candidatesByPosition as $position => $candidates): ?>
            <div class="position" data-position="<?= htmlspecialchars($position) ?>">
                <h2><?= htmlspecialchars($position) ?> <span style="color:red">*</span></h2>

                <?php foreach ($candidates as $candidate): ?>
                    <?php if (in_array($position, $multiVotePositions)): ?>
                        <label>
                            <input type="checkbox"
                                   name="<?= htmlspecialchars($position) ?>[]"
                                   value="<?= $candidate['id'] ?>"
                                   class="multi-choice"
                                   data-group="<?= htmlspecialchars($position) ?>">
                            <?= htmlspecialchars($candidate['name']) ?>
                        </label>
                    <?php else: ?>
                        <label>
                            <input type="radio"
                                   name="<?= htmlspecialchars($position) ?>"
                                   value="<?= $candidate['id'] ?>"
                                   required>
                            <?= htmlspecialchars($candidate['name']) ?>
                        </label>
                    <?php endif; ?>
                <?php endforeach; ?>

                <?php if (in_array($position, $multiVotePositions)): ?>
                    <label>
                        <input type="checkbox"
                               name="<?= htmlspecialchars($position) ?>[]"
                               value="abstain"
                               class="multi-choice"
                               data-group="<?= htmlspecialchars($position) ?>">
                        Abstain
                    </label>
                <?php else: ?>
                    <label>
                        <input type="radio"
                               name="<?= htmlspecialchars($position) ?>"
                               value="abstain"
                               required>
                        Abstain
                    </label>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit">Submit Vote</button>
    </form>
</div>

<!-- Include external validation script -->
<script src="script.js"></script>
</body>
</html>
