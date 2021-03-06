<?php

namespace app\controllers;

use app\models\Main;
use fw\core\App;
use fw\core\base\View;
use fw\libs\Pagination;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;

class MainController extends AppController
{
    // public $layout = "default"; // для всего класс
    public function indexAction()  // если поменять на action то будет искаться /main
    {
        // App::$app->getlist();

        // переопределяем определаем какой шаблон будет на странице main на уровне action
        // $this->layout = "main"; 
        // $this->view = "test";

        // когда нужно просто данные без подключения данных 
        // $this->layout = false; // запрет action не применить шаблон 

        // можно на страницу отправить данные внутрь view
        // в нашем случае выведеться имя из views/Main/index.php
        // $name = "Angry";
        // $this->set(['name'=>$name, 'color'=>"red"]);
        $model = new Main;

        $total = \R::count('posts');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 2;
        $pagination = new Pagination($page,$perpage,$total);
        $start = $pagination->getStart();

        // \R::fancyDebug(true); // проерка запросов 
        // cache дольжен находиться как можно выше

        $posts = \R::findAll('posts', "LIMIT $start, $perpage");

        // кэширование
        // $posts =  App::$app->cache->get('posts');     

        // if(!$posts) // идет запись если нет cache
        // {
        //     $posts = \R::findAll('posts');
        //     App::$app->cache->set('posts', $posts, 3600 * 24);
        // }

        // $posts = $model->findAll(); // записываеться  данные с БД в массив posts и передает в Main/index.php
        // $res = $model->query("CREATE TABLE posts2 SELECT * FROM yii2.posts"); // создаем копию таблицы posts
        // $post = $model->findOne(2);
        // $date = $model->findBySql("SELECT * FROM {$model->table} ORDER BY id DESC LIMIT 1");
        // $date = $model->findLike('Тест', 'title');

        // $posts = \R::findAll('posts'); // не создаем model->..., все посты выводит 
        // $post = \R::findOne('posts', 'id = 1');
        // проверка Cache
        // App::$app->cache->set('posts', $posts, 3600 * 24); // сутки 
        // echo date('Y-m-d H:i', time() ); 
        // echo '<br>';
        // echo date('Y-m-d H:i', 1653406577 );
        // echo '<br>';

        // $menu = \R::FindAll('category');
        $menu = $this->menu;

        // убралив 13 уроке
        // $this->setMeta('Главная страница', 'Описание страницы', 'Ключевые слова');
        // $meta = $this->meta;
        View::setMeta('Blog::Главная страница', 'Описание страницы', 'Ключевые слова');

        // compact — Создаёт массив, содержащий названия переменных и их значения
        $this->set(compact('title', 'posts', 'pagination', 'total')); // 'menu', 'meta' убрали


        // create a log channel
        // $log = new Logger('name');
        // $log->pushHandler(new StreamHandler(ROOT . 'tmp/your.log'), Level::class);

        // // add records to the log
        // $log->warning('Foo');
        // $log->error('Bar');
    }



    // есть скрипт, нужен для конкретной страницы
    // 1 подход :
    // мы подключаем нужный скрипт в контроллере
    // в action отвечающий за данную страницу 
    // будет подключать для страницы нужные скрипыты
    // поместить весь JS в один файл
    // 2 подход :
    // подключение скриптов непосредственно в нужном виде 
    // часто используется в фреймворках(мы будем использовать именно его)

    // core\base\Controller дополнительный метод который определяет пришел ли ajax запрос 
    public function testAction()
    {
        if ($this->isAjax()) {
            // выводит в консоль при нажатии, информацию по 2 посту а именно какие смотреть в /Main/test.php
            // 2 потому что Ajax id = 2
            $model = new Main();
            //  в 16 уроке отключили 
            $post = \R::findOne('posts', "id = {$_POST['id']}"); // получить 1 запись 
            $this->loadView('_test', compact('post'));
            // echo 111;   // асинхронный запрос, при нажатии кнопки 

            // выведет в консоли текст массива 
            // $data = ['answer'=>'Ответ с сервера','code'=> 200]; // в качестве ответа для ajax
            // echo json_encode($data);
            die;    // завершение скрипта 
        }
        echo 222;   // при стандартном обращении через url
        // $this->layout = false;
    }
}
