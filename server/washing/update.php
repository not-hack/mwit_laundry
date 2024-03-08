<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require '.../mail/vendor/autoload.php';
include("../connection/PDO_connectionDB.php");

$data = [
    'status' => $_POST['status'],
    'end_usetime' => $_POST['end_usertime'],
    'current_user' => $_POST['current_user'],
    'lastuser' => $_POST['lastuser'],
    'ID' => $_POST['ID']
];
// $t_data = [
//     'status' => "ready",
//     'end_usetime' => "(NULL)",
//     'current_user' => "(NULL)",
//     'lastuser' => "s000000",
//     'ID' => 2
// ];

$update = "UPDATE `washing-machine` SET `status` = :status, `end_usetime` = :end_usetime, `current_user` = :current_user, `last_user` = :lastuser WHERE `ID` = :ID";
$stmt = $DB_connect->prepare($update);
$stmt->execute($data);

// $stmt = $DB_connect->prepare("SELECT `email` FROM `datauser` WHERE `userID` = :lastuser");
// $stmt->bindParam(':lastuser', $_POST['lastuser']);
// $stmt->execute();
// $rs = $stmt->fetch(PDO::FETCH_ASSOC);

// $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->isSMTP();
//     $mail->Host = 'smtp.gmail.com'; // SMTP server
//     $mail->SMTPAuth = true;
//     $mail->Username = 'mwit.landry@gmail.com'; // SMTP username
//     $mail->Password = 'fxnc lvat pnmt spta'; // SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
//     $mail->Port = 465; // TCP port to connect to

//     //Recipients
//     $mail->setFrom($mail->Username, 'MWIT Laundry Service');
//     $mail->addAddress("pakornkaed.kua_g33@mwit.ac.th");

//     // Content
//     $mail->isHTML(true);
//     $mail->Subject = "success";
//     $mail->Body = "success";

//     $mail->send();
//     return true;
// } catch (Exception $e) {
//     return false;
// }
?>