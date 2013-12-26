<?php 

/**
 * @file confirmInstall.php
 *
 * @brief Registers clients in database
 */

// Config
$rp = '../';
require_once($rp . 'af/global.php');

$c_protocol = htmlspecialchars($_GET["protocol"]); // Protocol as requested from client
$c_version = trim(htmlspecialchars($_GET["version"]), "|"); // Update to version
$clientname = explode(".", strtolower(gethostbyaddr($_SERVER['REMOTE_ADDR'])))[0];

// Check for valid parameters (protocol, version)
$query = 'SELECT * FROM `protocols`';
if (!$result = $db->query($query))
	die("Could not retrieve protocollist from database");
while ($row = $result->fetch_assoc())
	$protocollist[$row["protocol"]] = $row["versionlist"];
$result->free();
if (strpos($protocollist[$c_protocol], "|" . $c_version . "|") === false)
		die("Invalid call. Access denied.");

// Check whether protocol was previously installed (client in database)
$query = 'SELECT `client` FROM `protocol_' . $c_protocol . '` WHERE `client`="' . $clientname . '"';
if (!$result = $db->query($query))
	die("Could not retrieve protocol check from database");
if ($result->fetch_array()) // If protocol was installed update version
	$query = 'UPDATE `protocol_' . $c_protocol . '` SET `version`="' . $c_version . '" WHERE `client`="' . $clientname . '"';
else // Otherwise create new entry for client
	$query = 'INSERT INTO `protocol_' . $c_protocol . '` VALUES ("' . $clientname . '", "' . $c_version . '")';

if ($db->query($query) === false)
	die("Could not store client and protocol");

// Return to user interface
header("location: " . $rp);
?>