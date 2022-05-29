<?php

namespace vendor\widgets\menu;

class Menu
{
    protected $data; // сохранять простой массив с данными 
    protected $tree; // дерево 
    protected $menuHtml; // код меню
    protected $tpl;  // путь к шаблону меню 
    protected $container; // за элемент который нужно обернуть
    protected $table; // за таблицу из которой беруться данные 
    protected $cache;

    public function __construct()
    {
        $this->run();
    }

    // запусукает все методы 
    public function run()
    {
        // нужен массив 
        $this->data = \R::getAssoc("SELECT * FROM categories");
        $this->tree = $this->getTree();
        debug($this->tree);
    }

    // получение дерева
    protected function getTree(){
        $tree = [];
        $data = $this->data; // копия 
        foreach ($data as $id=>&$node) {
            if (!$node['parent']){
                $tree[$id] = &$node;
            }else{
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

    // получение 
    protected function getMenuHtml($tree, $tab = ''){

    }
    // отправка категории в шаблон 
    protected function catToTemplate($category, $tab, $id){

    }


}
