<?php

/**
 * @file
 * 
 * @brief Finds the most suitable Distributor by searching the database
 */

/**
 * @brief Retrieves best Distributor from database
 *
 * @return Most suitable Distributor
 */
function findDistributor() {
	global $db;
	$query = 'SELECT `drive`,`path` FROM `distributors` WHERE `utilization` != -1 ORDER BY `utilization` ASC LIMIT 1';
	if (!$result = $db->query($query))
		die("Could not retrieve distributors from database");
    $finfo = $result->fetch_assoc();
    $result->close();
	return new Distributor($finfo);
}
?>