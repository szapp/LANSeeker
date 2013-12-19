<?php

/**
 * @file findGames.php
 *
 * @brief Finds all availabe gamess by checking the database
 */

/**
 * @brief Retrievs availabe Games from database
 *
 * @return $games The first Game object
 */
function findGames() {
	$query = 'SELECT `name`,`cover`,`exe` FROM `games`';
	$result = mysql_query($query)
		or die('Could not retrieve games: ' . mysql_error());
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC))
		$games[] = new Game($line);
	return $games;
}
?>