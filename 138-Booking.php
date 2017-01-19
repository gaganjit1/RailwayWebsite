<?php
include('/menu.php');

$server = "GAGAN-DP";
$availablecabins = array();
$availabletickets = array();

if (isset($_POST['returnv'])){
	goto cont;
}
//session_start();
if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];

// receive post username
// receive post password

//echo 'pw: '.$hashpass.'<br>';
$output = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
if($output == 'Succeeded!')
{
	echo '<div class="portal">';
	echo '<h3 class="white">Book a train... <br><br></h3>';
	echo '<h5 class="white">Train Name:<br></h5>';
	
	?>
	<form name="trainview" id="trainview" method="post" action="138-confirm.php">
		  <select name="train" id="train">
		  	<option selected value="">Please Select an Option</option>
			<option value="TrainA" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainA')?'selected="selected"':''; ?>>TrainA</option>
			<option value="TrainB" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainB')?'selected="selected"':''; ?>>TrainB</option>
			<option value="TrainC" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainC')?'selected="selected"':''; ?>>TrainC</option>
			<option value="TrainD" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainD')?'selected="selected"':''; ?>>TrainD</option>
			<option value="TrainE" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainE')?'selected="selected"':''; ?>>TrainE</option>
			<option value="TrainF" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainF')?'selected="selected"':''; ?>>TrainF</option>
			<option value="TrainG" <?php echo (isset($_POST['train']) && $_POST['train'] == 'TrainG')?'selected="selected"':''; ?>>TrainG</option>
		  </select>
		  <script>
			document.getElementById(train).selectedIndex="'.$trainretain.'";
		  </script>
		<br><br>
	
	
	
	<?php echo '<h5 class="white">Departing Station:<br></h5>'; ?>
	
	  <select name="StationDep"id="StationDep">
		<option selected="selected" value="">Please Select an Option</option>
	  </select>
	
	
	
	<?php echo '<br><br><h5 class="white">Arriving Station:<br></h5>';?>
	
	  <select name="StationArr" id="StationArr">
	  	<option selected="selected" value="">Please Select an Option</option>
	  </select>

	  
	<?php echo '<br><br><h5 class="white">Tickets:<br></h5>';?>
	
	  <select name="tickets" id="tickets">
	  	<option selected="selected" value="">Please Select an Option</option>
		<option value=1>1</option>
		<option value=2>2</option>
		<option value=3>3</option>
		<option value=4>4</option>
		<option value=5>5</option>
		<option value=6>6</option>
		<option value=7>7</option>
		<option value=8>8</option>
	  </select>

	
	<?php echo '<br><br><h5 class="white">Coach:<br></h5>';?>
	
	    <h6 class="white"><input type="radio" name="coach" value="ECON" checked="checked"> Economy Class</input></h6>
		<h6 class="white"><input type="radio" name="coach" value="FIRST"> First Class</input></h6>
	<br>

	
		
	<?php	
		
	echo '<h5 class="white">Booking Date:<br></h5>';
	
	#Special Thanks to jqueryui.com for this Calendar
	$dateretain = isset($_POST['datepicker']) ? $_POST['datepicker'] : "";
	echo '
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><script>
		  $( function() {
			$( "#datepicker" ).datepicker({  minDate: new Date() });
		  } );
		  </script>
		  <input type="text" name="datepicker" id="datepicker" value="'.$dateretain.'">
			<div id="results"></div>
		  ';	

	?>
		
	<script>
	$("#train").change(function() {
		$("#StationDep").load("autocomplete.php?choice=t&train=" + $("#train").val());
		$('#StationDep').val("");
		$('#StationArr').val("");

	});
	</script>
	
	<script>
	$("#StationDep").change(function() {
		$('#StationArr').val("");

	});
	</script>
	
	<script>
	$("#train, #StationDep").change(function() {
		if ($("#StationDep").val() === null || $("#StationDep").val() == ""){
			$("#StationArr").load("autocomplete.php?choice=sd&train=" + $("#train").val() + "&sd=StationA");	
		}
		else {
			$("#StationArr").load("autocomplete.php?choice=sd&train=" + $("#train").val() + "&sd=" + $("#StationDep").val());	
		
		}
	});
	</script>
	
	<script>
	$("#train, #StationDep, #StationArr, :radio, #datepicker, #tickets").change(function() {
	$("#results").load("autocomplete.php?choice=list&train=" + $("#train").val() 
												  + "&sd=" + $("#StationDep").val()
												  + "&sa=" + $("#StationArr").val()
											   + "&coach=" + $('input[name=coach]:checked').val()
												+ "&date=" + $("#datepicker").val()
												+ "&tick=" + $("#tickets").val()
												  );	

	});
	</script>

	


	<?php

	echo '</form></div>';


	// Create connection
	try {
		$conn = new PDO("sqlsrv:Server=" . $server . "\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");
	}
	catch(PDOException $exception){
		echo "Connection error: " . $exception->getMessage();
	}
	echo '<font color="white"> Connected to Database. </font><br>';

}
}

else{
	cont:
	echo '<font color="white">You are not logged in.</font><br>';
	echo '<font color="white">Redirecting you to login page...</font><br>';
	header('refresh:3;url=/138-Login.php');
	//look back at my old code for autoredirect to login page
}

?>