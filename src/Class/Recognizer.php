<?php

namespace Genderize;

/**
 * Description of Recognizer
 *
 * @author barttyrant
 */
class Recognizer {

    protected $_country_id = null;
    protected $_supported_countries = null;

    public function __construct() {

    }

    public function recognize() {
        
    }

    protected function is_country_supported($country_id) {
        if (is_null($this->_supported_countries)) {
            // load supported countries
        }
        return in_array($country_id, $this->_supported_countries);
    }

    public function set_country_id($country_id) {
        $this->_country_id = $country_id;
        return $this;
    }

    public function get_country_id() {
        return $this->_country_id;
    }

}
