<?php
	$db_server = "localhost";	// change this to your database server
	$db_user = "root";			// change this to your database username
	$db_pass = "password";			// change this to your database password
	$db_name = "icpep_web_dbms";//DON'T CHANGE THIS!!! MAKE SURE YOU RUN THE QUERY PROVIDED IN THE FOLDER (yasaydps.sql) 
	$db_port = '3307';			// change this to your dabase port
	
	try {
		$conn = new mysqli($db_server, $db_user, 
								$db_pass, $db_name, $db_port);
	} catch (mysqli_sql_exception){
		echo "Connection Unsuccessful";
	}
?>