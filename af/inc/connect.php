<?php

/**
 * @file connect.php
 * 
 * @brief Connects to database
 */

$db = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if (mysqli_connect_errno())
	die("Connect failed: " . mysqli_connect_error());
?>