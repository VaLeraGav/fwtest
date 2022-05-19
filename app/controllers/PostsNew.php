<?php

namespace app\controllers;

class PostsNew
{
    public function indexAction()
    {
        echo "PostsNew : index";
    }
    public function testAction()
    {
        echo "PostsNew : test";
    }
    // метод который к которому нет доступа у пользователя 
    public function defore()
    {
        echo "PostsNew : defore";
    }
}
