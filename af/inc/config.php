<?php

/**
 * @file config.php
 *
 * @brief Contains global config
 */

$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "lanseeker";

require_once($inc . "connect.php");

unset($dbHost, $dbUser, $dbPass, $dbName);
?>