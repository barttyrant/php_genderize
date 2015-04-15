<?php

namespace Genderize\Base;

/**
 * Main recognizer class for handling gender recognize process
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */
class Recognizer {

    const BASE = 'https://api.genderize.io/';

    protected $_name = null;
    protected $_country_id = null;
    protected $_supported_countries = null;
    protected $_supported_languages = null;

    public function __construct($name = null, $country_id = null, $language_id = null) {
        $this->set_name($name)
                ->set_country_id($country_id)
                ->set_language_id($language_id);
    }

    /**
     * Recognizes the gender based on object params
     * @param boolean $return_as_object
     * @return \Genderize\Base\Name
     * @throws \Genderize\Exception\NullResponseException
     */
    public function recognize($return_as_object = true) {

        $url = $this->_build_url();
        $response = json_decode(file_get_contents($url) . '...', true);

        if (is_null($response)) {
            throw new \Genderize\Exception\NullResponseException('Empty response received for ' . $url);
        }

        if ($return_as_object) {
            $nameObj = new Name();

            foreach (['name', 'gender', 'probability', 'count', 'country_id'] as $field) {
                if (!empty($response[$field])) {
                    $method_name = 'set_' . $field;
                    $nameObj->{$method_name}($response[$field]);
                }
            }

            return $nameObj;
        } else {
            return !empty($response['gender']) ? $response['gender'] : null;
        }
    }

    /**
     * Builds the valid genderize.io API url.
     * @return string
     */
    protected function _build_url() {

        $params = array_filter([
            'name' => $this->_name,
            'country_id' => $this->_country_id,
            'language_id' => $this->_language_id,
                ], function($v) {
            return strlen(trim($v)) > 0;
        });

        return self::BASE . '?' . http_build_query($params);
    }

    /**
     * checks if country valid (ISO 3166-1 alpha-2)
     * @see https://genderize.io/#localization
     * @param string $country_id
     * @return boolean
     */
    protected function is_country_supported($country_id) {
        if (is_null($this->_supported_countries)) {
            $Countries = new \Genderize\Resource\Countries();
            $this->_supported_countries = $Countries->get();
        }

        return in_array($country_id, $this->_supported_countries);
    }

    /**
     * checks if language valid (ISO 639-1)
     * @see https://genderize.io/#localization
     * @param string $language_id
     * @return boolean
     */
    protected function is_language_supported($language_id) {
        if (is_null($this->_supported_languages)) {
            $Languages = new \Genderize\Resource\Languages();
            $this->_supported_languages = $Languages->get();
        }
        return in_array($language_id, $this->_supported_languages);
    }

    // <editor-fold desc="Setters and getters">

    public function set_country_id($country_id, $check_if_valid = true) {
        $country_id = strtoupper(trim($country_id));
        if ($check_if_valid) {
            if (!empty($country_id) && !$this->is_country_supported($country_id)) {
                throw new \Genderize\Exception\CountryNotSupportedException('Country ' . $country_id . ' is not supported');
            }
        }
        $this->_country_id = $country_id;
        return $this;
    }

    public function get_country_id() {
        return $this->_country_id;
    }

    public function set_language_id($language_id, $check_if_valid = true) {
        $language_id = strtolower(trim($language_id));
        if ($check_if_valid) {
            if (!empty($language_id) && !$this->is_language_supported($language_id)) {
                throw new \Genderize\Exception\CountryNotSupportedException('Language ' . $language_id . ' is not supported');
            }
        }
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
