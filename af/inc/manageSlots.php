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
function fillSlots(array $game, $pSlot, $content) {
	$slots = new Template($pSlot);
	$offset = 20;
	$i = $offset;
	$op = "";
	foreach ($game as $key => $value) {
		$slots->set('name', $value->getName());
		$slots->set('cover', $value->getCover());
		$slots->set('exe', $value->getExe());
		$slots->set('left', (($i += 94) - 94) . "px");
		$op .= $slots->render() . "\n";
	}
	$op .= "<div class='spacer' style='width: {$offset}px; left: {$i}px;'></div>";
	$content = new Template($content);
	$content->set('slots', $op);
	$content->set('width', ($i + $offset) . "px");
	return $content;
}
?>