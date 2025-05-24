<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Add your authentication logic here

    echo "Login attempted for user: $username";
}
?>
