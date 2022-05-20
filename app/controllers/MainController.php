<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{
    public $layout = "default"; // для всего класс
    public function indexAction()
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

        // $res = $model->query("CREATE TABLE posts2 SELECT * FROM yii2.posts"); // создаем копию таблицы posts
        // var_dump($res);

        $posts = $model->findAll(); // записываеться  данные с БД в массив posts и передает в Main/index.php
        $title = 'PAGE TITLE';

        // compact — Создаёт массив, содержащий названия переменных и их значения
        $this->set(compact('title', 'posts')); 
    }
}
