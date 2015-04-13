<?php

namespace Genderize\Base;

/**
 * Description of Name
 *
 * @author barttyrant
 */
class Name {

    protected $_name = null;
    protected $_probability = 0.00;

    public function __construct($name = null) {
        $this->set_name($name);
    }

    public function is_male() {

    }

    public function is_female() {

    }

    public function recognize($country_id = null) {
        $Recognizer = new \Genderize\Recognizer($country_id);
        return $Recognizer->recognize($country_id);
    }

    public function clear() {
        $this->_name = null;
        $this->_probability = 0.00;
    }

    // <editor-fold desc="Setters and getters">

    public function set_name($name) {
        $this->_name = $name;
        return $this;
    }

    public function get_name() {
        return $this->_name;
    }

    public function get_probability() {
        return $this->_probability;
    }

    // </editor-fold>
}
