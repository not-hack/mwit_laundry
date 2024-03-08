<?php
session_start();
include("../connection/connectionDB.php");

$ID = $_SESSION['ID'];

if (isset($_POST['confirm-otp'])) {
    $confirm_otp = $_POST['OTP-f1'] . $_POST['OTP-f2'] . $_POST['OTP-f3'] . $_POST['OTP-f4'] . $_POST['OTP-f5'] . $_POST['OTP-f6'];

    $stmt = $conn->prepare("SELECT `OTP` FROM `datauser` WHERE `ID` = ? LIMIT 1");
    $stmt->bind_param('i', $ID);
    $stmt->execute();
    $stmt->bind_result($OTP);
    $stmt->fetch();
    $stmt->close();


    if (($_SERVER['REQUEST_TIME'] - $_SESSION['expired-OTP']) <= 180) {
        if ($OTP == $confirm_otp) {
            $empty = "(NULL)";

            $stmt = $conn->prepare("UPDATE `datauser` SET `OTP` = ? WHERE `ID` = ?");
            $stmt->bind_param('si', $empty, $ID);
            $stmt->execute();
        
            if ($stmt) {
                unset($_SESSION['expired-OTP']);
                unset($_SESSION['email']);
                if (isset($_SESSION['OTP-cooldown'])) {
                    unset($_SESSION['OTP-cooldown']);
                }
                $_SESSION['_password_'] = true;
                header("Location: ../../Forget-Password.php");
            } else {
                header("Location: ../../Forget-Password.php?err=Error");
            }

        } else {
            header("Location: ../../Forget-Password.php?err=OTP is wrong.");
        }
    } else {
        header("Location: ../../Forget-Password.php?err=OTP was expired. Please press cancle.");
        exit;
    }
}
?>