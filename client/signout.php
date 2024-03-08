<?php
    session_start();
    unset($_SESSION['ID']);
    unset($_SESSION['class']);
    session_destroy();

    header("Location: ../Signin.php");
    exit();
?>