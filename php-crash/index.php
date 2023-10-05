<?php
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
        echo "Yes";
        // Passed
        // Check Email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            // Failed
            $msg = 'Please use a valid email';
            $msgClass = 'alert-danger';
        } else {
            // Passed
            $toEmail = "info@westcoastmts.com";
            $subject = 'Contact Request From ' . $name;
            $body = '<h2>Contact Request</h2>
                    <h4>Name</h4><p>' . $name . '</p>
                    <h4>Phone</h4><p>' . $phone . '</p>
                    <h4>Email</h4><p>' . $email . '</p>
                    <h4>Call Me: </h4><p>' . $contactTime . '</p>
                    <h4>Message</h4><p>' . $message . '</p>
                ';

            // Email Headers
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-Type:text/html;charset=UTF-8" . "\r\n";

            // Additional Headers
            $headers .= "From: " . $name . "<" . $email . ">" . "\r\n";

            if (mail($toEmail, $subject, $body, $headers)) {
                // Email Sent
                $msg = 'Your email has been sent';
                $msgClass = 'alert-success';
            } else {
                // Failed
                $msg = 'Your email was not sent';
                $msgClass = 'alert-danger';
            }
 
        }
    } else {
        echo "No";
        // Failed
        $msg = 'Please fill in all fields';
        $msgClass = 'alert-danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/cosmo/bootstrap.min.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">My Website</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <?php if ($msg != '') : ?>
            <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? $phone : ''; ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            </div>
            <div class="form-group">
                <label>Availability:</label>
                <select class="form-control" name="contactTime" required="required">
                    <option value="">Best Time To Call Me</option>
                    <option value="any_time">Any Time</option>
                    <option value="fr9to13">9:00 a.m. - 1:00 p.m.</option>
                    <option value="fr13to17">1:00 p.m. - 5:00 p.m.</option>
                    <option value="fr17to20">5:00 p.m. - 8:00 p.m.</option>
                </select>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" class="form-control" value=""><?php echo isset($_POST['message']) ? $message : ''; ?></textarea>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>