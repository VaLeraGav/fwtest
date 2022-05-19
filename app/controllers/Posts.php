<?php 

namespace app\controllers;

class Posts extends App{

    // перенесли в Controllers.php
    // public $route= []; // получаем controllers, action
    // public function __construct($route)
    // { $this->route = $route; }

    public function indexAction(){
        echo "Posts : index";
    }
    public function testAction(){
        debug($this->route);
        echo "Posts : test";
    }
}