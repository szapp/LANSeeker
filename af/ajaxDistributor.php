<?php

/**
 * @file ajaxDistributor.php
 *
 * @brief Returns the most suitable Distributor at this very moment (ajax call)
 */

// Config
if (!isset($rp))
	$rp = '../';
require_once($rp . 'af/global.php');

$path = findDistributor()->pathTo();

// Check for latest protocol version
$query = 'SELECT `versionlist` FROM `protocols` WHERE `protocol`="' . $protocol . '"';
if (!$result = $db->query($query)) {
	$err = 'Could not retrieve versionlist from database';
	$log->log([$clientname, "encountered an ERROR: '" . $err . "' when looking for a distributor"]);
	exit(json_encode(array('error' => $err)));
}
if (!$row = $result->fetch_assoc()) {
	$err = 'Protocol does not provide versionlist';
	$log->log([$clientname, "encountered an ERROR: '" . $err . "' when looking for a distributor"]);
	exit(json_encode(array('error' => $err)));
}
$result->free();
$protocolVersion = trim(substr($row["versionlist"], strrpos($row["versionlist"], "|", -2)), "|");
unset($row);

// Check whether protocol is installed
$query = 'SELECT `client`, `version` FROM `protocol_' . $protocol . '` WHERE `client`="' . $clientname . '"';
if (!$result = $db->query($query)) {
	$err = 'Could not retrieve protocol check from database';
	$log->log([$clientname, "encountered an ERROR: '" . $err . "' when looking for a distributor"]);
	exit(json_encode(array('error' => $err)));
}
if (!$row = $result->fetch_assoc()) // If protocol was installed return path of most suitable database with exe
	echo json_encode(array('error' => 0, 'installed' => false, 'update' => false, 'exec' => $protocol_exec, 'path' => $path, 'client' => $clientname));
else
	if ($row["version"] < $protocolVersion)
		echo json_encode(array('error' => 0, 'installed' => true, 'update' => true, 'exec' => $protocol_exec, 'path' => $path, 'client' => $clientname));
	else 
		echo json_encode(array('error' => 0, 'installed' => true, 'update' => false, 'protocol' => $protocol . '://', 'path' => $path, 'client' => $clientname));
$result->free();
?>