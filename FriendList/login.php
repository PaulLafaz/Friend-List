<?php
	session_start();                     // start the session
	if (!isset ($_SESSION["user"])) // check if session variable exists
	{  										
		$_SESSION["user"] = 1; 			// create the session variable when the user access this page
	}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Assignment 2" />
	<meta name="keywords" content="assignment" />
	<meta name="author"   content="Apostolos Lafazanis" />
	<link rel="stylesheet" 	 href="style/style.css" />         
	<title>Login Page</title>
</head>
<body>
	<h1>My Friend System<br>Login Page</h1>
	
		<form class = "main" action="login.php" method="post">
			<label class = "align ">Email: </label>		<!-- Email Textbox-->
			<input type="text" name="email" value="<?php if(isset($_POST["email"])){ echo htmlentities($_POST["email"]);} ?>"/><br>
			
			<label class = "align" >Password:</label>		<!-- Password Textbox -->
			<input type="password" name="pswd" /><br>
			
			<input class = "subButton" type="submit" value="Log in" />
			<input class = "resetButton" type="reset" value="Clear" />			<!-- Submit and Clear form buttons-->
		</form>
	
	<?php
		$host = "feenix-mariadb.swin.edu.au";
		$user = "s101360815"; 						//Connetion details
		$pswd = "040796"; 
		$dbnm = "s101360815_db"; 
		
		
		if(isset($_POST["email"]) && isset($_POST["pswd"]))  
		{
			if(!empty($_POST["email"]) && !empty($_POST["pswd"]))	//checks to see if the user left any sections blank
			{
				echo nl2br ("\n");
				$email = $_POST["email"];			//Variable declarations
				$password = $_POST["pswd"];
				$emailPattern = "/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/";
				$valid = true;
				$emailFound = false;
				
				$conn = @mysqli_connect($host, $user, $pswd, $dbnm)
						or die('Unable to connect to the server');
						
				$sqlString = "SELECT * FROM friends";    // my SQL query returning all the details entries in the friends table
							
				$queryResult = @mysqli_query($conn, $sqlString)
								or die('Couldnt execute the query');
								
				while($row = mysqli_fetch_row($queryResult))
				{
					if($email == $row[1])		//checks if the email is in the database and it is, make $emailfound true
					{					
						$emailFound = true;
						if($password == $row[2])	// checks if the password the user entered is the same as the one in the database
						{		
							$_SESSION["user"] = $row;		//if it is store the users details in a a session variable so we can utilise them in other pages
						
							header("location:friendlist.php"); 		//redirect to friendlist.php
						}
						else
						{
							echo "<p>Invalid password: Wrong password. Please try again.</p>"; 		// Error message if the password is wrong
							break;
						}
						
					}
				}
				
				if($emailFound == false)
				{
					echo "<p>Invalid email: Email did not exist</p>"; //Error message when the email does not exist in the database
				}	
			}
			else
			{
				echo "<p>Please enter both of your login details.</p>";			// Error message if the user left some of the textboxes blank
			}
		}
		else
		{
			echo "<p>Enter your email and password to log in.</p>";			// Message when the values are not set
		}
	?>
	<nav>
		<a href="index.php">Home</a>
	</nav>
</body>
</html>