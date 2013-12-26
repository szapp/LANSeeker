<?php

/**
 * @file ajaxDistributor.php
 *
 * @brief Returns the most suitable Distributor at this very moment (ajax call)
 */

// Config
$rp = '../';
require_once($rp . 'af/global.php');

$path = findDistributor()->pathTo();
$clientname = explode(".", strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR'])))[0];

// Check whether protocol is installed
$query = 'SELECT `client` FROM `protocol_' . $protocol . '` WHERE `client`="' . $clientname . '"';
if (!$result = $db->query($query))
	exit(json_encode(array('error' => 'Could not retrieve protocol check from database')));
if ($result->fetch_array()) // If protocol was installed return path of most suitable database with exe
	echo json_encode(array('error' => 0, 'installed' => true, 'protocol' => $protocol . '://', 'path' => $path));
else
	echo json_encode(array('error' => 0, 'installed' => false, 'exec' => $protocol_exec, 'path' => $path));
$result->free();
?>