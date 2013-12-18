<?php

/**
 * @file templfunc.php
 * 
 * @brief Offers template function to parse html templates
 */

/**
 * @brief Wrapper function for make_tmpl
 *
 * @param $tmpl Template file
 *
 * @return Applied template
 */
function print_tmpl($tmpl) {
	print(make_tmpl($tmpl));
}

/**
 * @brief Wrapper function for fill_vars
 *
 * @param $tmpl Template file
 *
 * @return Applied template
 */
function make_tmpl($tmpl) {
	$fes = file_get_contents($tmpl);
	return preg_replace_callback ("/\\{?\\$\\w+\\}?/", "fill_vars", $fes);
}

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