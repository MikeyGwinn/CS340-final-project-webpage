<?php
	/* Display Errors */
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);
	
	mysqli_report(MYSQLI_REPORT_ERROR );


	/* Change for your username and password for phpMyAdmin*/
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'phpmyadmin');
	define('DB_PASSWORD', 'CS340termproject');
	define('DB_NAME', 'CS340-term-project');
	 
	/* Attempt to connect to MySQL database */
	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	 
	// Check connection
	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
?>
