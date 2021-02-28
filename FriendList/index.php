<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Assignment 2" />
	<meta name="keywords" content="assingment" />
	<meta name="author" content="Apostolos Lafazanis" />
	<link rel="stylesheet" 	 href="style/style.css" />         <!-- Linking CSS stylesheet-->
	<title>Home Page</title>
</head>
<body>
	<h1>My Friend System<br>Assignment Home Page</h1>
	
	<p>Name: Apostolos Lafazanis<br>			<!-- Personal Details -->
	Student ID: 101360815<br>	
	Email:<a href ="mailto:apostolislaf1675@gmail.com">apostolislaf1675@gmail.com</a><br></p>
	
	<p>I declare that this assignment is my individual work. I have not worked collaboratively 
		nor have I copied from any other student's work or from any other source</p>
		
<?php
	$host = "feenix-mariadb.swin.edu.au";
	$user = "s101360815"; // your user name
	$pswd = "040796"; // your password d(date of birth –ddmmyy)  	//Connection details
	$dbnm = "s101360815_db"; // your database
	
	
	$conn = @mysqli_connect($host, $user, $pswd, $dbnm )		// Making connection to the database
	or die('Unable to connect to the server');				
	
	
	// friends table creation SQL query
	$friendsTable = "CREATE TABLE  if not exists friends (
		friend_id INT NOT NULL AUTO_INCREMENT,
		friend_email VARCHAR(50) NOT NULL,
		password VARCHAR(20) NOT NULL,					
		profile_name VARCHAR(30) NOT NULL,
		date_started DATE NOT NULL,
		num_of_friends INT UNSIGNED,
		PRIMARY KEY(friend_id))";
	

	// myfriends table creation SQL query	
	$myFriendsTable = "CREATE TABLE  if not exists myfriends (
		friend_id1 INT NOT NULL,
		friend_id2 INT NOT NULL)";
		
	$queryResult = @mysqli_query($conn, $friendsTable)
		or die('Unable to create friends Table');
														 //Creation of tables
	$queryResult = @mysqli_query($conn, $myFriendsTable)
		or die('Unable to create  My Friends Table');


	// Populating SQL query for table friends
	$populateFriends = "INSERT INTO friends(friend_email, password, profile_name, date_started, num_of_friends) 
	select t.* 
    from ((SELECT 'apostolos@gmail.com' as col1, '123' as col2, 'Apostolos' as col3, '1996/07/04' as col4, 2 as col5 ) union all 
          (SELECT 'david@gmail.com', '321', 'David', '1996/07/03', 2 ) UNION ALL  
          (SELECT 'billy@gmail.com', '123', 'Billy', '1996/07/02', 2 ) UNION ALL  
          (SELECT 'chris@gmail.com', '123', 'Christopher', '1996/07/01', 2 )UNION ALL  
          (SELECT 'vivian@gmail.com', '123', 'Vivian', '1996/07/10', 2 )UNION ALL  
          (SELECT 'mary@gmail.com', '123', 'Mary', '1996/07/11', 2 )UNION ALL  
          (SELECT 'peter@gmail.com', '123', 'Peter', '1996/07/12', 2 )UNION ALL  
          (SELECT 'sabrina@gmail.com', '123', 'Sabrina', '1996/07/13', 2 )UNION ALL  
          (SELECT 'linda@gmail.com', '123', 'Linda', '1996/07/14', 2 )UNION ALL  
          (SELECT 'greg@gmail.com', '123', 'Gregory', '1996/07/15', 2 ) ) 
    t WHERE NOT EXISTS (SELECT * FROM friends)";
	
	//Populating SQL query for table myfriends
	$populateMyFriends = "INSERT INTO myfriends(friend_id1, friend_id2) 
	select t.* 
    from ((SELECT 1 as col1, 2 as col2) union all 
          (SELECT 1, 3 ) UNION ALL  
          (SELECT 2, 5 ) UNION ALL  
          (SELECT 2, 6 ) UNION ALL  
          (SELECT 3, 8 ) UNION ALL
		  (SELECT 3, 10 ) UNION ALL
		  (SELECT 4, 1 ) UNION ALL
		  (SELECT 4, 5 ) UNION ALL
		  (SELECT 5, 2 ) UNION ALL
		  (SELECT 5, 7 ) UNION ALL
		  (SELECT 6, 3 ) UNION ALL
		  (SELECT 6, 8 ) UNION ALL
		  (SELECT 7, 4 ) UNION ALL
		  (SELECT 7, 1 ) UNION ALL
		  (SELECT 8, 5 ) UNION ALL
		  (SELECT 8, 2 ) UNION ALL
		  (SELECT 9, 8 ) UNION ALL
		  (SELECT 9, 6 ) UNION ALL
		  (SELECT 10, 9 ) UNION ALL
		  (SELECT 10, 8 ) ) 
    t WHERE NOT EXISTS (SELECT * FROM myfriends)";
	
	$queryResult = @mysqli_query($conn, $populateFriends)
		or die('Unable to populate friends tables');
															//Populate tables
	$queryResult = @mysqli_query($conn, $populateMyFriends)
		or die('Unable to populate myfriends tables');
		
	echo "<p>Tables successfully created and populated.</p>";
?>		

<nav>
	<a href="signup.php">Sign-Up</a> |
	<a href="login.php">Log-in</a> |   <!-- Links to other pages-->
	<a href="about.php">About</a>
</nav>	
</body>
</html>