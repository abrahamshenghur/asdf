<?php

use PHPMailer\PHPMailer\PHPMailer;

$msg = '';

if (array_key_exists('email', $_POST)) {
    require 'vendor/autoload.php';
    // $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.titan.email';
    $mail->Port = 587;
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->Username = 'info@westcoastmts.com';
    $mail->Password = 'EdPXVCAPuT';
    $mail->setFrom('info@westcoastmts.com', 'info@westcoastmts.com');
    // $mail->addReplyTo('info@westcoastmts.com', 'info@westcoastmts.com');
    $mail->addAddress('info@westcoastmts.com', 'info@westcoastmts.com');
    if ($mail->addReplyTo($_POST['email'], $_POST['name'])) {
        $mail->Subject = 'Contact from ' . $_POST['name'];
        $mail->isHTML(false);
        $mail->Body = <<<EOT
            Name: {$_POST['name']}
            Email: {$_POST['email']}
            Phone: {$_POST['phone']}
            Call Me: {$_POST['contactTime']}
            Message: {$_POST['message']}
EOT;
        if (!$mail->send()) {
            $msg = 'Sorry, something went wrong. Please try again later.';
        } else {
            $msg = 'Message sent! Thanks for contacting us.';
        }
    } else {
        $msg = 'Share it with us!';
    }
}
?>
<?php if (!empty($msg)) {
    echo "<h2>$msg</h2>";
} ?>


















