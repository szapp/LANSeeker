<?php 

/**
 * @file confirmInstall.php
 *
 * @brief Registers clients in database
 */

// Config
$rp = '../';
require_once($rp . 'af/global.php');

// Ensure file was called properly
if ((!isset($_GET["protocol"]) || empty($_GET["protocol"]))
||  (!isset($_GET["version"]) || empty($_GET["version"]))) {
	$err = "Invalid call. Access denied.";
	$log->log([$clientname, "could not install/update plug-in due to an ERROR: '" . $err . "'"]);
	die($err);
}

$c_protocol = htmlspecialchars($_GET["protocol"]); // Protocol as requested from client
$c_version = trim(htmlspecialchars($_GET["version"]), "|"); // Update to version

// Check for valid parameters (protocol, version)
$query = 'SELECT * FROM `protocols`';
if (!$result = $db->query($query)) {
	$err = "Could not retrieve protocollist from database";
	$log->log([$clientname, "could not install/update plug-in due to an ERROR: '" . $err . "'"]);
	die($err);
}
while ($row = $result->fetch_assoc())
	$protocollist[$row["protocol"]] = $row["versionlist"];
$result->free();
if (strpos($protocollist[$c_protocol], "|" . $c_version . "|") === false) {
	$err = "Invalid call. Access denied.";
	$log->log([$clientname, "could not install/update plug-in due to an ERROR: '" . $err . "'"]);
	die($err);
}

// Check whether protocol was previously installed (client in database)
$query = 'SELECT `client` FROM `protocol_' . $c_protocol . '` WHERE `client`="' . $clientname . '"';
if (!$result = $db->query($query)) {
	$err = "Could not retrieve protocol check from database";
	$log->log([$clientname, "could not install/update plug-in due to an ERROR: '" . $err . "'"]);
	die($err);
}
if ($result->fetch_array()) { // If protocol was installed update version
	$query = 'UPDATE `protocol_' . $c_protocol . '` SET `version`="' . $c_version . '" WHERE `client`="' . $clientname . '"';
	$log->log([$clientname, "successfully updated plug-in"]);
} else { // Otherwise create new entry for client
	$query = 'INSERT INTO `protocol_' . $c_protocol . '` VALUES ("' . $clientname . '", "' . $c_version . '")';
	$log->log([$clientname, "successfully installed plug-in"]);
}

if ($db->query($query) === false) {
	$err = "Could not store client and protocol";
	$log->log([$clientname, "could not install/update plug-in due to an ERROR: '" . $err . "'"]);
	die($err);
}

// Return to user interface
header("location: " . $rp);
?>