<?php
    require_once 'config.php';

    if ($_SERVER['REQUEST_METHOD'] == "POST") { 
        if (isset($_POST['lozinka']) && isset($_POST['unvisible'])) {
            $hashed_password = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);
            $member_id = (int)$_POST['unvisible'];
            $sql = "UPDATE members SET password = ? WHERE member_id = ?";
            $run = $conn->prepare($sql);
            $run->bind_param("si", $hashed_password, $member_id);
            $run->execute();
            unset($_SESSION['new_member']);
            header("Location: dashboard.php");
        }
    }
?>