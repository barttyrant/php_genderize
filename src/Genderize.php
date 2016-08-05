<?php

namespace PicodiLab\Genderize;

use PicodiLab\Genderize\Base\Recognizer;

/**
 * Genderize.io handler for PHP
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */
class Genderize {

    protected $_base_dir = '';
    private $recognizer;

    public function __construct($name = null, $country_id = null, $language_id = null) {
        $this->recognizer = new Recognizer($name, $country_id, $language_id);
    }
    
    public function getRecognizer(){
        return $this->recognizer;
    }
    
    public function recognize(){
        return $this->recognizer->recognize();
    }
}


