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
}
