<?php

namespace app\models;

use vendor\core\base\Model;

class Main extends Model
{
    public $table ='posts'; // как таблица 
    public $pk = 'category_id'; // теперь по умолчанию у нас в findOne будет не id поиск а по заданному полю
}
