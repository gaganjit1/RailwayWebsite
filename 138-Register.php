<?php
include('/menu.php');
if(isset($_POST['Submit'])){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$dob = $_POST['dob'];
	$email = $_POST['email'];
	$phnumber = $_POST['phnumber'];
	

	if($username == '' || $password == '' || $fname == '' || $lname == '' || $dob == '' || $email == '' || $phnumber == ''){
	echo '<div class="container"><br>';
	echo '<span class="white">Register: </span><br>';
	echo '<div class="newwhite"><font color="Red"> Please fill out all fields. </font></div>';
	goto page;
	}
	

	$re = '/^.*[a-zA-Z].*$/';
	$validusername = preg_match($re, $username, $matches, PREG_OFFSET_CAPTURE);
	
	if($validusername == 0){
	echo '<div class="container"><br>';
	echo '<span class="white">Register: </span><br>';
	echo '<div class="newwhite"><font color="Red"> Username must have at least 1 letter. </font></div>';
	goto page;
	}
	

	//THANKS TO NEIL WALLS WHO CREATED REGEX USED HERE
	$re = '#^(((((((0?[13578])|(1[02]))[\.\-/]?((0?[1-9])|([12]\d)|(3[01])))|(((0?[469])|(11))[\.\-/]?((0?[1-9])|([12]\d)|(30)))|((0?2)[\.\-/]?((0?[1-9])|(1\d)|(2[0-8]))))[\.\-/]?(((19)|(20))?([\d][\d]))))|((0?2)[\.\-/]?(29)[\.\-/]?(((19)|(20))?(([02468][048])|([13579][26])))))$#';
	$validdob = preg_match($re, $dob, $matches, PREG_OFFSET_CAPTURE);
	
	if($validdob == 0){
	echo '<div class="container"><br>';
	echo '<span class="white">Register: </span><br>';
	echo '<div class="newwhite"><font color="Red"> Invalid Date of Birth. </font></div>';
	goto page;
	}	
	
	
	
	//THANKS TO ORIGINAL PERSON WHO CREATED REGEX USED HERE
	$re = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
	$validemail = preg_match($re, $email, $matches, PREG_OFFSET_CAPTURE);
	
	if($validemail == 0){
	echo '<div class="container"><br>';
	echo '<span class="white">Register: </span><br>';
	echo '<div class="newwhite"><font color="Red"> Invalid email. </font></div>';
	goto page;
	}
	
	
	
	
	$re = '/^((\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4})$|^([0-9]{10})$/';
	$validnum = preg_match($re, $phnumber, $matches, PREG_OFFSET_CAPTURE);
	
	if($validnum == 0){
	echo '<div class="container"><br>';
	echo '<span class="white">Register: </span><br>';
	echo '<div class="newwhite"><font color="Red"> Invalid phone number. </font></div>';
	goto page;
	}
	
	
	$array = array('"'.$username.'"','"'.$password.'"','"'.$fname.'"','"'.$lname.'"','"'.$dob.'"','"'.$email.'"','"'.$phnumber.'"');

	$output = exec('C:\Python27\python.exe 138-Python.py register ' . json_encode($array) . ' -V 2>&1 ');

	if($output == 'Succeeded!')
	{
		$_SESSION['username'] = $username;
		$_SESSION['email'] = $email;
		header('refresh:0;url=/send-email.php');
	}

	else if($output == 'User already exists!'){
		echo '<div class="container"><br>';
		echo '<span class="white">Register: </span><br>';
		echo '<div class="newwhite"><font color="Red"> User already exists! </font></div>';
		goto page;
		}
		
	else if($output == 'Invalid date!'){
		echo '<div class="container"><br>';
		echo '<span class="white">Register: </span><br>';
		echo '<div class="newwhite"><font color="Red"> Invalid Date of Birth! </font></div>';
		goto page;
		}
	
	else {
		echo '<div class="container"><br>';
		echo '<span class="white">Register: </span><br>';
		echo '<div class="newwhite"><font color="Red"> Registration Failed! </font></div>';
		goto page;
	}
}

else {
//admin register form
echo '<div class="container"><br>';
echo '<span class="white">Register: </span>';
echo '<br><br>';
page:
?>
<form name="register" id="register" method="post" action="138-Register.php">
<font color="White">Username</font>
<input type="username" name="username" placeholder="Username" value="<?php echo (isset($_POST['username']))?$_POST['username']:''; ?>" style="
    margin-left: 37px;"><br><br>

<font color="White">Password</font>
<input type="password" name="password" placeholder="Password" style="
    margin-left: 38px;"><br><br>

<font color="White">First Name</font>
<input type="username" name="fname" placeholder="First Name" value="<?php echo (isset($_POST['fname']))?$_POST['fname']:''; ?>" style="
    margin-left: 25px;"><br><br>
	
<font color="White">Last Name</font>
<input type="username" name="lname" placeholder="Last Name" value="<?php echo (isset($_POST['lname']))?$_POST['lname']:''; ?>" style="
    margin-left: 25px;"><br><br>
	
<font color="White">Date of Birth</font>
<input type="username" name="dob" placeholder="MM-DD-YYYY" value="<?php echo (isset($_POST['dob']))?$_POST['dob']:''; ?>"><br><br>

<font color="White">Email</font>
<input type="username" name="email" placeholder="Email" value="<?php echo (isset($_POST['email']))?$_POST['email']:''; ?>" style="
    margin-left: 75px;"><br><br>

<font color="White">Phone #</font>
<input type="username" name="phnumber" placeholder="Phone Number" value="<?php echo (isset($_POST['phnumber']))?$_POST['phnumber']:''; ?>" style="
    margin-left: 45px;"><br><br>

<input type="submit" value="Submit" name="Submit" style="width: 64px; height: 29px;">
</form></div>
<?php

}

?>