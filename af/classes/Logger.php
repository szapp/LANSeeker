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
	public function __construct($file, $padding = 0, $spacing = 4) {
		$this->_file = $file;
		if (!is_array($padding))
			$this->_padding[] = $padding;
		else
			$this->_padding = $padding;
		$this->_spacing = $spacing;
	}

	/**
	 * @brief Writes events to file
	 * 
	 * @param $event String containing event description
	 * 				 Arrays containing multiple sections
	 * @return true if successful, false otherwise
	 */
	public function log($event) {
		$write = "";
		if (is_array($event))
			foreach (array_values($event) as $i => $description)
				$write .= str_pad($description, $this->_padding[$this->getCount($i)]) . str_repeat(" ", $this->_spacing);
		else
			$write = str_pad($event, $this->_padding[0]);
		file_put_contents($this->_file, "\n" . date("Y-m-d H:i:s") . str_repeat(" ", $this->_spacing) . $write, FILE_APPEND | LOCK_EX);
	}

	private function getCount($index) {
		if (count($this->_padding) > $index)
			return $index;
		return 0;
	}

	protected $_file;
	protected $_spacing;
	protected $_padding;
}