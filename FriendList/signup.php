<?php
	session_start();                     // start the session
	if (!isset ($_SESSION["user"])) 		// check if session variable exists
	{  											
		$_SESSION["user"] = 1;					// create the session variable when the user access this page
	}
		
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Assignement 2" />
	<meta name="keywords" content="assignment" />
	<meta name="author"   content="Apostolos Lafazanis" />
	<link rel="stylesheet" 	 href="style/style.css" />         
	<title>Sign up Page</title>
</head>
<body>
	<h1>My Friend System<br>Registration Page</h1>
		
		<!-- Sign up form  -->
		<form class = "main" action="signup.php" method="post">
			<label class = "align">Email: </label> 		<!-- Email Textbox-->
			<input type="text" name="email" value="<?php if(isset($_POST["email"])){ echo htmlentities($_POST["email"]);} ?>"/><br>
			
			<label class = "align">Profile Name:</label> 		<!-- Profile Name Textbox -->
			<input type="text" name="pName" value="<?php if(isset($_POST["pName"])){ echo htmlentities($_POST["pName"]);} ?>"/><br>
			
			<label class = "align">Password:</label>	<!-- Password Textbox -->
			<input type="password" name="pswd" /><br>
																		
			<label class = "align">Confim Password:</label>	<!-- Confirm Password Textbox -->
			<input type="password" name="confPass" /><br>	
			
			<input class = "subButton" type="submit" value="Register" />
			<input class = "resetButton" type="reset" value="Clear" />		<!-- Submit and Clear form buttons-->
		</form>
	
<?php
	$host = "feenix-mariadb.swin.edu.au";
	$user = "s101360815"; 					//Connetion details
	$pswd = "040796"; 
	$dbnm = "s101360815_db"; 


	if(isset($_POST["email"]) && isset($_POST["pName"]) && isset($_POST["pswd"]) && isset($_POST["confPass"]))
	{
		if(!empty($_POST["email"]) && !empty($_POST["pName"]) && !empty($_POST["pswd"]) && !empty($_POST["confPass"]))	
		{
			echo nl2br ("\n");
			$email = $_POST["email"];
			$profileName = $_POST["pName"];
			$password = $_POST["pswd"];				//Variable declarations
			$confirmPass = $_POST["confPass"];
			$emailPattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
			$namePattern = "/^[a-zA-Z]+$/";
			$passwordPattern = "/^[a-zA-Z0-9]+$/";
			$date = date("Y/m/d");
			$valid = true;
			
			echo "<p>";
			
			if(preg_match($emailPattern, stripcslashes($email))) // checks to see if the emaill matches the pattern
			{	
				$conn = @mysqli_connect($host, $user, $pswd, $dbnm)
						or die('Unable to connect to the server');
						
				$sqlString = "SELECT friend_email FROM friends";	//makes a connection to the database so we can get all the emails 
																	//and see if any of them matche the input the user gave
				$queryResult = @mysqli_query($conn, $sqlString)
								or die('Couldnt execute the query');
			
				
				
				while($row = mysqli_fetch_row($queryResult))
				{
					if($email == $row[0])		// if the email the user gave is in the database then display an error message
					{				
						echo nl2br("Invalid email: Email address already exists in the database." . "\n");
						$valid = false;
						break;
					}
				}
			}
			else
			{
				echo nl2br("Invalid input: The email is not correct." . "\n"); // if the email doesnt match the pattern display an error message
				$valid = false;
			}
			
			if(!preg_match($namePattern, stripcslashes($profileName))) // if the name the user gave doesnt match the pattern display an error message
			{
				echo nl2br("Invalid Name: Profile Name can only contain letters." . "\n");
				$valid = false;
			}
			
			if(!preg_match($passwordPattern, stripcslashes($password))) // if the password doesnt match the pattern display an error message
			{
				echo nl2br("Invalid input: Password can only contain letters and numbers." . "\n");
				$valid = false;
			}
			else
			{
				if($password != $confirmPass) // if it matche the pattern check to see if it also matches the confirmPassword 
				{								// in the form. if it doesnt display an error message
					echo nl2br("Password mismatch: The 2 passwords do not match." . "\n");
					$valid = false;
				}
			}
			
			echo "</p>";
			
			if($valid)  //checks to see if all the user inputs are valid 
			{
				$conn = @mysqli_connect($host, $user, $pswd, $dbnm)
						or die('Unable to connect to the server');  // if they are make a connection so that it can insert all the user details in the database
																		
				$sqlString = "INSERT INTO friends(friend_email, password, profile_name, date_started, num_of_friends)
								VALUES('$email', '$password', '$profileName', '$date', 0)";
								
				$queryResult = @mysqli_query($conn, $sqlString)
								or die('Couldnt execute the query');
					
				$userDetailsQuery = "SELECT * FROM friends WHERE friend_email = '$email'"; //query to get the user details 
				
				$userDetailsResult = @mysqli_query($conn, $userDetailsQuery)  
									or die('Couldnt execute THIS ');
									
				while($row = mysqli_fetch_row($userDetailsResult))
				{
					$_SESSION["user"] = $row;		// store the user details in a session variable so that we can access them from other pages
				}								
								
				header("location:friendadd.php"); // redirects to friendadd.php
			}
			else
			{
				echo "<p>Please fix all errors and try again.<p>";  // Error message when some of the details are not valid.
			}
		}
		else
		{			// Error message if the user left some of the textboxes blank
			echo "<p>Some of the boxes were blank. Please fill them in with valid details</p>";
		}	
	}
	else
	{
		echo "<p>Please fill in the details above to register into the friend system</p>"; // message when the values are not set
	}	
	
 ?>

<nav>
	<a href="index.php">Home</a>
</nav>
</body>
</html>