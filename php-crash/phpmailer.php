<?php
   require 'vendor/autoload.php';
//    use PHPMailer\PHPMailer\PHPMailer;
   $mail = new PHPMailer;
   $mail->isSMTP();
   $mail->SMTPDebug = 0;
   $mail->Host = 'smtp.titan.email';
   $mail->Port = 587;
   $mail->SMTPAuth = true;
   $mail->Username = 'info@westcoastmts.com';
   $mail->Password = 'EdPXVCAPuT';
   $mail->setFrom('info@westcoastmts.com', 'info@westcoastmts.com');
   $mail->addReplyTo('info@westcoastmts.com', 'info@westcoastmts.com');
   $mail->addAddress('info@westcoastmts.com', 'info@westcoastmts.com');
   $mail->Subject = 'Checking if PHPMailer works!!!';
   $mail->msgHTML(file_get_contents('message.html'), __DIR__);
   $mail->Body = 'This is just a plain text message body';
   //$mail->addAttachment('attachment.txt');
   if (!$mail->send()) {
       echo 'Mailer Error: ' . $mail->ErrorInfo;
   } else {
       echo 'The email message was sent.';
   }
?>