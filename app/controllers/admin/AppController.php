<?php

namespace app\controllers\admin;
use fw\core\base\Controller;

class AppController extends Controller{
    public $layout = 'default';
    public function __construct($route)
    {
        parent::__construct($route);
        // закрытие админки для пользователя 
        // if(!isset($is_admin) || $is_admin !== 1){
        //     die('Access Denied');
        // }
    }

}
