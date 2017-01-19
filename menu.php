<link rel="stylesheet" type="text/css" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Signika' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

</head>
<body>	

<?php 
try{
session_start();
if (isset($_SESSION['hashpass'])){
$username = $_SESSION['username'];
$hashpass = $_SESSION['hashpass'];
}
}
catch (Exception $e){
	$username = " ";
}
$page=basename($_SERVER['PHP_SELF']);

 ?>
 
 
<div id="menu">
<div class="nav">
  <li ><a <?php if ($page == "index.php") { echo 'class="active"';} ?> href="/">Home</a></li>
  <li> <a <?php if ($page == "status.php") { echo 'class="active"';} ?> href="/status.php">Status</a></li>
  <li> <a <?php if ($page == "schedule.php") { echo 'class="active"';} ?> href="/schedule.php">Schedule</a></li>
  <li> <a <?php if ($page == "contact.php") { echo 'class="active"';} ?> href="/contact.php">Contact</a></li>
  <!--<li><a href="/survey.php">Survey</a></li>-->
  <?php if(!isset($_SESSION['hashpass'])) : ?>
  <li ><a <?php if ($page == "138-Login.php") { echo 'class="active"';} ?> href="/138-Login.php">Login</a></li>
 <?php endif; ?>
 
<?php if(isset($_SESSION['hashpass'])) : ?>
  <li ><a <?php if ($page == "138-secure.php") { echo 'class="active"';} ?> href="/138-secure.php"><?php echo $username . "'s Portal"; ?></a></li>
  <li ><a name = "logout" href="/138-Login.php?link=logout">Logout</a></li>
 <?php if(isset($_GET['link'])=='logout'){
					session_unset();
					session_destroy();
					header('refresh:1;url=/138-Login.php');
					exit();
					}
			?>
<?php endif; ?>

 </div>
</div><!--/menu--> 

