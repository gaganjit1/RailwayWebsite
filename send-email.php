<?php 
include('/menu.php');
require 'PHPMailerAutoload.php';
require '/class.phpmailer.php';

$email = '';
$username = '';
if (isset($_SESSION['username']) && isset($_SESSION['email'])){
$username = $_SESSION['username'];
$email = $_SESSION['email'];
}

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Mailer = 'smtp';
$mail->SMTPAuth = true;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
 
 
$mail->Username = "thesmartmajor@gmail.com";
$mail->Password = "KirklandWater1";
 
$mail->IsHTML(true);
$mail->SingleTo = true;
 
$mail->From = "thesmartmajor@gmail.com";
$mail->FromName = "Railway ER";
 
$mail->addAddress($email,"User 1");

 
$mail->Subject = "Welcome to Railway ER!";
$mail->Body = "Hello,<br /><br />Thank you for joining Railway ER! <br><br>Your Username is " . $username . ".<br /><br />Sincerely, <br />Railway ER";
 
if(!$mail->Send()){
    echo '<font color="white">Message was not sent <br />PHPMailer Error: ' . $mail->ErrorInfo . '</font>';
	header('refresh:3;url=/138-Login.php');
}
else{
    echo '<font color="white">User Account Created!<br />Redirecting to login page in 3 seconds...</font>';
	header('refresh:3;url=/138-Login.php');
}


