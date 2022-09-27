
<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_STRICT);
	ini_set('display_errors', 1);
	include "classes/class.phpmailer.php";

	//Receiver Info
	 $email = "larsderover@hotmail.com";
	 $name = "Gebruiker";
 	 $recoverpwlink = "".$link."/forgot_password_reset.php?key=".$key."&email=".$email_reg;

	//Sender Info
	 $sender_name = "planjegesprek@lesonline.nu"; //naam van de 
 	 $sender_email = "planjegesprek@lesonline.nu";
	 $sender_password = "homgmcs7";
	
	 $mail_subject = "Deelnemen aan de speurtocht";
	 $message = '<html>Zet hier het bericht</html>'; 
	
	 $mail = new PHPMailer;
	 $mail->IsSMTP();
 	 $mail->Host = "mail.antagonist.nl";
	 $mail->Port = 465;
	 $mail->SMTPAuth = true;
	 $mail->SMTPDebug = 1;
	 $mail->SMTPSecure = "ssl";
	 $mail->Username = $sender_email;
	 $mail->Password = $sender_password;
	 $mail->AddReplyTo($sender_email, $sender_name);
	 $mail->SetFrom($sender_email,$sender_name);
	 $mail->Subject = $mail_subject;
	 $mail->AddAddress($email, $name);
	 $mail->MsgHTML($message);
	 $send = $mail->Send();
?>