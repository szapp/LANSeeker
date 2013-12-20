<?php

/**
 * @file connect.php
 * 
 * @brief Connects to database
 */

$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
?>