<?php

namespace Genderize;

/**
 * Description of Recognizer
 *
 * @author barttyrant
 */
class Recognizer {

    protected $_name = null;
    protected $_country_id = null;
    protected $_supported_countries = null;
    protected $_supported_languages = null;

    public function __construct($name, $country_id, $language_id) {
        $this->set_name($name)
                ->set_country_id($country_id)
                ->set_language_id($language_id);
    }

    /**
     * @TODO implement this shit
     */
    public function recognize() {
        
    }

    /**
     * @TODO implement this shit
     */
    protected function _build_url($name, $country_id, $language) {

    }

    /**
     * checks if country valid
     * @param string $country_id
     * @return boolean
     */
    protected function is_country_supported($country_id) {
        if (is_null($this->_supported_countries)) {
            // load supported countries
        }
        return in_array($country_id, $this->_supported_countries);
    }

    /**
     * checks if language valid
     * @param string $language_id
     * @return boolean
     */
    protected function is_language_supported($language_id) {
        if (is_null($this->_supported_languages)) {
            // load supported languages
        }
        return in_array($language_id, $this->_supported_languages);
    }

    // <editor-fold desc="Setters and getters">

    public function set_country_id($country_id) {
        $this->_country_id = $country_id;
        return $this;
    }

    public function get_country_id() {
        return $this->_country_id;
    }

    public function set_language_id($language_id) {
        $this->_language_id = $language_id;
        return $this;
    }

    public function get_language_id() {
        return $this->_language_id;
    }

    public function set_name($name) {
        $this->_name = $name;
        return $this;
    }

    public function get_name() {
        return $this->_name;
    }

    // </editor-fold>
}
