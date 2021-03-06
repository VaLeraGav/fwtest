<?php

namespace fw\core\base;

class View
{

    public $route = []; //текущий маршруты  
    public $view; // текущий вид
    public $layout; // текущий шаблон
    public $scripts = []; // будет хранится script
    public static $meta = ['title' => '', 'desc' => '', 'keywords' => ''];

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

    // сжатие данных
    public function compressPage($buffer)
    {
        $search = [
            "/(\n)+/",
            "/\r\n+/",
            "/\n(\t)+/",
            "/\n(\ )+/",
            "/\>(\n)+</",
            "/\>\r\n</",
        ];
        $replace = [
            "\n",
            "\n",
            "\n",
            "\n",
            '><',
            '><',
        ];
        return $buffer = preg_replace($search, $replace, $buffer);
    }

    // подключение view шаблон и определять переменные из controller
    public function render($vars)
    {
        $this->route['prefix'] = str_replace('\\', '/', $this->route['prefix']); // для подключения вида, для admin
        // extract - извлекает эл массива и создает одноименные переменные  
        if (is_array($vars)) extract($vars);
        $file_view =  APP . "/views/{$this->route['prefix']}{$this->route['controller']}/{$this->view}.php"; // путь к нашему виду 
        // ob_start — Включение буферизации вывода
        // Если буферизация вывода активна, никакой вывод скрипта не отправляется (кроме заголовков), а сохраняется во внутреннем буфере.
        ob_start([$this, 'compressPage']); // пользовательское сжатие 
        // ob_start('ob_gzhandler');
        {
            // header('Content-Encoding: gzip'); // для ob_gzhandler
            if (is_file($file_view)) {
                require $file_view;
            } else {
                // echo "<p>не найден{$file_view}</p>";
                throw new \Exception("не найден{$file_view}", 404);
            }
        }

        $content = ob_get_contents();
        ob_clean();
        // $content = ob_get_clean(); // все echo и require записалось в эту переменную, все содержание нашего view,убрали когда добавили сжатие 
        if (false !== $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                $content = $this->getScript($content);  // усли убрать то все скрипты уберуться
                $scripts = []; //  будет хранится script
                if (!empty($this->scripts[0])) {
                    $scripts = $this->scripts[0];
                }
                require $file_layout;
            } else {
                // echo "<p>не найден шаблон <b>$file_layout</b></p>";
                throw new \Exception("не найден шаблон $file_layout", 404);
            }
        }
    }
    // $content - все содержимое нашего view
    // вырезает наши скрипты так как ошибка : $ is not defined
    // script должен находиться снизу 
    protected function getScript($content)
    {
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
        if (!empty($this->scripts)) {
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }


    // возвращает в html 
    public static function getMeta()
    {
        echo '<title>' . self::$meta['title'] . '</title>
        <meta name="description" content="' . self::$meta['desc'] . '">
        <meta name="keywords" content="' . self::$meta['keywords'] . '">';
    }

    // устанавливает 
    public static function setMeta($title = '', $desc = '', $keywords = '')
    {
        self::$meta['title'] = $title;
        self::$meta['desc'] = $desc;
        self::$meta['keywords'] = $keywords;
    }


    public function getPart($file)
    {
        if (false !== $this->layout) {
            $file = APP . "/views/{$file}.php";
            if (is_file($file)) {
                require_once $file;
            } else {
                echo "не найден файл $file";
            }
        }
    }
}
