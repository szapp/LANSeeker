<?php

/**
 * @file engine.php
 *
 * @brief Processes front end
 */

// Global variables
$class 		= $rp . 'af/classes/';
$inc 		= $rp . 'af/inc/';
$html 		= $rp . 'ui/html/';
$partials 	= $html . 'partials/';
$con 		= $html . 'content/';
$css 		= $rp . 'ui/css/';
$img 		= $rp . 'ui/img/';
$js 		= $rp . 'ui/js/';
$res 		= $rp . 'res/';

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

// Page properties
$pp = array(
	'favicon' 	=> $img . 'favicon.png',
	'css'		=> $css . 'global.css',
	'js'		=> $js . 'jquery-1.10.2.js',
	'pagetitle'	=> 'LAN Seeker'
	);

// Framework
$layout  = $html . 'layout.html';
$main 	 = $html . 'main.html';
$head 	 = $html . 'head.html';
$footer  = $html . 'footer.html';
$content = $con . 'default.html';
$p_slot	 = $partials . 'slot.html';

// Head and footer
$head = new Template;
$footer = new Template;

// Content
$content = new Template($content);
$games = findGames();
$content->set('slots', fillSlots($games));

// Close db conntection
mysql_close($dbLink);

// Assemble main
$main = new Template($main);
$main->set('head', $head->render()); 
$main->set('footer', $footer->render());
$main->set('content', $content->render());

// Assemble and render template
$page = new Template($layout);
$page->set($pp);
$page->set('main', $main->render());
echo $page->render();
?>