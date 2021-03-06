<?php

// error_reporting(-1); //для вывода всех ошибок

use fw\core\Router;

// rtrim - удаляет пробелы
$query = rtrim($_SERVER["QUERY_STRING"], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/fw/core');
define('ROOT', dirname(__DIR__)); //выходит из папки public
define('APP', dirname(__DIR__) . '/app');
define('LAYOUT', 'blog');
define('LIBS', dirname(__DIR__) . '/vendor/fw/libs');
define('CACHE', dirname(__DIR__) . '/tmp/cache');
define("DEBUG", 1); // режим разработки 1-разработки 0-чистовик 


require '../vendor/fw/libs/function.php';
require __DIR__ . '/../vendor/autoload.php';

// require '../app/controllers/Main.php';
// require '../app/controllers/Posts.php';...
// заменяем на это 
// spl_autoload_register(function ($class) {
//     $file = ROOT . '/' . str_replace('\\', '/', $class) . ".php";
//     // $file = APP . "/controllers/$class.php";
//     // $file = str_replace('/', '\\', $file);
//     if (is_file($file)) {
//         require_once $file;
//     }
// });

new \fw\core\App;

Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']); // пробелы влияют на поиск 
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']); // twtest.local/page/view/kfk Одно и тоже twtest.local/page/kfk


//? defauts routes
// правило приоритетов 
Router::add('^admin$', ['controller' => 'User', 'action' => 'index', 'prefix'=>'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$',['prefix'=>'admin']);

// пустая строка
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
// первый за контрольер второй за action
// груперующие скобки 
// помимо стандартных ключей создает и именнованные с помощь ?P
// знаки /?..? - необязательном / и action
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

// debug(Router::getRoutes());

Router::dispatch($query);
