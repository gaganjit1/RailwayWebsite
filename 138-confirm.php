<?php
include('/menu.php');

$server = "GAGAN-DP";

if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];

$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		


$output = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
if($output == 'Succeeded!')
{
	if (isset($_POST['train'])){
		$train = $_POST['train'];
		$sd = $_POST['StationDep'];
		$sa = $_POST['StationArr'];
		$coach = $_POST['coach'];
		$date = $_POST['datepicker'];
		$tick = $_POST['tickets'];
		$cabin = $_POST['Cabin'];
		$_SESSION['train'] = $train;
		$_SESSION['StationDep'] = $sd;
		$_SESSION['StationArr'] = $sa;
		$_SESSION['coach'] = $coach;
		$_SESSION['datepicker'] = $date;
		$_SESSION['tickets'] = $tick;
		$_SESSION['Cabin'] = $cabin;
		echo '<div class="portal">';
		echo '<h3><font color="white">Order Confirmation...</font></h3>';
		echo '<h5><br><font color ="white">'. "Train: ". $train .'<font></h5>';
		echo '<h5><font color ="white">'. "Depart: ". $sd .'<font></h5>';
		echo '<h5><font color ="white">'. "Arrive: ". $sa .'<font></h5>';
		echo '<h5><font color ="white">'. "Coach: ". $coach .'<font></h5>';
		echo '<h5><font color ="white">'. "Date: ". $date .'<font></h5>';
		echo '<h5><font color ="white">'. "Cabin: ". $cabin .'<font></h5><br>';
		
		$query = "declare @coach nvarchar(50) = '" . $coach . "'
					declare @user nvarchar(50) = '" . $username . "' 
					if @coach = 'FIRST'
					(select * from price where customer_type = 'First Class')
					else if (select count(*) from employee where emp_id = @user) = 0	
					select * from price where customer_type = 'regular'
					else select * from price where customer_type = 'employee'";
		$stmt = $conn->prepare($query);	
		$stmt->execute();
		//echo '<font color="white">' . $query .'<br></font>';	
		$rows = $stmt->fetchAll();
		$num = count($rows);
		$price = 0;
		foreach ($rows as $row) {
			$price = number_format($row["price"], 2);
			echo '<h5><font color="white">' . $row["customer_type"] . " pricing: $" . $price . " per ticket " . '</font></h5>';
		}
		echo '<h5><font color="white">' . "x " . $tick . " ticket(s) " . '</font></h5>';
		echo '<h5><font color="white"><br><br><br></font></h5>';
		echo '<br><h4><font color="white">' . "Credit Card:" . '</font></h4>';	
		echo '<h5><font color="white">' . "Input a valid 10 digit credit card number." . '</font></h5>';	
		?>
		
			<form name="confirmation" id="confirmation" method="post" action="138-pay.php" onsubmit="return validateForm()">
				<input type="input" id="crnum" name="crnum" style="width: 150px;" autocomplete="off">
				<input type="submit" id="Pay" value="Pay" name="Pay" style="width: 55px; height: 21px;">
			</form>
			<script>
			function validateForm() {
				var x = document.forms["confirmation"]["crnum"].value;
				if (( x.length != 10 ) || (x.match(/[a-z]/i)) ) {
					alert("Invalid Credit Card Number.");
					return false;
				}
				return true;
			}
			</script>
		
		
		<?php
		
		$total = number_format(($price * $tick),2);
		$_SESSION['total'] = $total;
		echo '<br><h4><font color="yellow">' . "Total: $" . $total . " " . '</font></h4>';
		echo '</div>';
	}

	else{
		echo "<font color='white'>Hmm....It seems you may be lost.</white><br>";
		echo '<font color="white">Redirecting you to your portal...</font><br>';
		header('refresh:3;url=/138-secure.php');
	}



}
}
else{
	echo '<font color="white">You are not logged in.</font><br>';
	echo '<font color="white">Redirecting you to login page...</font><br>';
	header('refresh:3;url=/138-Login.php');
}
?>


