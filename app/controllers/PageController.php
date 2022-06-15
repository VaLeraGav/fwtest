<?php

namespace app\controllers;

class PageController extends AppController{

    // public $layout = "default"; // для всего класс, для setMeta
    // public function indexAction(){
    //     echo "Posts : index (indexAction) ";
    // }

    public function viewAction(){
        // debug($this->route);

        // обязательные то что внизу 
        // $posts = \R::findAll('posts');

        // $menu=$this->menu; 
        // $this->set(compact('title', 'menu'));
       
        // $menu=$this->menu; 
        // $this->set(compact('title', 'menu','meta'));

        $title = 'Страница';
        $this->set(compact('title', 'menu'));
    }

}