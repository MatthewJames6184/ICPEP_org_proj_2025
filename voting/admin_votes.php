<?php
$conn = new mysqli("localhost", "root", "", "voting_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT position, name, votes FROM candidates 
        ORDER BY FIELD(position,
            'President', 'Vice-President', 'External', 'Internal', 'Secretary',
            'Assistant Secretary', 'Treasurer', 'Assistant Treasurer', 'Auditor',
            'Business Manager', 'P. R. O', 'Property Custodian', 'Quizzer Head',
            'Sports Head', 'Multimedia Head'), votes DESC, name ASC";

$result = $conn->query($sql);

$currentPosition = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Vote Counts</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
    <h1>Vote Counts</h1>

    <?php while ($row = $result->fetch_assoc()): ?>
        <?php if ($currentPosition != $row['position']): ?>
            <?php if ($currentPosition !== ""): ?>
                </div> <!-- close previous position -->
            <?php endif; ?>
            <?php $currentPosition = $row['position']; ?>
            <div class="position">
                <h2><?= htmlspecialchars($currentPosition) ?></h2>
        <?php endif; ?>
        <p><?= htmlspecialchars($row['name']) ?> — <span class="highlight"><?= $row['votes'] ?></span> votes</p>
    <?php endwhile; ?>
    </div> <!-- close last position -->
</div>
</body>
</html>

<?php $conn->close(); ?>
