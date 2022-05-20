<?php

namespace vendor\core\base;

class View
{

    public $route = []; //текущий маршруты  
    public $view; // текущий вид
    public $layout; // текущий шаблон

    // создание view
    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;
        if ($layout === false) // для запрета подкоючения шаблонов внутри action
        {
            $this->layout === false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }
        $this->view = $view;
    }

    // подключение view шаблон и определять переменные из controller
    public function render($vars)
    {
        // extract - извлекает эл массива и создает одноименные переменные  
        if(is_array($vars)) extract($vars);
        $file_view =  APP . "/views/{$this->route['controller']}/{$this->view}.php"; // путь к нашему виду 
        // ob_start — Включение буферизации вывода
        // Если буферизация вывода активна, никакой вывод скрипта не отправляется (кроме заголовков), а сохраняется во внутреннем буфере.
        ob_start();
        if (is_file($file_view)) {
            require $file_view;
        } else {
            echo "<p>не найден{$file_view}</p>";
        }
        $content = ob_get_clean(); // все echo и require записалось в эту переменную 
        if (false !== $this->layout) {
            $file_layout = APP . "/views/layout/{$this->layout}.php";
            if (is_file($file_layout)) {
                require $file_layout;
            } else {
                echo "<p>не найден шаблон <b>$file_layout</b></p>";
            }
        }
    }
}
