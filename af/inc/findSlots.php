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
	$firstSlot->setNeighbor(new Slot("Name_2", "template.png", "Exe_2"));
	return $firstSlot;
}
?>