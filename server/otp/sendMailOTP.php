<?php
session_start();
date_default_timezone_set("Asia/Bangkok");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../mail/vendor/autoload.php';

require "../../server/security/verify-input.php";
include("../connection/connectionDB.php");

if (isset($_POST['get-otp'])) {
    $email = verify_input($_POST['email']);
    $stmt = $conn->prepare("SELECT `ID`, `email` FROM `datauser` WHERE `email` = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($ID, $email);
    $result = $stmt->fetch();
    $stmt->close();

    if ($result) {
        $OTP = rand(0, 999999);

        $stmt = $conn->prepare("UPDATE `datauser` SET `OTP`=? WHERE `ID`=?");
        $rc = $stmt->bind_param('si', $OTP, $ID);
        $stmt->execute();
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'mwit.landry@gmail.com';
            $mail->Password = 'fxnc lvat pnmt spta';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom($mail->Username, 'MWIT Laundry Service');
            $mail->addAddress($email);

            $mail->isHTML(true);

            $mail->Subject = "OTP for change your Password.";
            $mail->Body = '<div style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px"
                    align="center" class="m_3470863963415635773mdv2rw">
                    <div style="font-family:' . 'Google Sans' . ',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word">
                    <h5 style="font-family: ' . 'Google Sans' . ',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word;font-size:30px;color:#0dcaf0;">MWIT Laundry</h5>
                        <div style="font-size:24px">Your OTP for change password</div>
                    </div>
                    <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
                        TO: <a style="font-weight:bold">' . $email . '</a>
                        <div style="text-align:center;font-size:36px;margin-top:20px;line-height:44px">' . $OTP . '</div>
                        <br>This OTP was expired in 3 minutes.<br>
                    </div>
                    </div>';

            $mail->send();
            $time = $_SERVER['REQUEST_TIME'];
            $_SESSION['ID'] = $ID;
            $_SESSION['email'] = $email;
            $_SESSION['expired-OTP'] = strtotime("+3 minutes", $time);

            header("Location: ../../Forget-Password.php");

        } catch (Exception $e) {
            header("Location: ../../Forget-Password.php?err=Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    } else {
        header("Location: ../../Forget-Password.php?err=Email not found.");
    }

}

if (isset($_POST['Re-OTP'])) {

    $ID = $_POST['ID'];
    $email = $_POST['email'];

    $mail = new PHPMailer(true);

    $OTP = rand(0, 999999);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mwit.landry@gmail.com';
        $mail->Password = 'fxnc lvat pnmt spta';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom($mail->Username, 'MWIT Laundry Service');
        $mail->addAddress($email);

        $mail->isHTML(true);

        $mail->Subject = "OTP for change your Password.";
        $mail->Body = '<div style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px"
                align="center" class="m_3470863963415635773mdv2rw">
                <div style="font-family:' . 'Google Sans' . ',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word">
                <h5 style="font-family: ' . 'Google Sans' . ',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word;font-size:30px;color:#0dcaf0;">MWIT Laundry</h5>
                    <div style="font-size:24px">Your OTP for change password</div>
                </div>
                <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
                    TO: <a style="font-weight:bold">' . $email . '</a>
                    <div style="text-align:center;font-size:36px;margin-top:20px;line-height:44px">' . $OTP . '</div>
                    <br>This OTP was expired in 3 minutes.<br>
                </div>
                </div>';

        $mail->send();

        $stmt = $conn->prepare("UPDATE `datauser` SET `OTP` = ? WHERE `email` = ?");
        $rc = $stmt->bind_param('ss', $OTP, $email);
        $stmt->execute();

        if ($stmt) {
            $time = $_SERVER['REQUEST_TIME'];
            $_SESSION['email'] = $email;
            $_SESSION['ID'] = $ID;
            $_SESSION['expired-OTP'] = strtotime("+3 minutes", $time);
            $_SESSION['OTP-cooldown'] = strtotime('+1 minutes 30 seconds', $time);


            header("Location: ../../Forget-Password.php");
        } else {
            header("Location: ../../Forget-Password.php?err=Upload OTP fail.");
        }

    } catch (Exception $e) {
        header("Location: ../../Forget-Password.php?err=Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}
?>