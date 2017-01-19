<?php
include('/menu.php');
$server = "GAGAN-DP";

if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];


$output = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
if($output == 'Succeeded!')
{

	echo '<div class="portal">';
	echo '<span class="white">My Upcoming Bookings... <br><br></span>';
	$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		
	$query = "SELECT invoice_num,book_date, station_in, station_out, tickets_bought, cabin_id from booking 
				WHERE user_login = '" . $username . "' and book_date > getdate() ORDER BY book_date";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	$num = count($rows);
	echo '<table class="white" border="1" style="font-size:16px;"><tr><th>Invoice #</th> ';
	echo '<th>Travel Date</th><th>Departure</th><th>Arrival</th><th># of Tickets</th><th>Cabin ID</th>';
	echo '</tr>'; 
	
	foreach ($rows as $row) {
		echo '<td>' . $row["invoice_num"] . '</td>';
		echo '<td>' . $row["book_date"] . '</td>';
		echo '<td>' . $row["station_in"] . '</td>';
		echo '<td>' . $row["station_out"] . '</td>';
		echo '<td>' . $row["tickets_bought"] . '</td>';
		echo '<td>' . $row["cabin_id"] . '</td></tr>';
	}
	echo '</table><br>';
	
	if ($num > 0){
		echo '<form name="cancelbook" id="cancelbook" method="post" action="138-cancel.php">
		<input type="submit" value="Cancel a booking..." name="Cancel" style="width: 140px; height: 26px;"></form>';
	}
	echo '<br><br>';
	echo '<span class="white">New booking <br></span>';

	page:
	echo '<form name="newbook" id="newbook" method="post" action="138-Booking.php">
		<input type="submit" value="Create" name="Create" style="width: 84px; height: 30px;">
		</form></div>';


}
}
else{
	echo '<font color="white">You are not logged in.</font><br>';
	echo '<font color="white">Redirecting you to login page...</font><br>';
	header('refresh:3;url=/138-Login.php');
}
?>


