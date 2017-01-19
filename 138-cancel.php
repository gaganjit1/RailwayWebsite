<?php
include('/menu.php');
$server = "GAGAN-DP";

if (isset($_POST['cancel'])){
	$name = $_POST['cancel'];
	$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		
	$success = 1;

	foreach ($name as $cancel){
		
		$query = "DELETE FROM dbo.booking WHERE invoice_num = ".$cancel."";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$query2 = "SELECT * FROM dbo.booking WHERE invoice_num = ".$cancel."";
		$stmt = $conn->prepare($query2);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$num = count($rows);

		if ($num != 0){
			$success = 0;
			file_put_contents ( "Log.txt" ,"\nUser:" . $username . "		Query:'" . $query . "'		FAILED", FILE_APPEND | LOCK_EX);
			
		}
		file_put_contents ( "Log.txt" ,"\nUser:" . $username . "		Query:'" . $query . "'		SUCCESS", FILE_APPEND | LOCK_EX);

	}

	if ($success == 1){
		echo '<font color="white">Successfully Canceled!</font>';
		goto refresh;
	}
	else{
		echo '<font color="white">Cancellation failed!</font>';
	}
}

if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];


$output = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
if($output == 'Succeeded!')
{

	echo '<div class="portal" style="color:white;">';
	echo '<span class="white">Select the bookings to cancel... <br><br></span>';
	$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		
	$query = "SELECT invoice_num,book_date, station_in, station_out, tickets_bought, cabin_id from booking 
				WHERE user_login = '" . $username . "' and book_date > getdate()";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	$num = count($rows);
	
	echo '<form name="cancelbook" id="cancelbook" method="post" action="138-cancel.php">';
	
	foreach ($rows as $row) {
		echo '<h5><input type="checkbox" name ="cancel[]" name ="cancel" value="'. $row["invoice_num"] .'"><td>' 
						. ' Invoice #: ' . $row["invoice_num"] . ' , &nbsp;&nbsp;';
		echo 'Booked for: ' . $row["book_date"] . ' , &nbsp;&nbsp;';
		echo $row["tickets_bought"] . ' ticket(s)' . '</input></h5>';
	}
	echo '<br>';
		
	echo'<input type="submit" value="Cancel" name="Cancel" style="width: 100px; height: 26px;"></form>';

	echo '<br>';
	
	echo '<form name="goback" id="goback" method="post" action="138-secure.php">
	<input type="submit" value="Go Back" name="Go Back" style="width: 100px; height: 26px;"></form>';

}
}
else{
	echo '<font color="white">You are not logged in.</font><br>';
	echo '<font color="white">Redirecting you to login page...</font><br>';
	header('refresh:3;url=/138-Login.php');
}
if (1 == 0){
	refresh:
	header('refresh:3;url=/138-secure.php');
}
?>


