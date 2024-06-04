<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

/**
 * Send an email using PHPMailer and Gmail SMTP.
 *
 * @param string $to Recipient's email address
 * @param string $subject Email subject
 * @param string $body HTML body of the email
 * @param string $altBody Plain text body of the email (optional)
 * @return bool|string Returns true if the email was sent successfully, otherwise returns the error message
 */
function sendEmail($to, $subject, $body, $altBody = '') {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Recipients
        $mail->setFrom($_ENV['EMAIL_USER'], 'Auth');
        $mail->addAddress($to);
        $mail->addReplyTo($_ENV['EMAIL_USER'], 'Support');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = $altBody ?: strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}