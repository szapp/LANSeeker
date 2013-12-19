<?php

/**
 * @file Distributor.php
 * 
 * @brief Contains Distributor class
 */

/**
 * @class Distributor
 * 
 * @brief Describes a machine for software distribution
 */
class Distributor {
	
	/**
     * @brief Constructor
     *
     * @param $path Absolute path to repository
     */
    public function __construct(array $array) {
        // TODO: Seperate $path into $_drive and $_path
        // TODO: Destinguish between network or local device

        $this->_drive = $array['drive'];
        $this->_path = $array['path'];
    }

    /**
     * @brief Get path to repository
     *
     * @return Absolute path to repository
	 */
    public function pathTo() {
    	return $this->_drive . $this->_path;
    }

    /**
     * @brief Getter method for $_network
     * 
     * @return 1 if network device, 0 otherwise
     */
    public function isNet() {
    	return $_network;
    }

    /**
     * @brief Check utilization
     * 
     * @return Float between 0 and 1
     */
    public function utilization() {
    	// TODO: Determine utilization (method necessary?)
    	return $_utilization;
    }

	protected $_drive;
	protected $_path;
	protected $_network;
	protected $_utilization;
}
?>