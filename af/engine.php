<?php

/**
 * @file engine.php
 *
 * @brief Processes front end
 */

// Inc
require_once($rp . "af/inc/templfunc.php");

// Global variables
$favico = $rp . "ui/img/favico.png";
$css = $rp . "ui/css/global.css";
$fetmpl = $rp . "ui/html/feTemplate.html";

$pagetitle = "LAN Seeker";


$allVars = get_defined_vars();
$fe = file_get_contents($fetmpl);
$fe = preg_replace_callback ("/\\{?\\$\\w+\\}?/", "fill_vars", $fe);

?>