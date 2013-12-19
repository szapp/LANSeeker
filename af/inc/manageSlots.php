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
function fillSlots(array $game) {
	global $p_slot;
	$slots = new Template($p_slot);
	$distr = findDistributor();
	$slots->set('pathTo',$distr->pathTo());
	unset($distr);
	$op = "";
	foreach ($game as $key => $value) {
		$slots->set('name', $value->getName());
		$slots->set('cover', $value->getCover());
		$slots->set('exe', $value->getExe());
		$op .= $slots->render() . "\n";
	}
	return $op;
}
?>