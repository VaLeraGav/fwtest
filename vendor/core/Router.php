<?php

// от него не будет наследования
class Router
{
    protected static $routes = []; // массив в нем содержиться все маршруты 
    protected static $route = []; // один маршрут, текущий, будем знать какой action в данный момент работает 

    // добавляет маршрут в таблицу маршрутов 
    // $regexp -  ругулярное выражение 
    // $route(необ) - маршрут URL- адреса
    public static function add($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    // проверка совпадения url в таблице маршрутов 
    protected static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route)
            // if ($url === $patern)
            // patern url mathes-сохнаем в эту переменную
            // ограничители шаблона "#...#i" i-регистронезависим 
            if (preg_match("#$pattern#i", $url, $matches)) {
                // debug($matches);
                // http://twtest.local/post/per
                // [0] => post/per
                // [comtroller] => post
                // [1] => post
                // [action] => per
                // [2] => per
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $route[$k] = $v;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'action';
                }
                debug($route);
                // [comtroller] => post
                // [action] => per

                self::$route = $route;
                return true;
            }
        return false; // если адрес несущесвующий был введен  
    }

    // отправка, перенаправляет url по коректному ммаршруру 
    // string $url 
    public static function dispatch($url)
    {
        if (self::matchRoute($url)) {
            $controller = self::upperCamelCase(self::$route['controller']);
            // Проверяет, был ли определен класс
            if (class_exists($controller)) {
                // проверка на существоание action 
                $cObj = new $controller;
                $action = self::lowerCamelCase(self::$route['action']) . 'Action'; //Action для запрета доступа
                if (method_exists($cObj, $action)) {
                    $cObj->$action(); // не забыть ()
                } else {
                    echo "<br>метод <b>$controller::$action</b> не найден";
                }
            } else {
                echo "<br>контроллер <b>$controller</b> не найден";
            }
        } else {
            http_response_code(404);
            include '404.html';
        }
    }

    // приведение к верхнему гегистру postr-new  переделывает в PostsNew
    protected static function upperCamelCase($name)
    {
        // $name=str_replace('-', ' ',$name );
        // $name = ucwords($name);
        // $name=str_replace(' ', '',$name );
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
    // приводит test-page -> testPage 
    protected static function lowerCamelCase($name)
    {
        return lcfirst(self::upperCamelCase($name));
    }


    // для отладки
    public static function getRoutes()
    {
        return self::$routes;
    }
    public static function getRoute()
    {
        return self::$route;
    }
}
