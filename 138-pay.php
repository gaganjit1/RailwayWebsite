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
	if (isset($_SESSION['train'])){
		$train = $_SESSION['train'];
		$sd = $_SESSION['StationDep'];
		$sa = $_SESSION['StationArr'];
		$coach = $_SESSION['coach'];
		$date = $_SESSION['datepicker'];
		$tick = $_SESSION['tickets'];
		$cabin = $_SESSION['Cabin'];
		$total = $_SESSION['total'];
		$crnum = $_POST['crnum'];
		try{
		$query = "EXEC dbo.BookCabin '" . $username . "', '" . $date . "', '" . $sd . "', '" . $sa . "', '" . $tick . "', '" 
										. $cabin . "', '" . $train . "', '" . $coach . "', '" . $crnum . "', '" . $total . "'";
		$stmt = $conn->prepare($query);	
		$stmt->execute();
		//echo '<font color="white">' . $query .'<br></font>';	
		$rows = $stmt->fetchAll();
		$num = count($rows);

		$Return = '';
		$Message = '';
		foreach ($rows as $row) {
			$Return = $row["Return"];
			if ($Return == 'Error'){
				$Message = $row["Message"];
			}
		}
	
		if ($Return == '0'){
			file_put_contents ( "Log.txt" ,"\nUser:" . $username . "	Query:'" . $query . "'		SUCCESS", FILE_APPEND | LOCK_EX);
			header('refresh:0;url=/send-emailconfirm.php');
		}
		else{
			file_put_contents ( "Log.txt" ,"\nUser:" . $username . "	Query:'" . $query . "'		FAILED", FILE_APPEND | LOCK_EX);
		}
		
		}
		catch( PDOException $Exception ) {
			file_put_contents ( "Log.txt" ,"\nUser:" . $username . "	Query:'" . $query . "'		FAILED", FILE_APPEND | LOCK_EX);
		}
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


