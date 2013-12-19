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

	$query = 'SELECT `drive`,`path` FROM `distributors` WHERE `utilization` != -1 ORDER BY `utilization` DESC LIMIT 1';
	$result = mysql_query($query)
		or die('Could not retrieve Distributors: ' . mysql_error());

	return new Distributor(mysql_fetch_array($result, MYSQL_ASSOC));
}
?>