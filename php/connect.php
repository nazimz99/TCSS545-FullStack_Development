<?php
    $servername = "mycovid19db.ctuns9rg37yi.us-east-2.rds.amazonaws.com";
	$username = "kkinoc";
	$password = "Lagrace1$";
	$dbname = "mydatabase";

	// Create connection
	$db = mysqli_connect($servername, $username, $password,$dbname);

	// Check connection
	if (!$db) {
	  die("Connection failed: " . mysqli_connect_error());
	}
?>