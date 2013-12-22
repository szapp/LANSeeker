<?php

/**
 * @file global.php
 *
 * @brief Takes care of global includes and definitions
 */

if (!isset($rp))
	$rp = '../';

// Global variables
$class 			= $rp . 'af/classes/';
$inc 			= $rp . 'af/inc/';
$html 			= $rp . 'ui/html/';
$partials 		= $html . 'partials/';
$con 			= $html . 'content/';
$css 			= $rp . 'ui/css/';
$img 			= $rp . 'ui/img/';
$js 			= $rp . 'ui/js/';
$res 			= $rp . 'res/';
$protocol 		= 'appurl';
$protocol_exec 	= $rp . 'af/exec/' . $protocol . '_inst.exe';

// Classes
require_once($class . "Template.php");
require_once($class . "Distributor.php");
require_once($class . "Game.php");
// Functions
require_once($inc . "manageLocations.php");
require_once($inc . "manageSlots.php");
// Includes
require_once($inc . "config.php");
require_once($inc . "findGames.php");
require_once($inc . "findDistributor.php");

?>