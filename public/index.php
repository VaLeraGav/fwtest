<?php

use LDAP\Result;

echo "test git";

// rtrim -регистронезависим 
$query = rtrim($_SERVER["QUERY_STRING"]);

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__)); //выходит из папки public
define('APP', dirname(__DIR__) . '/app');

require '../vendor/core/Router.php';
require '../vendor/libs/function.php';


// require '../app/controllers/Main.php';
// require '../app/controllers/Posts.php';...
// заменяем на это 
spl_autoload_register(function ($class) {
    $file = APP . "/controllers/$class.php";
    $file =str_replace('/', '\\',$file);
    if (is_file($file)) {
        require_once $file;
    }
});

Router::add('^pages/?(?P<action>[a-z-]+)?$',['controller' => 'Posts', 'action' => 'index']);

//? defauts routes
// пустая строка
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
// первый за контрольер второй за action
// груперующие скобки 
// помимо стандартных ключей создает и именнованные с помощь ?P
// знаки /?..? - необязательном / и action
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');


Router::dispatch($query);
