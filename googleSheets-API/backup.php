<?php
#example in signin.php

session_start();
require "server/security/verify-input.php";
require "googleSheets-API/vendor/autoload.php";
require "googleSheets-API/key.secret.php";

$credentials_path = 'googleSheets-API/credentials.json';
include("googleSheets-API/service.php");

if (isset($_POST['signin'])) {

    $userID = verify_input(strtolower($_POST['userID']));
    $password = verify_input(sha1(md5($_POST['password'])));

    require_once 'googleSheets-API/fetch-all.php';
    $query = json_decode($USERDATA, true);

    foreach ($query as $USER) {
        if ($USER["userID"] === $userID && $USER["password"] === $password) {
            if ($USER["class"] == sha1(md5("USER"))) {
                if (isset($_SESSION['success'])) {
                    unset($_SESSION['success']);
                }
                $_SESSION['ID'] = $USER["ID"];
                $_SESSION['class'] = $USER["class"];

                $_SESSION['userID'] = $USER['userID'];
                $_SESSION['email'] = $USER['email'];
                $_SESSION['firstname'] = $USER['firstname'];
                $_SESSION['lastname'] = $USER['lastname'];
                $_SESSION['gender'] = $USER['gender'];

                header("Location: client/main.php");
                exit;
            }
        }
    }
    $err = "Invalid user ID or password";
}

?>