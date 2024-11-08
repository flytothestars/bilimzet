<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'php_mailer/src/Exception.php';
require 'php_mailer/src/PHPMailer.php';
require 'php_mailer/src/SMTP.php';

$mail = new PHPMailer;
    //Enable SMTP debugging. 
    //Set PHPMailer to use SMTP.
$mail->IsSMTP(); // enable SMTP
$mail->CharSet = "UTF-8";
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
    //Provide username and password     
    $mail->Username = "malkin.artemnik3210";
    $mail->Password = "IzlFAc8FK2R0btYo";
    //If SMTP requires TLS encryption then set it
    $mail->SMTPSecure = "ssl";
    //Set TCP port to connect to 
    $mail->Port = 465;
    $mail->From = "malkin.artemnik3210@gmail.com";  
    $mail->FromName = "Support";
    $mail->addAddress("markviktor2018@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = "Тестовое сообщение от сайта";
    $mail->Body = "Здравствуйте Пользователь!<br><br>Какое-то тестовое сообщение от сайта!";
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    else {
           echo 'Mail Sent Successfully';
    }
	
?>
