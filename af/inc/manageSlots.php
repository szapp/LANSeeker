<?php

/**
 * @file manageSlots.php
 * 
 * @brief Manages Slots
 */

/**
 * @brief 
 *
 * @return Applied html of all Slots
 */
function getSlots($slot) {
	global $p_slot;
	if (!get_class($slot))
		throw new Exception("Argument is not a Slot reference", 1);
	$slottmpl = new Template($p_slot);
	$op = "";
	do {
		$slottmpl->set('name', $slot->getName());
		$slottmpl->set('cover', $slot->getCover());
		$slottmpl->set('exe', $slot->getExe());
		$op .= $slottmpl->render() . "\n";
	} while ($slot = &$slot->getNeighbor());
	return $op;
}
?>