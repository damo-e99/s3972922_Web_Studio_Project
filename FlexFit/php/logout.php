<?php
session_start();


if(isset($_SESSION['authenticated_user'])){
    unset($_SESSION['authenticated']);
    unset($_SESSION['authenticated_user']);
    $_SESSION['message'] = "Logged Out";
}

header('Location: ../php/home.php')
?>