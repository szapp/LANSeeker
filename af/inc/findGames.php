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
	global $db;
	$query = 'SELECT `games` FROM `profiles` WHERE `active`=1 LIMIT 1';
	if (!$result = $db->query($query))
		die("Could not retrieve profiles from database");
	if (!$finfo = $result->fetch_array())
		die("No active profiles");
	$result->close();

	$query = 'SELECT `name`,`cover`,`exe` FROM `games`';
	if ($finfo[0] != "all")
		$query .= ' WHERE `id` IN (' . $finfo[0] . ')';
	if (!$result = $db->query($query))
		die("Could not retrieve games from database");
	$games = [];
	while ($line = $result->fetch_assoc())
		$games[] = new Game($line);
	$result->close();
	return $games;
}
?>