<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{
    public $layout = "default"; // для всего класс
    public function indexAction()  // если поменять на action то будет искаться /main
    {
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

        // $posts = $model->findAll(); // записываеться  данные с БД в массив posts и передает в Main/index.php
        // $res = $model->query("CREATE TABLE posts2 SELECT * FROM yii2.posts"); // создаем копию таблицы posts
        // $post = $model->findOne(2);
        // $date = $model->findBySql("SELECT * FROM {$model->table} ORDER BY id DESC LIMIT 1");
        // $date = $model->findLike('Тест', 'title');

        $posts = \R::findAll('posts'); // не создаем model->...
        // $menu = \R::FindAll('category');
        $menu = $this->menu;

        $this->setMeta('Главная страница', 'Описание страницы', 'Ключевые слова');
        $meta = $this->meta;
        
        // compact — Создаёт массив, содержащий названия переменных и их значения
        $this->set(compact('title', 'posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        $this->layout = 'test';
    }
}
