<?php

/**
 * @file engine.php
 *
 * @brief Processes front end
 */

require_once('global.php');

// Page properties
$pp = array(
	'favicon' 	=> $img . 'favicon.ico',
	'faviconpng' 	=> $img . 'favicon.png',
	'css1'		=> $css . 'jquery.jscrollpane.css',
	'css2'		=> $css . 'global.css',
	'js1'		=> $js . 'jquery-1.10.2.min.js',
	'js2'		=> $js . 'jquery.jscrollpane.min.js',
	'js3'		=> $js . 'jquery.mousewheel.js',
	'js4'		=> $js . 'global.js',
	'pagetitle'	=> 'LAN Seeker'
	);

// Declare template files
// Framework
$layout  = $html . 'layout.html';
$main 	 = $html . 'main.html';
$head 	 = $partials . 'head.html';
$footer  = $partials . 'footer.html';
// Content
$content = $con . 'default.html';
$pSlot	 = $partials . 'slot.html';

// Head and footer
$head = new Template($head);
$footer = new Template($footer);

// Content
$content = fillSlots(findGames(),$pSlot, $content);

// Close db conntection
$db->close();

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