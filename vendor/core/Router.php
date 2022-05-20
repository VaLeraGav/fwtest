<?php

namespace vendor\core; // от корня приложения tstest

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
            // patern и url, mathes-сохнаем в эту переменную
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
                $route['controller'] = self::upperCamelCase($route['controller']); // с заглавное буквы 
                // debug($route);
                // [comtroller] => post
                // [action] => per

                self::$route = $route;
                return true;
            }
        return false; // если был введен несущесвующий адрес  
    }

    // отправка, перенаправляет url по коректному маршруру 
    // string $url 
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            // 'app\controllers\\'- нужно для пространства имен, добавили после добавления nemespace
            $controller = 'app\controllers\\' . self::$route['controller'] . 'Controller'; // добавили Controller для нахождение classContoller
            // Проверяет, был ли определен класс
            if (class_exists($controller)) {
                // проверка на существоание action 
                $cObj = new $controller(self::$route); // передает информацию в контроллер 
                $action = self::lowerCamelCase(self::$route['action']) . 'Action'; // Action для запрета доступа
                if (method_exists($cObj, $action)) {
                    $cObj->$action(); // не забыть ()
                    $cObj->getView();
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
    // обрезать url параметры 
    protected static function removeQueryString($url)
    {
        if ($url) {
            $params = explode('&', $url, 2); // 2 элемента 
            if (false === strpos($params[0], '=')) // strpos — Находит позицию первого вхождения подстроки в строку
            {
                return rtrim($params[0], '/'); // rtrim — Удаляет пробелы (или другие символы) из конца строки
            } else {
                return '';
            }
        }
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
