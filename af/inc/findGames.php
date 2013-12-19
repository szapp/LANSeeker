<?php

/**
 * @file findGames.php
 *
 * @brief Finds all availabe gamess by checking the database
 */

/**
 * @brief Retrievs availabe Games from database
 *
 * @param $mysql connetction settings
 *
 * @return $firstGame The first Game object
 */
function findGames($mysql = NULL) {
	// TODO: Access mysql and retrieve Gamess

	$query = 'SELECT * FROM games';
	$result = mysql_query($query)
		or die('Could not retrieve games: ' . mysql_error());

	$emtpyGame = new Game("", "", "");
	$curGame = $emtpyGame;
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$curGame->setNeighbor(new Game($line['name'], /*$line['cover']*/ "template.png" , $line['exe']));
		$curGame = $curGame->getNeighbor();
	}
	$firstGame = $emtpyGame->getNeighbor();
	unset($emtpyGame, $curGame);
	return $firstGame;
}
?>