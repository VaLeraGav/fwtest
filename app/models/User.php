<?php

namespace app\models;

use fw\core\base\Model;

class User extends Model
{
    // такой формат дает гибкость, например по умолчанию 
    public $attributes = [
        'login' => '',
        'password' => '',
        'email' => '',
        'name' => '',
    ];

    public $rules = [
        'required' => [
            ['login'],
            ['password'],
            ['email'],
            ['name'],
        ],
        'email' => [
            ['email'],
        ],
        'lengthMin' => [
            // длина пороля
            ['password', 3],
        ]
    ];

    // проверка уникальности 
    public function checkUnique(){
        $user = \R::findOne('user', 'login = ? OR email = ? LIMIT 1', [$this->attributes['login'], $this->attributes['email']]);
        if($user){
            if($user->login == $this->attributes['login']){
                $this->errors['unique'][] = 'Этот логин уже занят';
            }
            if($user->email == $this->attributes['email']){
                $this->errors['unique'][] = 'Этот email уже занят';
            }
            return false;
        }
        return true;
    }


    public function login(){
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if($login && $password){
            $user = \R::findOne('user', 'login = ? LIMIT 1', [$login]); // достаем по логину пользователя 
            if($user){
                if(password_verify($password, $user->password)) // сравниваем пороли с хэшем(пороль)
                {
                    foreach($user as $k => $v){
                        if($k != 'password') // проверка что ключа нет, пороль не записываем 
                            $_SESSION['user'][$k] = $v; // записываем в сессию параметры 
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
