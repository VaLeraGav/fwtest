<?php

namespace fw\core;


class Registry
{
    use TSingletone;
    public static $objects = []; // массив с обектами
    // protected static $instance;


    // в контейнере $object будет находиться обектс именем cache and test
    protected function __construct()
    {
    require ROOT . '/config/config.php';
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }
    // в TSing
    // public static function instance()
    // {
    //     if (self::$instance === null) {
    //         self::$instance = new self; // записываем обект
    //     }
    //     return self::$instance;
    // }

    // обращение к неизвестному свойству которого нет 
    public function __get($name)
    {
        if (is_object(self::$objects[$name])) {
            return self::$objects[$name];
        }
    }

    // записать в неопределенный метод
    // $app->test2 = "путь к классу"
    public function __set($name, $object)
    {
        if(!isset(self::$objects[$name])){
            self::$objects[$name] = new $object;
        }
    }

    public function getList()
    {
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }
}