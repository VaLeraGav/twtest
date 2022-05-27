<?php 

namespace vendor\core;


trait TSingletone{
    protected static $instance;

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self; // записываем обект
        }
        return self::$instance;
    }

}






