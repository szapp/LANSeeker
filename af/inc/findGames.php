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
	$firstGame = new Game("Name_1", "template.png", "Exe_1");
	$curGame = $firstGame;
	for ($i=2; $i < 9; $i++) { 
		$curGame->setNeighbor(new Game("Name_" . $i, "template.png", "Exe_" . $i));
		$curGame = $curGame->getNeighbor();
	}
	return $firstGame;
}
?>