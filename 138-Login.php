<?php
include('/menu.php');

//session_start();
if(isset($_POST['Submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$output = exec("C:\Python27\python.exe 138-Python.py authenticate " . $username . " " . $password . " -V 2>&1 ");

	if($output == 'Succeeded!')
	{
		$salt = exec("C:\Python27\python.exe 138-Python.py salt " . $username . " -V 2>&1 ");
		$hashpass = exec("C:\Python27\python.exe 138-Python.py md5 " . $username ." " . $password . " -V 2>&1 ");

		$_SESSION['username']=$username;
		$_SESSION['hashpass']=$hashpass;

		$output2 = exec("C:\Python27\python.exe 138-Python.py authpage " . $username . " " . $hashpass . " -V 2>&1 ");
		
		if ($output2 == 'Succeeded!')
		{
			echo '<br><div class="white">Logging in...</div><br>';
			header('refresh:2;url=/138-secure.php');
		}
		else goto page;

	}
	
	else if($output == 'Failed!'){
		echo '<div class="container"><br>';
		echo '<span class="white">Login: </span><br>';
		echo '<div class="newwhite"><font color="Red"> Username and/or password incorrect! </font></div>';
		goto page;
		}
	
	else {
		echo '<div class="container"><br>';
		echo '<span class="white">Login: </span><br>';
		echo '<div class="newwhite"><font color="Red"> Login Failed! </font></div>';
		goto page;
	}
}

else {
//admin login form
	echo '<div class="container"><br>';
	echo '<span class="white">Login: </span>';
	echo '<br><br>';
	page:
	echo '<form name="login" id="login" method="post" action="138-Login.php">
	<font color="White">Username</font>
	<input type="username" name="username"><br></input>
	<font color="White">Password</font>
	<input type="password" name="password"><br></input>
	<input type="submit" value="Submit" name="Submit" >
	
	<input type="submit" name="reg_button" value="Register" name="register-btn" >
	</form></div>';
	if(isset($_POST['reg_button'])){
		header('refresh:0;url=/138-Register.php');
	}
}

?>