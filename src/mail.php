<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load Composer's autoloader

function send_mail($reciever, $subject, $mail_body)
{
    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.example.com';               // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = 'your_email@example.com';         // SMTP username
        $mail->Password = 'your_password';                  // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addReplyTo('info@example.com', 'Information');

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}