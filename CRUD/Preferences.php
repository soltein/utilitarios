<?php
/**
 * Classe Preferences para armazenagem de configurações a nível de aplicação
 * @author Matt Zandstra - Entendendo e dominando o PHP
 */
class Preferences {

    private $props = array();
    private static $instance;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (empty(self::$instance))
            self::$instance = new Preferences();

        return self::$instance;
    }

    public function setProperty($key, $val) {
        $this->props[$key] = $val;
    }

    public function getProperty($key) {
        return $this->props[$key];
    }

}

?>