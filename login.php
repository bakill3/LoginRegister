<?php

require 'init.php';
session_start();
if(isset($_POST['submit'])){

	$email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email'])); //PROTECTED AGAINST SQL INJECTION AND HTML/JS INJECTION
	$password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password'])); //PROTECTED AGAINST SQL INJECTION AND HTML/JS INJECTION

	//YOU SHOULD also encrypt passwords (I advise PASSWORD_HASH)

	//$email = htmlspecialchars($email);
	//$password = htmlspecialchars($password);

	$error=false;
	
		if(!empty($email) && !empty($password)){
			$length_email = strlen($email); //how many characters in
			$length_password = strlen($password); //how many characters in
			if ($length_password < 128 && $length_email < 128) { //user can delete the maxlength="128" by inspecting element
				//check if it matches
				$sql = " SELECT `email` FROM `users` WHERE `email` = '$email' AND `password` = '$password'; ";
				$result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result)>0){
					$error = false;
				}else{
					$error = true;
				}
			
				if($error){
					echo "Error in email or/and password.";
				}
				if(!$error){
					//login
					$_SESSION['email']=$email;
					echo "Logged in.";
					header("Location: welcome.php");
					exit(0); //close header location
				}
			} else {
				echo "Max lenght is 127";
			}

		}else{
			echo "Fill in all the details.";
		}

}
?>


<b><?php   if(isset($_SESSION['email'])){echo 'You are already logged in.';}else{ echo 'Log in:';  ?></b>
<br>
<br>

<form method="post">

  Email address:
  <br>
  <input type="email" name="email" maxlength="128">
  <br>
  <br>
  
  Password:
  <br>
  <input type="password" name="password" maxlength="128">
  <br>
  <br>
  
  <input type="submit" name="submit" value="Submit">
  
</form>

<?php } ?>
