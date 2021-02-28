<?php
	session_start();                     // start the session

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Assignment 2" />
	<meta name="keywords" content="assignemnt" />
	<meta name="author"   content="Apostolos Lafazanis" />
	<link rel="stylesheet" 	 href="style/style.css" />         
	<title>Friend List Page</title>
</head>
<body>
<?php
	if(isset ($_SESSION["user"])) 
	{  	// check if session variable exists

		$user_id = $_SESSION["user"][0];
		$numberFriends = $_SESSION["user"][5] ;
		$user_name = $_SESSION["user"][3];


		$host = "feenix-mariadb.swin.edu.au";
		$user = "s101360815"; 
		$pswd = "040796"; 
		$dbnm = "s101360815_db"; 
	
		$conn = @mysqli_connect($host, $user, $pswd, $dbnm)
				or die('Unable to connect to the server');
	
		if(isset($_POST["unfriend"]))  //This section checks to see if any of the submit buttons in the friend list were pressed 
		{
			$unfriend = $_POST["unfriend"];	
		
			//SQL query that deletes the friend the user indicated from the users friend list 
			$deleteQuery = "DELETE FROM myfriends WHERE friend_id2 = " . $unfriend . " AND friend_id1 = " . $user_id . "";
			
			$numberFriends--;	
													
			$_SESSION["user"][5] = $numberFriends;
		
			//SQL query that updates the number of friends from the user's details
			$updateQuery = "UPDATE friends SET num_of_friends = " . $numberFriends . " WHERE friend_id = " . $user_id . "";
		
			$friendsResult = @mysqli_query($conn, $deleteQuery)
							or die('Couldnt delete');				//executes both queries
					
			$friendsResult = @mysqli_query($conn, $updateQuery)
							or die('Couldnt update');
					
		
		}
		
		// Echoes the profile name of the user in the title of the page
		echo "<h1>My Friend System<br> $user_name's Friend List Page<br>
			Total number of friends is $numberFriends</h1>";  
			
			
		//This sql string returns all the friends of the user (details of the user are given from the session variable)
		$sqlString = "SELECT friend_id2 FROM myfriends WHERE friend_id1 = " . $user_id . ""; 
							
		$queryResult = @mysqli_query($conn, $sqlString)
					or die('Couldnt execute the query');
		
		// This SQL query returns the number of friends the user has
		$noFriendsString = "SELECT COUNT(friend_id2) FROM myfriends WHERE friend_id1 = " . $user_id . ""; 
	
		$noFriendsResult = @mysqli_query($conn, $noFriendsString)
						or die('Couldnt get count');
	
		while($noFriends = mysqli_fetch_row($noFriendsResult)) // getting the number of friends
		{
			if($noFriends[0] == 0) // check is the user has no friends in their friend list and displays an message if they dont
			{
				echo "<p>You have no friends in your friend list :( Go and add some! </p>";
			}
			else
			{		//else diplay all the friends in the users friend list
				echo "<table width='100%' border='1'>";
		
				while ($row = mysqli_fetch_row($queryResult)) // this is to get all the user's friends
				{
					$friendsQuery = "SELECT profile_name FROM friends WHERE friend_id = " . $row[0] . "";
		
					$friendsResult = @mysqli_query($conn, $friendsQuery) 
									or die('Couldnt execute the query');
			

				
					while($another_row = mysqli_fetch_row($friendsResult)) // this is to display the profile name of the available friends 
					{
						echo "<tr><td>{$another_row[0]}</td>";
						echo "<td><form action = \" friendlist.php\" method = \"post\">
						<input type = \"hidden\" name = \"unfriend\" value = \"" . $row[0] . "\"  />  
						<p class = \"submitButtons\"><input type =\"submit\" value = \"Unfriend\" /></p></form></td></tr>";
					
					//Okay so the unfriend buttons in the friend list are actually small forms that contain a hidden property and a submit button.
					// The value of the each hidden property is equal to that friends id and when the submit button is clicked that hidden value is
					// sent to section above which ultimately indicated the id of the friend that the user wants to unfriend.
					
					}
				}

				echo "</table>";	
			}
		}
	}	
	else // if the session variable does not exist, then this means that the user has not logged int and tries to access this page
	{
		echo "<h1>My Friend System</h1>";
		echo  "<p>You have to be logged in in order to check out your friends. Please register into the system or log in with an existing account.</p>";
	}	
	?>		
<nav>
	<a href="friendadd.php">Add Friends</a> |
	<a href="logout.php">Log out</a>
</nav>
</body>
</html>
