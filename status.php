<?php
include('/menu.php');

$server = "GAGAN-DP";
?>
<div class="portal">

<?php 

$availablecabins = array();
$availabletickets = array();
//session_start();
if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];
?>

<h3 class="white">Train Information</h3>
<br>

<?php 

$output = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
if($output == 'Succeeded!' && ctype_digit ($username) == TRUE)
{

try {
$conn = new PDO("sqlsrv:Server=" . $server . "\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");
}
catch(PDOException $exception){
echo "Connection error: " . $exception->getMessage();
}

$query = "select trainID from employee where emp_ID = '" . $username . "'";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);
foreach ($rows as $row) {
	if ($row["trainID"] === NULL){
		
	} 
	else{
		echo '<h5 class="white">Your Train:</h5>';
		echo '<h4 class="white">'.$row["trainID"].'<br><br></h4>';
	}
}

$query = "select stationName from employee where emp_ID = '" . $username . "'";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);
foreach ($rows as $row) {
	if ($row["stationName"] === NULL){
		
	} 
	else{
		echo '<h5 class="white">Your Station:</h5>';
		echo '<h4 class="white">'.$row["stationName"].'<br><br></h4>';
	}
}



$query = "select first_name, last_name, job_type, email from employeesecure where trainID = (select trainID from employee where emp_ID = '" . $username . "')";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);

if (count($rows) > 0){
echo '<h5 class="white">Serving on your train...</h5>';
echo '<table class="white" border="1" style="font-size:16px;"><tr><td>Name</td> ';
echo '<td>Position &nbsp;&nbsp;&nbsp;</td>';
echo '<td>Email</td>';
echo '</tr>'; 

foreach ($rows as $row) {
	echo '<td>' . $row["first_name"] . ' ' . $row["last_name"] . '</td>';
	echo '<td>' . $row["job_type"] . '</td>';
	echo '<td>' . $row["email"] . '</td></tr>';
}
echo '</table><br><br>';
}




$query = "select a.trainID, b.stationName, a.time from
		(Select trainID, max(time) as [time] from arrives 
		group by trainID) a
		inner join arrives b on a.trainID=b.trainID and a.time = b.time
		order by trainID";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);

echo '<h5 class="white">Station Status</h5>';
echo '<table class="white" border="1" style="font-size:16px;"><tr><td>&nbsp;&nbsp;&nbsp; Train Name &nbsp;&nbsp;&nbsp;</td> ';
echo '<td>&nbsp;&nbsp;&nbsp; Station At &nbsp;&nbsp;&nbsp;</td>';
echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Last Refreshed &nbsp;&nbsp;&nbsp;</td>';
echo '</tr>'; 

foreach ($rows as $row) {
	echo '<td>' . $row["trainID"] . '</td>';
	echo '<td>' . $row["stationName"] . '</td>';
	echo '<td>' . $row["time"] . '</td></tr>';
}
echo '</table><br><br>';


?>

</div>

<?php 

}
else { 
echo '<h5 class="white">Only employees can view this page.</h5>';
echo '<h5 class="white">Please log in if you are an employee.</h5>'; 
}


}
else { 
echo '<h5 class="white">Only employees can view this page.</h5>';
echo '<h5 class="white">Please log in if you are an employee.</h5>'; 
}?>