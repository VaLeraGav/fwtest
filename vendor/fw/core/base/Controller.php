<?php

namespace fw\core\base;

abstract class Controller
{
    public $route = []; // получаем controller, action, param
    public $view;
    public $layout;
    public $vars = []; // массив пользовательские даннные

    public function __construct($route)
    {
        $this->route = $route;
        // подключение view
        // $this->view = $route['action'];
        // include APP. "/views/{$route['controller']}/{$this->view}.php";
        $this->view = $route['action'];
    }

    // создает обьект вида
    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    // будет заполнять свойства, принимает параметры 
    public function set($vars)
    {
        $this->vars = $vars;
    }

    // определяет был ли ajax запрос 
    // проверяет поступили ли данные асинхронно 
    public function isAjax() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    // подключение view
    public function loadView($view,$vars=[])
    {
            extract($vars); //  Импортирует переменные из массива в текущую таблицу символов
            require APP . "/views/{$this->route['controller']}/{$view}.php";
    }

}
