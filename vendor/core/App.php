<?php

namespace vendor\core;
use vendor\core\Registry;
use vendor\core\ErrorHandler;
// создавать обект нашего registry

class App{
    public static $app;

    public function __construct() {
        self::$app= Registry::instance();
        new ErrorHandler();
    }
}


