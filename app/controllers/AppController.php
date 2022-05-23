<?php
// нужен чтобы не лазить в ядро сайта а будем пользоваться на уровне приложения 
namespace app\controllers;

use vendor\core\base\Controller;

class AppController extends Controller
{
    // public function test() // одщий метод для, будет виден во всех страницах 
    // {  echo __METHOD__;  }

    public $meta = [];
    public $menu; //  будет доступна для всех наследоваюмых контроллеров 
    public function __construct($route)
    {
        parent::__construct($route);
        // нет меню maine/test
        if ($this->route['action'] === 'test') {
            echo "только для тех страниц где есть action : {$route['action']}"; 
        }
        
        new \app\models\Main; // для инициализации(соеднинени с БД)
        $this->menu = \R::FindAll('category');
    }

    protected function setMeta($title = '', $desc = '', $keywords = '')
    {
        $this->meta['title']=$title;
        $this->meta['desc']=$desc;
        $this->meta['keywords']=$keywords;
    }
}
