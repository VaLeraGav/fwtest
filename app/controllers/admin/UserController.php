<?php

namespace app\controllers\admin;

use fw\core\base\View;

class UserController extends AppController
{
    public $layout = 'admin';
    public function indexAction()
    {
        View::setMeta('Admin::Главная страница', 'описание админки', 'ключи админки');
        $test = 'Тестовая переменная';
        $data = ['test', '2'];
        // 1 вариант передача данных
        // $this->set([
        //     'test' => $test,
        //     'data' => $data,
        // ]);
        // 2 вариант 
        $this->set(compact('test', 'data'));


    }
    public function testAction()
    {
        echo __METHOD__;
    }
}
