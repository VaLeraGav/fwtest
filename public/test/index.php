<?php

// много классов в папке libs
// проблема: если слишком много(10), то тогда нужно создать 10 обектов
// тогда можно создать Автозагрузку и Автосоздание
//  чтобы мы могли получить доступ к ним из любого места

// рееестр -  шаблон проектирования
// есть класс, в нем есть свойство(массив)
// можно в этот массив сохранять создаваемые обекты
// може быть контейнер для настроек...и для много другого
// должен иметь 2 метода(get и set)

// у нас Синглетон — это класс, у которого существует только один экземпляр,

$config = [
    // те классы которые в автозагрузке и путь к нему
    'components' => [
        'cache' => 'classes\Cache',
        'test' => 'classes\Test',
    ],
];

spl_autoload_register(function ($class) {
    $file = str_replace('\\', '/', $class) . ".php";
    if (is_file($file)) {
        require_once $file;
    }
});


class Registry
{
    public static $objects = []; // массив с обектами
    protected static $instance;

    // в контейнере $object будет находиться обектс именем cache and test
    protected function __construct()
    {
        global $config;
        foreach ($config['components'] as $name => $component) {
            self::$objects[$name] = new $component;
        }
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self; // записываем обект
        }
        return self::$instance;
    }

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

$app = Registry::instance();
// $app->getList();
// $app->test->go();
// $app->test2 = 'classes\Test2'; // создаем обект с указанием его пути
// $app->test2->he();
// $app->getList();
// $app->getObject->test->go(); // если не использовали магические методы 