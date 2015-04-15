<?php
/**
 * Genderize.io handler for PHP
 *
 * @author barttyrant <bartlomiej@tyranowski.pl>
 */
class Genderize {

    protected $_base_dir = '';

    public function __construct() {
        $this->_base_dir = dirname(__FILE__);
        spl_autoload_register(array($this, 'autoload'));
    }

    public function __destruct() {
        spl_autoload_unregister(array($this, 'autoload'));
    }

    /**
     * @param string $className
     * @return boolean success
     */
    public function autoload($className) {
        $className = (string) $className;

        if (strpos($className, 'Genderize\\') === false) {
            return false;
        }

        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $className = str_replace('Genderize/', '', $className);
        $classFileName = $className . '.php';

        $classFileName = ($this->_base_dir) . DIRECTORY_SEPARATOR . "$className.php";

        if (is_file($classFileName)) {
            require_once($classFileName);
            return true;
        }

        throw new Genderize\Exception\ClassNotFoundException($className . ' not found in Genderize namespace');
    }

}

$recognizer = new Genderize();


