<?php
// $arr = array(1, 2, 3);

// echo '<pre>';
// print_r($arr);
// echo '</pre>';

// print_r($arr); 

// Message Vars


use PHPMailer\PHPMailer\PHPMailer;
// Message Vars
$msg = '';
$msgClass = '';

// Check for Submit
if (filter_has_var(INPUT_POST, 'submit')) {
    // Get From Data
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $contactTime = htmlspecialchars($_POST['contactTime']);
    $message = htmlspecialchars($_POST['message']);

    // Check Required Fields
    if (!empty($email) && !empty($name) && !empty($phone) && !empty($message)) {
        // Passed
        // Check Email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            // Failed
            $msg = 'Please use a valid email';
            $msgClass = 'alert-danger';
        } else {
        // Passed
        require 'vendor/autoload.php';

        $mail = new PHPMailer;
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
        $mail->Subject = 'Contact from ' . $_POST['name'];
        $mail->isHTML(true);
        $subject = 'Contact Request From ' . $name;
        $mail->Body = <<<EOT
                        <h2>Contact Request</h2>
                        <p><span style="font-weight:bold">Name: </span>$name</p>
                        <p><span style="font-weight:bold">Phone: </span>$phone</p>
                        <p><span style="font-weight:bold">Email: </span>$email</p>
                        <p><span style="font-weight:bold">Call Me: </span>$contactTime</p>
                        <h4>Message</h4><p>$message</p>
EOT;

        if (!$mail->send()) {
            $msg = 'Your email was not sent.';
            $msgClass = 'alert-danger';
        } else {
            $msg = "Thank you for your interest! We'll get back to you soon!.";
            $msgClass = 'alert-success';
        }
        }
    } else {
        // Failed
        $msg = 'Please fill in all fields';
        $msgClass = 'alert-danger';
    }
}
?>

<?php include 'header.php'; ?>

    <main style="background-color: white; padding: 1rem 0">
        <section class="contact-us-container">

            <div class="contact-us-left-column">
                <img style="width: 100%; height: auto; background-size: cover;" src="./images/website-images/lot-street-view.png" alt="">
                <h2 class="primary">CONTACT US</h2>
                <p>
                    Get In Touch.
                    <br>
                    <br>
                    We want to hear from you. Whether you’re a prospective client, interested in joining the team or simply a fan of our work, say hi!
                    <br>
                    <br>
                    If you have any questions please submit them below and one of our dealership representatives will contact you shortly.
                    <br>
                    <br>
                    <br>
                    123 Maple St., Somewhere, SS 38382
                    <br>
                    <br>
                    (555) 555-5555
                </p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26360541.027985662!2d-113.7410671029149!3d36.24339311525428!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54eab584e432360b%3A0x1c3bb99243deb742!2sUnited%20States!5e0!3m2!1sen!2sus!4v1679450222138!5m2!1sen!2sus" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="contact-us-right-column">
                <h3>CONTACT DETAILS</h3>

                <a id="msg"><!-- On mobile screen, form submission will keep page from scrolling up on reload --></a>
                <form action="contact.php#msg" method="POST">
                    <input name="name" type="text" placeholder="Name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>" required="required"><br>
                    <input name="email" type="email" placeholder="Email Address" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>" required="required"><br>
                    <input name="phone" type="text" placeholder="Phone Number" class="form-control" value="<?php echo isset($_POST['phone']) ? $phone : ''; ?>"><br>
                    <div class="form-group">
                        <label>Availability:</label>
                        <select class="form-control" name="contactTime" required="required">
                            <option value="">Best Time To Call</option>
                            <option>Any Time</option>
                            <option>9:00 a.m. - 1:00 p.m.</option>
                            <option>1:00 p.m. - 5:00 p.m.</option>
                            <option>5:00 p.m. - 8:00 p.m.</option>
                        </select>
                    </div>
                    <label>Message</label>
                    <textarea name="message" class="form-control" style="height:200px" value=""><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
                    <br>
                    <input name="submit" type="submit" value="Send">
                </form>
                <?php if ($msg != '') : ?>
                    <div class="<?php echo $msgClass; ?>"><?php echo $msg; ?></div>
                    <!--<div style="background-color: #e4f2ff; border: 1px solid #0c68b5; border-radius: 4px; padding: 15px; margin-top: 20px"><?php echo $msg; ?></div>-->
                <?php endif; ?>
            </div>
        </section>

    </main>

<?php include 'footer.php'; ?>