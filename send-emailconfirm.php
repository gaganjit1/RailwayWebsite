<?php 
include('/menu.php');
require 'PHPMailerAutoload.php';
require '/class.phpmailer.php';

$server = "GAGAN-DP";

$email = '';
$username = '';
if (isset($_SESSION['username']) && isset($_SESSION['train'])){
$username = $_SESSION['username'];
$train = $_SESSION['train'];
$sd = $_SESSION['StationDep'];
$sa = $_SESSION['StationArr'];
$coach = $_SESSION['coach'];
$date = $_SESSION['datepicker'];
$tick = $_SESSION['tickets'];
$cabin = $_SESSION['Cabin'];
$total = $_SESSION['total'];

$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		
$query = "DECLARE @var nvarchar(50) = '" . $username . "' select email from users where user_login = @var UNION select email from employee where emp_ID = @var";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);
foreach ($rows as $row) {

	$email = $row{"email"};
}
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

 
$mail->Subject = "Your Recent Order";

$message = 
"INVOICE
<br />
<br />
" . $tick . " tickets for:" . "<br />
". "Username: ". $username ."<br />
". "Train: ". $train ."<br />
". "Depart: ". $sd ."<br />
". "Arrive: ". $sa ."<br />
". "Coach: ". $coach ."<br />
". "Date: ". $date ."<br />
". "Cabin: ". $cabin ."<br />
<br />
". "TOTAL: $". $total ."<br />";


$mail->Body = $message;
 
if(!$mail->Send()){
    echo '<font color="white">Booking Confirmed!<br />Redirecting to login page in 3 seconds...</font>';
	header('refresh:3;url=/138-secure.php');
}
else{
    echo '<font color="white">Booking Confirmed!<br />A receipt has been sent to your email.<br />Redirecting to login page in 3 seconds...</font>';
	header('refresh:3;url=/138-secure.php');
}


