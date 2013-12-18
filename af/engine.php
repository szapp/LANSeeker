<?php

/**
 * @file engine.php
 *
 * @brief Processes front end
 */

// Global variables
$inc = $rp . "af/inc/";
$html = $rp . "ui/html/";

// Inc
require_once($inc . "templfunc.php");

// Session variables
$favico = $rp . "ui/img/favico.png";
$css = $rp . "ui/css/global.css";
$fetmpl = $html . "feTemplate.html";
$conttest = $inc . "conttest.php";

$pagetitle = "LAN Seeker";

// Content partials
$content = file_get_contents($conttest);


$allVars = get_defined_vars();
print_tmpl($fetmpl);

?>