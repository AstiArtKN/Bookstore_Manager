<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
//echo 'Trang includes';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//ham gui mail
function sendMail($emailTo, $subject, $content){
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

//Load Composer's autoloader (created by composer, not included with PHPMailer)
//require 'vendor/autoload.php';
//Create an instance; passing `true` enables exceptions

$mail = new PHPMailer(true);
//nwmt zcuy zmyv spiw
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'khiemnguyen1350@gmail.com';                     //SMTP username
    $mail->Password   = 'nwmtzcuyzmyvspiw';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('khiemnguyen1350@gmail.com', 'Khiem-Nguyen');
    $mail->addAddress($emailTo);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail -> CharSet = 'UTF-8';
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    =  $content;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->SMTPOptions = array(
    'ssl' => [
        'verify_peer' => true,
        'verify_depth' => 3,
        'allow_self_signed' => true
        //'peer_name' => 'smtp.example.com',
        //'cafile' => '/etc/ssl/ca_cert.pem',
    ],
);
    
    return $mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}