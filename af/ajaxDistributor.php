<?php

/**
 * @file ajaxDistributor.php
 *
 * @brief Returns the most suitable Distributor at this very moment (ajax call)
 */

// Config
$rp = '../';
require_once($rp . 'af/global.php');

$clientname= explode(".", strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR'])));

// Check whether protocol is installed
$query = 'SELECT `client` FROM `protocol_' . $protocol . '` WHERE `client`="' . $clientname[0] . '"';
if (!$result = $db->query($query))
	die("Could not retrieve protocol check from database");
$protocol_inst = false;
if ($finfo = $result->fetch_array())
	$protocol_inst = true;
$result->close();

// If protocol was installed
if ($protocol_inst) {
	// Return path of most suitable database with exe
	echo json_encode(array('installed' => true, 'protocol' => $protocol . '://', 'path' => findDistributor()->pathTo()));
} else {
	echo json_encode(array('installed' => false, 'exec' => $protocol_exec, 'path' => findDistributor()->pathTo()));
}
?>