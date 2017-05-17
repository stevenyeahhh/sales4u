<?php
 
class Singleton {

    private static $instance;
    private $values;

    private function __construct() {
        
    }

    public static function getInstance() { 
        if (!self::$instance instanceof self) {
            self::$instance = new Singleton;
        }
        return self::$instance;
    }

    public function __set($name, $value) {
        $this->values[$name] = $value;
    }

    public function __get($name) {
        return $this->values[$name];
    }

}
