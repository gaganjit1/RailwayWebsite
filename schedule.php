<?php
include('/menu.php');
$server = "GAGAN-DP";
?>
<div class="Portal">
<?php

$conn = new PDO("sqlsrv:Server=" . $server ."\SQLEXPRESS;Database=RailwayER", "webserver", "KirklandWater1");		

$query = "select * from dbo.Northbound";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);

if (count($rows) > 0){
echo '<h5 class="yellow">Northbound Schedule</h5>';
echo '<table class="white" border="1" style="font-size:16px;"><tr><td></td> ';
echo '<td>StationA</td>';
echo '<td>StationB</td>';
echo '<td>StationC</td>';
echo '<td>StationD</td>';
echo '<td>StationE</td>';
echo '<td>StationF</td>';
echo '<td>StationG</td>';
echo '</tr>'; 

foreach ($rows as $row) {
	echo '<td>' . $row["name"] . '</td>';
	echo '<td align="center">' . $x = ($row["StationA"] === NULL)?'':date ('H:i',strtotime($row["StationA"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationB"] === NULL)?'':date ('H:i',strtotime($row["StationB"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationC"] === NULL)?'':date ('H:i',strtotime($row["StationC"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationD"] === NULL)?'':date ('H:i',strtotime($row["StationD"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationE"] === NULL)?'':date ('H:i',strtotime($row["StationE"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationF"] === NULL)?'':date ('H:i',strtotime($row["StationF"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationG"] === NULL)?'':date ('H:i',strtotime($row["StationG"])) . '</td></tr>';
	

}
echo '</table><br><br>';
}


$query = "select * from dbo.Southbound";
$stmt = $conn->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll();
$num = count($rows);

if (count($rows) > 0){
echo '<h5 class="yellow">Southbound Schedule</h5>';
echo '<table class="white" border="1" style="font-size:16px;"><tr><td></td> ';
echo '<td>StationG</td>';
echo '<td>StationF</td>';
echo '<td>StationE</td>';
echo '<td>StationD</td>';
echo '<td>StationC</td>';
echo '<td>StationB</td>';
echo '<td>StationA</td>';
echo '</tr>'; 

foreach ($rows as $row) {
	echo '<td>' . $row["name"] . '</td>';
	echo '<td align="center">' . $x = ($row["StationG"] === NULL)?'':date ('H:i',strtotime($row["StationG"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationF"] === NULL)?'':date ('H:i',strtotime($row["StationF"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationE"] === NULL)?'':date ('H:i',strtotime($row["StationE"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationD"] === NULL)?'':date ('H:i',strtotime($row["StationD"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationC"] === NULL)?'':date ('H:i',strtotime($row["StationC"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationB"] === NULL)?'':date ('H:i',strtotime($row["StationB"])) . '</td>';
	echo '<td align="center">' . $x = ($row["StationA"] === NULL)?'':date ('H:i',strtotime($row["StationA"])) . '</td></tr>';
}
echo '</table><br><br>';
}


?>
</div>
