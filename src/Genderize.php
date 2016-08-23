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
//        spl_autoload_register(array($this, 'autoload'));
    }

    public function __destruct() {
//        spl_autoload_unregister(array($this, 'autoload'));
    }

    /**
     * @param string $className
     * @return boolean success
     */
//    public function autoload($className) {
//        $className = (string) $className;
//
//        if (strpos($className, 'Genderize\\') === false) {
//            return false;
//        }
//
//        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
//        $className = str_replace('Genderize' . DIRECTORY_SEPARATOR, '', $className);
//
//        $classFileName = ($this->_base_dir) . DIRECTORY_SEPARATOR . "$className.php";
//
//        if (is_file($classFileName)) {
//            require_once($classFileName);
//            return true;
//        }
//
//        throw new ClassNotFoundException($className . ' not found in Genderize namespace');
//    }

}

$recognizer = new Genderize();


