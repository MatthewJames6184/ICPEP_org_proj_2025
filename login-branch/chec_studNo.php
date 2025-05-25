<?php
include 'database.php';

if (isset($_POST['student_number'])) {
    $studNo = $_POST['student_number'];
    $stmt = $conn->prepare("SELECT id FROM user_account WHERE student_number = ?");
    $stmt->bind_param("s", $studNo);
    $stmt->execute();
    $stmt->store_result();

    echo $stmt->num_rows > 0 ? 'exists' : 'available';
    $stmt->close();
}
?>
