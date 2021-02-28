<?php
	session_start();                     // start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Assignment 2" />
	<meta name="keywords" content="assignment" />
	<meta name="author"   content="Apostolos Lafazanis" />
	<link rel="stylesheet" 	 href="style/style.css" />         
	<title>Add Friend Page</title>
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
		$pswd = "040796"; 					//Connetion details
		$dbnm = "s101360815_db";
	
		$conn = @mysqli_connect($host, $user, $pswd, $dbnm)
				or die('Unable to connect to the server');
						
		if(isset($_POST["add"]))		//This section checks to see if any of the submit buttons in the add friend page were pressed 
		{
			$add = $_POST["add"];
			
			//SQL query that inserts the person the user wants to add as a friend
			$addQuery = "INSERT INTO myfriends(friend_id1, friend_id2) VALUES('" . $user_id . "', '$add' )";
		
			$numberFriends++;
		
			$_SESSION["user"][5] = $numberFriends;
			
			//SQL query that updates the number of friends from the user's details
			$updateQuery = "UPDATE friends SET num_of_friends = " . $numberFriends . " WHERE friend_id = " . $user_id . "";
		
			$addResult = @mysqli_query($conn, $addQuery)
						or die('Couldnt add');					//executes both queries
					
			$updateResult = @mysqli_query($conn, $updateQuery)
							or die('Couldnt update');			
		}
		
		// Echoes the profile name of the user in the title of the page
		echo "<h1>My Friend System<br> $user_name 's Add Friend Page<br>
				Total number of friends is $numberFriends</h1>";
		
		
		//This sql string returns all the friends of the user (details of the user are given from the session variable)
		$sqlString = "SELECT friend_id2 FROM myfriends WHERE friend_id1 = " . $user_id . "";
							
		$queryResult = @mysqli_query($conn, $sqlString)
						or die('Couldnt execute the query');

		// This SQL query return all the friend ids in the friends table EXCEPT the user's
		$allFriendsString = "SELECT friend_id FROM friends WHERE NOT friend_id = " . $user_id . "";
							
		$allFriendsResult = @mysqli_query($conn, $allFriendsString)
							or die('Couldnt execute the query');

		$usersArray = array(); // create an empty array in which we are gonna store all the ids of the friend
	
		while($row = mysqli_fetch_row($allFriendsResult))
		{
			array_push($usersArray, "$row[0]"); // inserting the ids from the query into the array
		}
	
		// This query returns the number of possible frieds for the user
		$numberOfFriendsPossible = "SELECT COUNT(friend_id2) FROM myfriends WHERE friend_id1 = " . $user_id . ""; 
		
		$friedsPossibleResult = @mysqli_query($conn, $numberOfFriendsPossible)
								or die('Couldnt get count');
	
		while($possibleFriends = mysqli_fetch_row($friedsPossibleResult)) //fetches all the possible friends
		{
			if($possibleFriends[0] == count($usersArray)) //and checks if the friends of the user in the databse are equal to the size of the array 
			{												//meaning if the user has added every friend that exist in the database
				echo "<p>You don't have any more friends to add cos you are friends with everyone :0 </p>";
			}
			else
			{
				echo "<table width='100%' border='1'>";
		
				while ($rowTwo = mysqli_fetch_row($queryResult))
				{
					if (($key = array_search($rowTwo[0], $usersArray)) !== false) // this part removes the people that are already friends with our user,
					{															//  leaving behind an array that contains ALL the possible people the user can add as friends
						array_splice($usersArray, $key , 1);
					}
				}
				
				for($i = 0; $i < count($usersArray); $i++) // iterates through the array to display the all the people that the user can add as friends
				{
					// displays the name of the possible friends
					$friendsQuery = "SELECT profile_name FROM friends WHERE friend_id = " . $usersArray[$i] . "";
		
					$friendsResult = @mysqli_query($conn, $friendsQuery)
									or die('Couldnt execute the query');
		
					while($another_row = mysqli_fetch_row($friendsResult))
					{
						echo "<tr><td>{$another_row[0]}</td>";
						echo "<td><form action = \" friendadd.php\" method = \"post\">
						<input type = \"hidden\" name = \"add\" value = \"" . $usersArray[$i] . "\"  />
						<p class = \"submitButtons\"><input type =\"submit\" value = \"Add as Friend\" /></p></form></td></tr>";
					}
				}
				
				echo "</table>";	
			}
		}	
	}
	else		//if the session variable does not exist, then this means that the user has not logged int and tries to access this page
	{
		echo "<h1>My Friend System</h1>";
		echo  "<p>You have to be logged in in order to add friends. Please register into the system or log in with an existing account</p>";
	}
?>
	<nav>
		<a href="friendlist.php">Friend List</a> |
		<a href="logout.php">Log out</a>
	</nav>
</body>
</html>
