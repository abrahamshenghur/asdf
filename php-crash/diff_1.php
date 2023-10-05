<?php

use PHPMailer\PHPMailer\PHPMailer;
// Message Vars
$msg = '';
$msgClass = '';

// Check Required Fields
if (!empty($email) && !empty($name) && !empty($phone) && !empty($message)) {
    // Passed
    // Check Email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        // Failed
        $msg = 'Please use a valid email';
        $msgClass = 'alert-danger';
    } else {
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
    }
} else {
    // Failed
    $msg = 'Please fill in all fields';
    $msgClass = 'alert-danger';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | San J Motors</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="style.css">-->
    <style>
        <?php include "style.css" ?>
    </style>

</head>

<body class="wrapper">
    <header class="header">
        <div class="overlay"></div>
        <div class="header-top">
            <div class="container">
                <div class="header-top-list">
                    <li>
                        <a href="mailto:info@dealersite.com" class="header-top-link">
                            <i class="fa fa-envelope"></i><span>info@dealersite.com</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="header-top-link">
                            <i class="fa fa-map-marker"></i><span>123 Maple St., Somewhere, SS 38382</span>
                        </a>
                    </li>
                </div>
            </div>
        </div>
        <div class="header-bottom">
            <div class="container">
                <a href="index.html">
                    <img style="height: 50px" src="images/logos/logo-1.jpg"></img>
                </a>
                <nav>
                    <div class="toggle-menu" id="toggle__menu">
                        <i class="fa fa-bars"></i>
                    </div>
                    <ul class="nav-list" id="nav__menu">
                        <div class="nav-sidebar-top">
                            <a href="#">
                                <img style="height: 50px" src="images/logos/logo-1.jpg"></img>
                            </a>
                            <div class="close-menu" id="close__menu">
                                <i class="fa fa-times"></i>
                            </div>
                        </div>
                        <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="inventory.html">Inventory</a></li>
                        <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
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



    <!-- ============================================ -->
    <!--                    FOOTER                    -->
    <!-- ============================================ -->
    <footer>
        <div class="footer-top">
            <div class="footer-container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <a class="logo" href="index.html">
                            <img style="height: 30px" src="images/logos/logo-1-no-background.jpg"></img>
                        </a>
                        <p class="section-text">
                            Find your next vehicle here with us. We provide many vehicles that can suit your needs at an affordable price.
                        </p>
                    </div>
                    <ul class="contact-list">
                        <li><i class="fa fa-phone gray"></i><span> (555) 555-5555</span></li>
                        <li><i class="fa fa-map-marker gray"></i><span> 123 Maple St., Somewhere, SS 38382</span></li>
                        <li><i class="fa fa-envelope gray"></i><span> info@dealersite.com</span></li>
                    </ul>
                </div>
                <div class="footer-content">
                    <h3 class="primary">OPENING HOURS</h3>
                    <table>
                        <tbody>
                            <tr>
                                <th>MON:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>TUE:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>WED:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>THU:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>FRI:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>SAT:</th>
                                <td>9:00am - 5:30pm</td>
                            </tr>
                            <tr>
                                <th>SUN:</th>
                                <td>Closed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="footer-content">
                    <div class="links">
                        <h3 class="primary">LINKS</h3>
                        <ul>
                            <li><a class="white" href="index.html">Home</a></li>
                            <li><a class="white" href="inventory.html">Inventory</a></li>
                            <li><a class="white" href="contact.html">Contact</a></li>
                            <li><a class="white" href="about.html">About</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-content">
                    <h3 class="primary">SOCIAL MEDIA</h3>
                    <ul class="social-list">
                        <li><a class="white" href="https://www.youtube.com"><i class="fa fa-youtube gray"></i></a></li>
                        <li><a class="white" href="https://www.facebook.com"><i class="fa fa-facebook gray"></i></a></li>
                        <li><a class="white" href="https://www.instagram.com"><i class="fa fa-instagram gray"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <p class="copyright">
                    © 2022 <a href="#">webmoapps.com</a>. All Rights Reserved
                </p>
            </div>
        </div>
    </footer>

    <script>
        const navMenu = document.getElementById("nav__menu"),
            toggleMenu = document.getElementById("toggle__menu"),
            closeMenu = document.getElementById("close__menu"),
            overlay = document.querySelector(".overlay")

        toggleMenu.addEventListener("click", () => {
            navMenu.classList.toggle("show-menu");
            overlay.classList.toggle("active");
        })

        closeMenu.addEventListener("click", () => {
            navMenu.classList.remove("show-menu");
            overlay.classList.remove("active");
        })
    </script>
</body>

</html>