<?php
session_start();
include("../connection/connectionDB.php");

$ID = $_SESSION['ID'];
$empty = "(NULL)";

$stmt = $conn->prepare("UPDATE `datauser` SET `OTP` = ? WHERE `ID` = ?");
$stmt->bind_param('si', $empty, $ID);
$stmt->execute();

if($stmt) {
    unset($_SESSION['expired-OTP']);
    unset($_SESSION['ID']);
    unset($_SESSION['email']);

    if(isset($_SESSION['OTP-cooldown'])) { unset($_SESSION['OTP-cooldown']); }

    header("Location: ../../Forget-Password.php");
} else {
    header("Location: ../../Forget-Password.php?err=Error");
}




?>