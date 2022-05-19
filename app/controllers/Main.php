<?php

namespace app\controllers;

class Main extends App
{
    public $layout = "main"; // для всего класс
    public function indexAction()
    {
        // переопределяем определаем какой шаблон будет на странице main на уровне action
        // $this->layout = "main"; 
        // $this->view = "test";

        // когда нужно просто данные без подключения данных 
        // $this->layout = false; // запрет action не применить шаблон 

        // можно на страницу отправить данные внутрь view
        // в нашем случае выведеться имя из views/Main/index.php
        $name = "Angry";
        $this->set(['name'=>$name, 'color'=>"red"]);

    }
}
