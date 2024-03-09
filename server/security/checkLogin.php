<?php
    function checkLogin() {
        if (!isset($_SESSION['ID']) OR !isset($_SESSION['class'])) {
            $host = $_SERVER['HTTP_HOST'];
            $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = "Signin";
            unset($_SESSION["ID"]);
            unset($_SESSION['class']);
            header("Location: https://$host$uri/$extra");
            //header("Location: https://localhost/MWIT-Laundry/$extra");
        }
    }
?>
