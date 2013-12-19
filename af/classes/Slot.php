<?php

/**
 * @file Slot.php
 *
 * @brief Contains Slot class
 */

/**
 * @class Slot
 *
 * @brief Gathers properties and methods of one game slot
 */
class Slot {

	/**
	 * @brief Constructor
	 *
	 * @param $name of game
	 * @param $cover image
	 * @param $exe Name of executables
	 */
	public function __construct($name, $cover, $exe) {
	    $this->setName($name);
	    $this->setCover($cover);
	    $this->setExe($exe);
	}

	/**
	 * @brief Getter for $_name
	 *
	 * @return Name of game
	 */
	public function getName() {
		return $this->_name;
	}

	/**
	 * @brief Getter for $_exe
	 *
	 * @return Exe of game
	 */
	public function getExe() {
		// TODO: Call function to determine suitable Distributor and set corresponding $path
		return /*$path . */$this->_exe;
	}

	/**
	 * @brief Getter for $_cover
	 *
	 * @return Cover image of game
	 */
	public function getCover() {
		return './res/' . $this->_cover;
	}

	/**
	 * @brief Getter for $_next
	 *
	 * @return Neighboring slot
	 */
	public function getNeighbor() {
		return $this->_next;
	}

	/**
	 * @brief Setter for $_name
	 *
	 * @param Name of game
	 */
	public function setName($name) {
		$this->_name = $name;
	}

	/**
	 * @brief Setter for $_exe
	 *
	 * @param Exe of game
	 */
	public function setExe($exe) {
		// TODO: Check whether existant in all Distributors?
		$this->_exe = $exe;
	}

	/**
	 * @brief Setter for $_cover
	 *
	 * @param $cover of game
	 */
	public function setCover($cover) {
		if (!file_exists('./res/' . $cover))
			throw new Exception("Cover art does not exist "  . $cover , 1);
		$this->_cover = $cover;
	}

	/**
	 * @brief Setter for $_next
	 *
	 * @param Neighboring slot
	 */
	public function setNeighbor(&$next) {
		if (!get_class($next))
			throw new Exception("Object does not exist or is not of class Slot", 1);
		$this->_next = $next;
	}	

	protected $_name;
	protected $_exe;
	protected $_cover;
	protected $_next = NULL;
}
?>