<?php
	/*
		$db_server = "localhost";	// change this to your database server
	$db_user = "u495515480_ICPEP_dbs";			// change this to your database username
	$db_pass = "icpepElec_se#2025";			// change this to your database password
	$db_name = "icpep_web_dbms";
	$db_port = NO DB PORT */
	
	//$conn = new mysqli("localhost", "u495515480_root", "Voting$123", "voting_db");

	$db_server = "localhost";	// change this to your database server
	$db_user = "u495515480_ICPEP_dbs";			// change this to your database username
	$db_pass = "icpepElec_se#2025";			// change this to your database password
	$db_name = "icpep_web_dbms";
	$db_port = '3307';			// change this to your dabase port
	
	try {
		$conn = new mysqli($db_server, $db_user, 
								$db_pass, $db_name);
	} catch (mysqli_sql_exception){
		echo "Connection Unsuccessful";
	}
?>
