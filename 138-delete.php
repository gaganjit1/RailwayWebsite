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
		
		$query = "SELECT * FROM dbo.booking WHERE invoice_num = ".$cancel."";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		$rows = $stmt->fetchAll();
		$num = count($rows);

		if ($num != 0){
			$success = 0;
		}

	}

	if ($success == 1){
		echo '<font color="white">Successfully Canceled!</font>';
		header('refresh:3;url=/138-secure.php');
	}
	else{
		echo '<font color="white">Cancellation failed!</font>';
		header('refresh:3;url=/138-secure.php');
	}
}

?>