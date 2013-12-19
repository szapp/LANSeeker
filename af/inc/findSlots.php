<?php

/**
 * @file findSlots.php
 *
 * @brief Finds all availabe slots by checking the database
 */

/**
 * @brief Retrievs availabe Slots from database
 *
 * @param $mysql connetction settings
 *
 * @return $firstSlot The first slot object
 */
function findSlots($mysql = NULL) {
	// TODO: Access mysql and retrieve Slots
	$firstSlot = new Slot("Name_1", "template.png", "Exe_1");
	$curSlot = $firstSlot;
	for ($i=2; $i < 9; $i++) { 
		$curSlot->setNeighbor(new Slot("Name_" . $i, "template.png", "Exe_" . $i));
		$curSlot = $curSlot->getNeighbor();
	}
	return $firstSlot;
}
?>