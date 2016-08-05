<?php

namespace PicodiLab\Genderize\Base;

use PicodiLab\Genderize\Exception\NullResponseException;
use PicodiLab\Genderize\Exception\CountryNotSupportedException;
use PicodiLab\Genderize\Resource\Countries;
use PicodiLab\Genderize\Resource\Languages;

/**
 * Main recognizer class for handling gender recognize process
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */
class Recognizer {

    const BASE = 'https://api.genderize.io/';

    protected $_names = null;
    protected $api_key = null;
    protected $_country_id = null;
    protected $_supported_countries = null;
    protected $_supported_languages = null;


    public function __construct($names = null, $country_id = null, $language_id = null, $api_key = null)
    {
        $this->set_names($names)
            ->set_country_id($country_id)
            ->set_language_id($language_id)
            ->set_api_key($api_key);
    }

    /**
     * Recognizes the gender based on object params
     * @param boolean $return_as_object
     * @return Name
     * @throws NullResponseException
     */
    public function recognize($return_as_object = true) {

        $url = $this->_build_url();
        $response = json_decode(file_get_contents($url), true);
        if (is_null($response)) {
            throw new NullResponseException('Empty response received for ' . $url);
        }

        if ($return_as_object) {
            //If an array of names were passed in, return an array of Name objects
            if (is_array($this->get_names())) {
                $nameObjects = array();
                foreach($response as $nameresponse) {
                    $nameObj = new Name();

                    foreach (['name', 'gender', 'probability', 'count', 'country_id'] as $field) {
                        if (!empty($nameresponse[$field])) {
                            $method_name = 'set_' . $field;
                            $nameObj->{$method_name}($nameresponse[$field]);
                        }
                    }

                    $nameObjects[] = $nameObj;
                }
                return $nameObjects;
            } else {
                //DEPRECATED: if a single name was passed in, not as part of an array, return a single Name object
                $nameObj = new Name();
                foreach (['name', 'gender', 'probability', 'count', 'country_id'] as $field) {
                    if (!empty($response[$field])) {
                        $method_name = 'set_' . $field;
                        $nameObj->{$method_name}($response[$field]);
                    }
                }

                return $nameObj;
            }

        } else {
            //If an array of names were passed in, return an array of name=>gender responses
            if (is_array($this->get_names())) {
                $genders = array();
                foreach($response as $nameresponse) {
                    if (isset($nameresponse['name']) && $nameresponse['name']) {
                        $genderresponse = array('name' => $nameresponse['name']);
                        if (isset($nameresponse['gender'])) {
                            $genderresponse['gender'] = $nameresponse['gender'];
                        }
                        $genders[] = $genderresponse;
                    }
                }
                return $genders;
            } else {
                //DEPRECATED: if a single name was passed in, not as part of an array, return a single gender response
                return !empty($response['gender']) ? $response['gender'] : null;
            }
        }
    }

    /**
     * Builds the valid genderize.io API url.
     * @return string
     */
    protected function _build_url() {

        $params = array_filter([
            'name' => $this->_names,
            'country_id' => $this->_country_id,
            'language_id' => $this->_language_id,
                ], function($v) {
            if (!is_array($v)) {
                return strlen(trim($v)) > 0;
            } else {
                return $v;
            }
        });
        //Only pass apikey if there is one set
        if ($api_key = $this->get_api_key()) {
            $params['apikey'] = trim($api_key);
        }

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
            $Countries = new Countries();
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
            $Languages = new Languages();
            $this->_supported_languages = $Languages->get();
        }
        return in_array($language_id, $this->_supported_languages);
    }

    // <editor-fold desc="Setters and getters">

    public function set_country_id($country_id, $check_if_valid = true) {
        $country_id = strtoupper(trim($country_id));
        if ($check_if_valid) {
            if (!empty($country_id) && !$this->is_country_supported($country_id)) {
                throw new CountryNotSupportedException('Country ' . $country_id . ' is not supported');
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
                throw new CountryNotSupportedException('Language ' . $language_id . ' is not supported');
            }
        }
        $this->_language_id = $language_id;
        return $this;
    }

    public function get_language_id() {
        return $this->_language_id;
    }

    public function set_names($names) {
        $this->_names = $names;
        return $this;
    }

    public function get_names() {
        return $this->_names;
    }

    public function set_api_key($api_key) {
        $this->_api_key = $api_key;
    }

    public function get_api_key() {
        return $this->_api_key;
    }

    // </editor-fold>
}
