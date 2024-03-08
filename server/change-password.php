<?php
session_start();
require "security/verify-input.php";
include("connection/connectionDB.php");

$ID = $_SESSION['ID'];

if (isset($_POST['change-password']) && isset($_SESSION['ID'])) {
    $newPassword = verify_input(sha1(md5($_POST['new-password'])));
    $confirmNewPassword = verify_input(sha1(md5($_POST['confirm-new-password'])));
    if ($newPassword === $confirmNewPassword) {
        $stmt = $conn->prepare("UPDATE `datauser` SET `password` = ? WHERE `ID` = ?");
        $stmt->bind_param('si', $newPassword, $ID);
        $stmt->execute();

        if($stmt) {
            unset($_SESSION['_password_']);
            unset($_SESSION['ID']);

            header("Location: ../Forget-Password.php?success=Update password completed.");
        } else {
            header("Location: ../Forget-Password.php?err=Error");
        }  
    } else {
        header("Location: ../Forget-Password.php?err=Password is not match.");
    }
}
?>