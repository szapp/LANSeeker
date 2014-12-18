<?php

/**
 * @file config.php
 *
 * @brief Contains global config
 */

$dbHost = "localhost";
$dbUser = "root";
$dbPass = ""; // Enter password
$dbName = "lanseeker";

require_once($inc . "connect.php");

unset($dbHost, $dbUser, $dbPass, $dbName);
?>