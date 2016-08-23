<?php

/**
 * Genderize.io handler for PHP
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */

namespace Genderize;

use Genderize\Base\Recognizer;
use Genderize\Exception\ClassNotFoundException;


class Genderize {

    protected $_base_dir = '';

    public static function factory($name = null, $country_id = null, $language_id = null) {
        return new Recognizer($name, $country_id, $language_id);
    }

    public function __construct() {
        $this->_base_dir = dirname(__FILE__);
        spl_autoload_register(array($this, 'autoload'));
    }

    public function __destruct() {
        spl_autoload_unregister(array($this, 'autoload'));
    }
    
}

$recognizer = new Genderize();


