<?php
    date_default_timezone_set("Asia/Bangkok");
    require "vendor/autoload.php";
    require '../mail/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use Cron\CronExpression;

    function sendEmail($recipient, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'mwit.landry@gmail.com'; // SMTP username
            $mail->Password = 'fxnc lvat pnmt spta'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
            $mail->Port = 465; // TCP port to connect to

            //Recipients
            $mail->setFrom($mail->Username, 'MWIT Laundry Service');
            $mail->addAddress($recipient);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    $recipient = "mwit.landry@gmail.com";
    $subject = "test";
    $body = "test";

    echo "wait 2 minutes";

    $cron = CronExpression::factory('0 * * * *');
    echo $cron->getNextRunDate()->format("Y-m-d H:i:s");
    if ($cron->isDue()) {
        sendEmail($recipient, $subject, $body);
        echo "success";
    }
    
    


?>