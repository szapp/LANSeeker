<?php

/**
 * @file ajaxDistributor.php
 *
 * @brief Returns the most suitable Distributor at this very moment (ajax call)
 */

// Config
$rp = '../';
require_once($rp . 'af/global.php');


$protocol = "appurl://";
// Return path of most suitable database with exe
echo $protocol . findDistributor()->pathTo();

// TODO: Add protocol to exectue programs
?>