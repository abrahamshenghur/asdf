<?php

use PHPMailer\PHPMailer\PHPMailer;
// Message Vars
$msg = '';
$msgClass = '';

// Check for Submit
if (filter_has_var(INPUT_POST, 'submit')) {
    // Get From Data
    $firstName = htmlspecialchars($_POST['firstName']);
    $message = htmlspecialchars($_POST['message']);

    // Check Required Fields
    if (!empty($email) && !empty($firstName) && !empty($phone) && !empty($message)) {
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
            $mail->Subject = 'Contact from ' . $_POST['firstName'];
            $mail->isHTML(true);
            $subject = 'Contact Request From ' . $firstName;
            $mail->Body = <<<EOT
                        <h2>Contact Request</h2>
                        <p><span style="font-weight:bold">Name: </span>$firstName</p>
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

<main>
    <section class="container bg-white">

        <div id="ContentPane" class="s45r_tert clearfix">

            <div class="ContentPane_1081863 ResponsiveTrade ResponsiveTrade_1081863">
                <div id="ResponsiveTradeFormWrapper" class="tradeFormWrapper">
                    <div class="form-intro p2" style="line-height: 30px; font-size: 20px">
                        <h2>We Will Buy Your Vehicle</h2>
                        <br>
                        <h4>Are You driving a car that you don't really love and want to trade it in?</h4>
                        <br>
                        <p>
                            Bring your car into our dealership and we will give you an instant offer.
                            <br>
                            We want your vehicle and we will pay you top dollar to put it toward a <strong>car,
                                truck or SUV</strong>.
                            <br>
                            <br>
                            Call or visit us today!
                        </p>
                        <br>
                        <p><a class="btn" href="trade">Value Your Trade</a></p> <!-- Tag needs proper use -->
                    </div>
                    <form class="p2" id="ResponsiveTradeForm" data-ajax="true" data-ajax-method="post" data-ajax-mode="replace-with" data-ajax-update="#ResponsiveTradeFormWrapper" data-ajax-success="redirect('')" data-ajax-failure="ajaxFailure" data-ajax-loading="#ResponsiveTradeFormSpinner" data-ajax-begin="$('#ResponsiveTradeFormButton').prop('disabled',true);formLeadTrackingByElementId('#TradeInventoryId', '', 'Responsive Trade Form');" data-ajax-complete="$('#ResponsiveTradeFormButton').prop('disabled',false);" data-recaptcha-id="ResponsiveTradeRecaptchaToken" data-recaptcha-site-key="" data-recaptcha-type="Undefined" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate="novalidate">

                        <div class="">
                            <div class="flex flex-wrap justify-between">
                                <div class=" form-group">
                                    <label id="lblFirstName" for="firstName">First Name:</label>
                                    <input type="text" aria-labelledby="lblFirstName" id="txtFirstName" class="form-control" name="firstName" value="<?php echo isset($_POST['firstName']) ? $firstName : ''; ?>">
                                    <span class="text-danger field-validation-valid" data-valmsg-for="firstName" data-valmsg-replace="true"></span>
                                </div>
                            </div>
                        </div>

                        <div class="none">
                            <label id="lbvehicleOptions" for="SelectedOptions"><strong>Vehicle
                                    Options:</strong></label>
                        </div>
                        <div class="flex flex-wrap check-vehicle-options">

                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="vehicleOptions" type="checkbox" aria-labelledby="lbvehicleOptions" name="SelectedOptions" value="4X4">4X4
                                </label>
                            </div>

                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="vehicleOptions" type="checkbox" aria-labelledby="lbvehicleOptions" name="SelectedOptions" value="Adjustable Pedals">Adjustable Pedals
                                </label>
                            </div>
                        </div>

                        <div class="mt2">
                            <label id="lblFeatures" for="Features">Vehicle Description and Comments:</label>
                            <textarea aria-labelledby="lblFeatures" id="txtFeatures" class="form-control form-textarea" name="Features"></textarea>
                            <span class="text-danger field-validation-valid" data-valmsg-for="Features" data-valmsg-replace="true"></span>
                        </div>

                        <div class="contact-disclaimer">
                            <div class="required-asterisk">
                                <div>
                                    <input type="checkbox" aria-label="Contact Consent" class="form-check-input" id="chkContactDisclaimerConsent9551" data-val="true" data-val-range="Please check the box to verify acknowledgement and consent." data-val-range-max="True" data-val-range-min="True" data-val-required="The ContactDisclaimerConsent field is required." name="ContactDisclaimerConsent" value="true">
                                    <label for="chkContactDisclaimerConsent9551" aria-labelledby="chkContactDisclaimerConsent9551">
                                        <strong>ACKNOWLEDGMENT AND CONSENT:</strong>
                                    </label>
                                    <span class="text-danger field-validation-valid" data-valmsg-for="ContactDisclaimerConsent" data-valmsg-replace="true"></span>
                                </div>
                                I hereby consent to receive text messages or phone calls from or on behalf of the
                                dealer or their employees to the mobile phone number I provided above. By opting in,
                                I understand that message and data rates may apply. This acknowledgement constitutes
                                my written consent to receive text messages to my cell phone and phone calls,
                                including communications sent using an auto-dialer or pre-recorded message. You may
                                withdraw your consent at any time by texting "STOP".
                            </div>
                        </div>

                        <input name="submit" type="submit" value="Send">

                        <button id="ResponsiveTradeFormButton" class="btn submitButton">
                            Submit
                            <i id="ResponsiveTradeFormSpinner" class="fas fa-spinner fa-spin fa-fw" style="display: none"></i>
                        </button>
                        <input name="__RequestVerificationToken" type="hidden" value="CfDJ8LRflBXo3w1DuyR521U-UyfOX1iAzSN_FKp7H4B-Qz4E9tyQ4Ymc_bAnhGChvHsdfuow6XepnQr05xrTxpqoGJyA2u8uAONM4P2uGo0LQ5Xr-dhftvicZcJEJs6aLA0t7CeP1qjIC_xvIWMFEIvMoPA">
                        <input name="ContactDisclaimerConsent" type="hidden" value="false">
                    </form>
                    <?php if ($msg != '') : ?>
                        <div class="<?php echo $msgClass; ?>"><?php echo $msg; ?></div>
                        <!--<div style="background-color: #e4f2ff; border: 1px solid #0c68b5; border-radius: 4px; padding: 15px; margin-top: 20px"><?php echo $msg; ?></div>-->
                    <?php endif; ?>
                    <input type="hidden" id="TradeInventoryId" name="InventoryId" value="">
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>