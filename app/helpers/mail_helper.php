<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';

function send_email($to, $subject, $body) {
    // Get mailer settings from database
    $db = new Database;
    $db->query("SELECT value FROM settings WHERE name IN ('smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port') ORDER BY name");
    $settings = $db->resultSet();

    $smtp_host = $settings[0]->value;
    $smtp_pass = $settings[1]->value;
    $smtp_port = $settings[2]->value;
    $smtp_user = $settings[3]->value;

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = $smtp_port;

        //Recipients
        $mail->setFrom($smtp_user, SITENAME);
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
