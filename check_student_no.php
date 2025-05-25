<?php
include 'database.php';
header('Content-Type: application/json');

if (isset($_GET['studNo'])) {
    $studNo = $_GET['studNo'];
    $stmt = $conn->prepare("SELECT student_number FROM user_account WHERE student_number = ?");
    $stmt->bind_param("s", $studNo);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    echo json_encode(['exists' => $exists]);
    exit;
}
echo json_encode(['exists' => false]);
?>