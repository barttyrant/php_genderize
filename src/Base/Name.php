<?php

namespace Genderize\Base;

/**
 * Description of Name
 *
 * @author barttyrant
 */
class Name {

    protected $_name;
    protected $_count;
    protected $_gender;
    protected $_probability;

    public function __construct($name = null) {
        $this->_set_defaults(['name' => $name]);
    }

    protected function _set_defaults($params = []) {

        $defaults = [
            'name' => null,
            'count' => 0,
            'gender' => null,
            'probability' => 0.00
        ];

        $params = array_merge($defaults, $params);

        foreach ($params as $k => $v) {
            $_k = '_' . $k;
            $this->$_k = $v;
        }
    }

    public function is_male() {
        return $this->_gender == 'male';
    }

    public function is_female() {
        return $this->_gender == 'female';
    }

    public function recognize($country_id = null) {
        $Recognizer = new \Genderize\Recognizer($country_id);
        return $Recognizer->recognize($country_id);
    }

    public function clear() {
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
