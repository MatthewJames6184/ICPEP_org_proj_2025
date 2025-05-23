<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['user_email'] = $_POST['user_email'];
    $_SESSION['user_password'] = $_POST['user_password'];
    
    echo '
    <form id="forwardForm" method="post" action="register_process.php">
        <input type="hidden" name="user_fname" value="'.htmlspecialchars($_POST['user_fname']).'" />
        <input type="hidden" name="user_studNo" value="'.htmlspecialchars($_POST['user_studNo']).'" />
        <input type="hidden" name="user_birthday" value="'.htmlspecialchars($_POST['user_birthday']).'" />
        <input type="hidden" name="user_yearlevel" value="'.htmlspecialchars($_POST['user_yearlevel']).'" />
        <input type="hidden" name="user_section" value="'.htmlspecialchars($_POST['user_section']).'" />
        <input type="hidden" name="user_address" value="'.htmlspecialchars($_POST['user_address']).'" />
    </form>
    <script>document.getElementById("forwardForm").submit();</script>
    ';
}
?>
