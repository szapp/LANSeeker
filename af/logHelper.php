<?php

/**
 * @file logHelper.php
 *
 * @brief Helper for logging activity from javascript
 */

// Config
if (!isset($rp))
	$rp = '../';
require_once($rp . 'af/global.php');

// Ensure file was called properly
if (!isset($_POST['args']) || empty($_POST['args']))
	die("Invalid call. Access denied.");

// Pass arguments to logger
foreach ($_POST['args'] as $value)
	$args[] = htmlspecialchars($value);
$log->log($args);

?>