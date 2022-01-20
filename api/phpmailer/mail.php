<?php
require 'PHPMailer.php';
require 'SMTP.php';
require 'Exception.php';
require 'OAuth.php';
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);


try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    require "../../config.php";                                    //Load the config file
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $config['smtp']['host'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = $config['smtp']['auth'];                        //Enable SMTP authentication
    $mail->Username   = $config['smtp']['user'];                    //SMTP username
    $mail->Password   = $config['smtp']['password'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $config['smtp']['port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet   = 'UTF-8';
    $mail->Encoding  = 'base64';
    //Recipients
    $mail->setFrom($config['smtp']['mail'], 'Logik-Riddle');
    /*
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */
    //Content
    $mailfooter = '<br><br>Adrian Schauer<br>Wilhelmstraße 7b<br>3032 Eichgraben, Austria';
    $mailfooternohtml = '
    Adrian Schauer
    Wilhelmstraße 7b
    3032 Eichgraben, Austria';
    //echo 'Message has been sent';
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
