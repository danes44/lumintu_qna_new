<?php
//	$servername = "0.tcp.ap.ngrok.io:11968";
    $servername = "localhost";
	$database = "lumintu_qna";
	$username = "root";
	$password = "";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $database);

	// Check connection
	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}
?>