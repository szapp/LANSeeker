<?php

/**
 * @file templfunc.php
 * 
 * @brief Offers template function to parse html templates
 */

/**
 * @brief Replace callback function
 *
 * @param $file Template
 * @param $vars Variables to replace
 *
 * @return Applied template
 */
function fill_vars($match) {
    global $allVars;
    if (array_key_exists(trim($match[0],"$ { }"), $allVars))
        return $allVars[trim($match[0],"$ { }")];
    else
        return $match[0];
}

?>