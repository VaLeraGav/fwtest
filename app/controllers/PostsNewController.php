<?php

namespace app\controllers;

class PostsNewController extends AppController
{ 
    public function indexAction()
    {
        echo "PostsNew : index ";
    }
    public function testAction()
    {
        echo "PostsNew : test ";
    }
    // метод который к которому нет доступа у пользователя 
    public function before()
    {
        echo "PostsNew : defore ";
    }
}
