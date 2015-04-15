<?php

namespace Genderize\Base;

/**
 * Description of Name
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */
class Name {

    protected $_name;
    protected $_count;
    protected $_gender;
    protected $_probability;

    public function __construct($name = null) {
        $this->_set_defaults(['name' => $name]);
    }

    /**
     * sets default values for all object variables
     * @param type $params
     */
    protected function _set_defaults($params = []) {

        $defaults = [
            'name' => null,
            'count' => 0,
            'gender' => null,
            'probability' => 0.00,

        ];

        $params = array_merge($defaults, $params);

        foreach ($params as $k => $v) {
            $_k = '_' . $k;
            $this->$_k = $v;
        }
    }

    /**
     * checks whether current name is recognized as a male one.
     * @return boolean
     */
    public function is_male() {
        return $this->_gender == 'male';
    }

    /**
     * checks whether current name is recognized as a female one.
     * @return boolean
     */
    public function is_female() {
        return $this->_gender == 'female';
    }

    /**
     * Triggers regognize request based on current params
     * @param string $country_id | optional
     * @return Name
     */
    public function recognize($country_id = null) {
        $Recognizer = new Recognizer($country_id);
        $Recognizer->recognize($country_id);
        return $this;
    }

    /**
     * resets all object values
     */
    public function reset() {
        $this->_set_defaults();
    }

    // <editor-fold desc="Setters and getters">

    public function set_name($name) {
        $this->_name = $name;
        return $this;
    }

    public function set_probability($probability) {
        $this->_probability = $probability;
        return $this;
    }

    public function set_count($count) {
        $this->_count = $count;
        return $this;
    }

    public function set_gender($gender) {
        $this->_gender = $gender;
        return $this;
    }

    public function set_country_id($country_id) {
        $this->_country_id = $country_id;
        return $this;
    }

    public function get_name() {
        return $this->_name;
    }

    public function get_probability() {
        return $this->_probability;
    }

    public function get_count() {
        return $this->_count;
    }

    public function get_gender() {
        return $this->_gender;
    }

    public function get_country_id() {
        return $this->_country_id;
    }

    // </editor-fold>
}
