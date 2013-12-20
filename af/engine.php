<?php

/**
 * @file engine.php
 *
 * @brief Processes front end
 */

require_once('global.php');

// Page properties
$pp = array(
	'favicon' 	=> $img . 'favicon.png',
	'css'		=> $css . 'global.css',
	'js1'		=> $js . 'jquery-1.10.2.min.js',
	'js2'		=> $js . 'global.js',
	'pagetitle'	=> 'LAN Seeker'
	);

// Framework
$layout  = $html . 'layout.html';
$main 	 = $html . 'main.html';
$head 	 = $html . 'head.html';
$footer  = $html . 'footer.html';

// Content templates
$content = $con . 'default.html';
$p_slot	 = $partials . 'slot.html';

// Head and footer
$head = new Template;
$footer = new Template;

// Content
$content = new Template($content);
fillSlots(findGames());

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