<?php

/**
 * @file manageLocs.php
 *
 * @brief Contains functions to manage available Distributors
 */

/**
 * @brief Adds a Distributor
 *
 * @param Distributor to add
 */
function addLocation($loc) {
	global $locations;
	if (get_class($loc) == "Distributor")
		$locations[] = $loc;
	elseif (is_array($loc))
		foreach ($loc as $value)
			addLocation($value);
	else
		return;
}

/**
 * @brief Removes a Distributor
 *
 * @param Distributor to remove
 */
function removeLocation($loc) {
	global $locations;
	unset($locations[array_search($loc, $locations)]);
}
?>