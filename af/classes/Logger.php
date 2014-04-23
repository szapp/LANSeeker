<?php

/**
 * @file Logger.php
 *
 * @brief Contains Logger class
 */

/**
 * @class Logger
 *
 * @brief Loggs activity into file
 */
class Logger {
	
	/**
     * @brief Constructor
     *
     * @param $file Log file
     */
	public function __construct(string $file) {
		$this->_file = $file;
	}

	/**
	 * @brief Writes events to file
	 * 
	 * @param $event String containing event description
	 * @param $par1 Optional parameter 1
	 * @param $par2 Optional parameter 2
	 * @return true if successful, false otherwise
	 */
	public function log(string $event, $par1 = NULL, $par2 = NULL) {
		// TODO: write event to file with timestamp and client name
	}

	protected $_file;
}