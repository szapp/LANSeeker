<?php

/**
 * @file Template.php
 *
 * @brief Contains Template class
 */

/**
 * @class Template
 *
 * @brief Holds variables making up a template
 */
class Template {

    /**
     * @brief Constructor
     *
     * @param $file Template file
     */
    public function __construct($file = NULL) {
        $this->_file = $file;
    }

    /**
     * @brief Setter method for variable array
     *
     * @param $key May be an array of key/value pairs or a single key
     * @param $value Only necessary if $key is a single key
     */
    public function set($key, $value = NULL) {
        if (is_array($key))
            foreach ($key as $keyy => $value)
                $this->_data[$keyy] = $value;
        else
            $this->_data[$key] = $value;
    }

    /**
     * @brief Renders the template for output
     *
     * @return output string
     */
    public function render() {
        if (!$this->_file)
            return;
        $rawt = file_get_contents($this->_file);
        return preg_replace_callback("/\\{?\\$\\w+\\}?/", "Template::fill_vars", $rawt);
    }

    /**
     * @brief Utilizes regex to match variables in text
     *
     * @param $match String to check against variables
     *
     * @return Matched string
     */
    private function fill_vars($match) {
        if (array_key_exists(trim($match[0],"$ { }"), $this->_data))
            return $this->_data[trim($match[0],"$ { }")];
        else
            return $match[0];
    }

    protected $_file;
    protected $_data = array();
}
?>