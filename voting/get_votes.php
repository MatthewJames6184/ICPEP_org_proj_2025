<?php
//$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "voting_db");
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

echo "<h1>Live Vote Count</h1>";
$currentPosition = "";

while ($row = $result->fetch_assoc()) {
    if ($currentPosition != $row['position']) {
        $currentPosition = $row['position'];
        echo "<h2>" . htmlspecialchars($currentPosition) . "</h2>";
    }
    echo "<p>" . htmlspecialchars($row['name']) . " — " . $row['votes'] . " votes</p>";
}

$conn->close();
?>