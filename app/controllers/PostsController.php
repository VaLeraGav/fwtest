<?php 

namespace app\controllers;

class PostsController extends AppController{
    public $layout = "test";
    // перенесли в Controllers.php
    // public $route= []; // получаем controllers, action
    // public function __construct($route)
    // { $this->route = $route; }

    public function testAction(){
        debug($this->route);
        echo "Posts : test ";
    }
}