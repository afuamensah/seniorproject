<?php
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'Exception.php';
	require 'PHPMailer.php';
	require 'SMTP.php';

    function sendMail($recipient, $subject, $plainmsg, $msg) {
        $sender = 'herdrcontact@gmail.com';
        $senderName = 'Herdr Admin';

        $usernameSmtp = 'AKIAYYFCU3UE3XR2M6Y6';
        $passwordSmtp = 'BFLuI/dVHxwkxOgisaZBvz/hn1+LPnRsLciTl0IiZ4wW';

        $host = 'email-smtp.us-east-2.amazonaws.com';
        $port = 587;
        $mail = new PHPMailer(true);

        try {
            // Specify the SMTP settings.
            $mail->isSMTP();
            $mail->setFrom($sender, $senderName);
            $mail->Username   = $usernameSmtp;
            $mail->Password   = $passwordSmtp;
            $mail->Host       = $host;
            $mail->Port       = $port;
            $mail->SMTPAuth   = true;
            $mail->SMTPSecure = 'tls';
            //$mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

            // Specify the message recipients.
            $mail->addAddress($recipient);
            // You can also add CC, BCC, and additional To recipients here.

            // Specify the content of the message.
            $mail->isHTML(true);
            $mail->Subject    = $subject;
            $mail->Body       = $msg;
            $mail->AltBody    = $plainmsg;
            $mail->Send();
            echo '<p style="color: #fff;">Email sent!</p>' , PHP_EOL;
        } catch (phpmailerException $e) {
            echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
        } catch (Exception $e) {
            echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
        }
    }

    
?>