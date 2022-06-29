<?php

namespace app\controllers;

use app\models\User;
use fw\core\base\View;

class UserController extends AppController
{

    public function signupAction()
    {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            // if(!$user->validate($data)) вывед ошибок в валидации
            // {
            //     $user->getErrors();
            // }
            // die;

            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
                $_SESSION['form_data'] = $data; // запоминание формы
                redirect();
            }
            $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);  // хэширование пороля 
            if ($user->save('user')) {
                $_SESSION['success'] = 'Вы успешно зарегистрированы';
            } else {
                $_SESSION['error'] = 'Ошибка! Попробуйте позже';
            }
            
            redirect();

            // debug($user);
            // debug($_POST);
            // die;
        }
        View::setMeta('Регистрация');
    }
    public function loginAction()
    {
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){
                $_SESSION['success'] = "Вы успешно зарегистрировались";
            } else {
                $_SESSION['error'] = 'Логин/Пороль введены неправильно';
            }
            redirect('/');
        }
        View::setMeta('Вход');
    }
    public function logoutAction()
    {
        if(isset($_SESSION['user'])) unset ($_SESSION['user']);
        redirect('/user/login');
    }
}
