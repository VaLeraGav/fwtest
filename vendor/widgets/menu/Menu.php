<?php

namespace vendor\widgets\menu;

use vendor\libs\Cache;

class Menu
{
    protected $data; // сохранять простой массив с данными 
    protected $tree; // дерево 
    protected $menuHtml; // код меню
    protected $tpl;  // путь к шаблону меню 
    protected $container = 'ul'; // в элемент который нужно обернуть
    protected $table = 'categories'; // таблица из которой берутся данные 
    protected $cache = 3600;
    protected $class = 'menu'; // класс
    protected $cacheKey = 'fw_menu'; // нужен для того чтобы 2 менюшки не конфликтовали , будет 2 файла с кэшом меню

    public function __construct($options = [])
    {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php'; // можно было как свойство но <php5.3 не подеживаются такой формат в свойствах
        $this->getOptions($options);
        $this->run();
    }

    // как будут использоваться, настройки массива menu
    protected function getOptions($options)
    {
        foreach ($options as $k => $v) {
            // проверка сущестование свойства 
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }
    // запускает все методы 
    public function run()
    {
        $cache = new Cache();
        $this->menuHtml = $cache->get($this->cacheKey);
        if (!$this->menuHtml) {
            // нужен массив 
            $this->data = \R::getAssoc("SELECT * FROM $this->table");
            $this->tree = $this->getTree();
            // debug($this->tree);
            $this->menuHtml = $this->getMenuHtml($this->tree);
            $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
        }
        $this->output();
    }
    // вывод menu
    protected function output()
    {
        echo "<{$this->container} class='{$this->class}'>";
        echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    // получение дерева
    protected function getTree()
    {
        $tree = [];
        $data = $this->data; // копия 
        foreach ($data as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    // получение 
    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id); // точка не забыть, так как зыполняет , без нее не сработает рукурсия 
        }
        return $str;
    }
    // отправка категории в шаблон, формировать его 
    protected function catToTemplate($category, $tab, $id)
    {
        // нужна буферезация потому что именно возвращать html code а не  выводить его на экран 
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
}
