<?php

/**
 * @file manageSlots.php
 * 
 * @brief Manages Game slots
 */

/**
 * @brief Fills the slot template with available Games
 *
 * @return Applied html of all Game slots
 */
function fillSlots($game) {
	global $p_slot;
	if (!get_class($game))
		throw new Exception("Argument is not of class Game", 1);
	$slots = new Template($p_slot);
	$op = "";
	do {
		$slots->set('name', $game->getName());
		$slots->set('cover', $game->getCover());
		$slots->set('exe', $game->getExe());
		$op .= $slots->render() . "\n";
	} while ($game = &$game->getNeighbor());
	return $op;
}
?>