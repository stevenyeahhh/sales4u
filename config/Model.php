<?php

class Model { 

    public function __construct() {
        
    } 

    public function getDb() {
        return Singleton::getInstance()->db;
    }

}
