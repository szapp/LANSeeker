<?php

/**
 * @file connect.php
 * 
 * @brief Connects to database
 */

$dbLink = mysql_connect($dbHost, $dbUser, $dbPass)
    or die('Could not connect: ' . mysql_error());
mysql_select_db($dbName)
	or die('Could not select database');

?>