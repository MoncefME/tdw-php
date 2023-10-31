<?php
    session_start();
    $username = $_POST["userName"];
    $password = $_POST["password"];

    if ($username == "admin" && $password == "admin") {
        $_SESSION["userName"] = $username; 
        $_SESSION["isAdmin"] = true;
        header("Location: ../admin.php");
    } else {
        header("Location: ./unAuthorized.php");
    }
?>