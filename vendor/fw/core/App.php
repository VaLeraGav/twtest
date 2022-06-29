<?php

namespace fw\core;
use fw\core\Registry;
use fw\core\ErrorHandler;
// создавать обект нашего registry

class App{
    public static $app;

    public function __construct() {
        session_start(); // начили сессию
        self::$app= Registry::instance();
        new ErrorHandler();
    }
}


