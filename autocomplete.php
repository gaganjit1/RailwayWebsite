<?php

$server = "GAGAN-DP";

$choice = $_GET['choice'];
$train = $_GET['train'];
$sd = $_GET['sd'];
$sa = $_GET['sa'];
$coach = $_GET['coach'];
$date = $_GET['date'];
$tick = $_GET['tick'];

$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		


if ($choice == 't'){
	$query = "SELECT distinct station FROM [RailwayER].[dbo].[schedulev2] WHERE name = '" . $train . "'";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	$num = count($rows);
	echo "<option value= ''>Please Select an Option</option>";
	foreach ($rows as $row) {

		echo "<option value= '" .$row{"station"}. "'>" . $row{"station"} . "</option>";
	}
}	


else if ($choice == 'sd'){
	
	$query = "SELECT distinct b.station from(SELECT * from [schedulev2] WHERE name = '" . $train . "') a INNER JOIN schedulev2 b on a.name = b.name
				WHERE a.station = '" . $sd . "' and a.order_num < b.order_num and a.station != b.station";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	$rows = $stmt->fetchAll();
	$num = count($rows);
	echo "<option value= ''>Please Select an Option</option>";
	foreach ($rows as $row) {

		echo "<option value= '" .$row{"station"}. "'>" . $row{"station"} . "</option>";
	}
}	



else if ($choice == 'list'){
	
	$query =   "exec dbo.GetRemainingSeatsv2 '" . $train . "', '" . $date . "', '" . $sd . "', '" . $sa . "', '" . $coach . "', '" . $tick . "'";
	if ($train == "" || $date == "" || $sd == "" || $sa == "" || $coach == "" || $tick == ""){
	}
	else{
		$availablecabins = array();
		$availabletickets = array();
		$stmt = $conn->prepare($query);	
		$stmt->execute();
		//echo '<font color="white">' . $query .'<br></font>';	
		$rows = $stmt->fetchAll();
		$num = count($rows);
		if ($num > 0){
			echo '<br><h5><font color="white">' . "Cabin" . "....." . "Seats left" . '</font></h5>';
			
			foreach ($rows as $row) {
				array_push($availablecabins,$row["cabin_id"]);
				array_push($availabletickets,$row["remaining_seats"]);
				echo '<h5><font color="white">' . ".   " . $row["cabin_id"] . ".............." . $row["remaining_seats"] . '</font></h5>';
			
			}
			
			?>
	
			<?php echo '<br><h5 class="white">Cabin:<br></h5>';?>

			  <select name="Cabin" id="Cabin">
				<option selected="selected" value="">Please Select an Option</option>
				<?php 
				for($i=0; $i<sizeof($availablecabins); $i++) {
					echo "<option value= '" . $availablecabins[$i] . "'>" . $availablecabins[$i] . "</option>";
				}
				?>
			  </select><br><br>



	

			<input type="Submit" id="Submit" value="Submit" name="Submit" style="display:none; width: 84px; height: 30px;">
			</form>

			
			<script>
			$("#Cabin").change(function() {
				if ($("#Cabin").val() === null || $("#Cabin").val() == ""){		
					$("#Submit").css("display", "none");				
				}
				else {
					$("#Submit").css("display", "block");
				}
			});
			</script>
			<?php
		}
		
		else{
			echo '<br><h5><font color="red">No Seats Found!</font></h5>';
		}
	
	
	}

}
?>

