<?
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mailto=$_REQUEST['to'];
$subject=$_REQUEST['tema'];
$message=$_POST['message'];
$files=$_REQUEST['files'];

$files=unserialize($files);
$message=str_replace("#","&",$message);

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
		$mail->Password = "tsgfzcfglairggdl";
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "ssl";
		//Set TCP port to connect to 
		$mail->Port = 465;
		$mail->From = "malkin.artemnik3210@gmail.com";  
		$mail->FromName = "Kcppk";
		$mail->addAddress($mailto);
		$mail->isHTML(true);
		$mail->Subject = $subject;
		$mail->Body = $message;
		
		foreach($files as $file) {
			$mail->AddAttachment($file, basename($file));
		}
		
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		else {
			   echo 'Mail Sent Successfully';
		}

?>
