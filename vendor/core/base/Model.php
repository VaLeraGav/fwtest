<?php

namespace vendor\core\base;

use vendor\core\Db;

abstract class Model
{
    protected $pdo;
    protected $table; // имя таблицы 

    public function __construct()
    {
        $this->pdo = Db::instance(); // возврящает обект подключения 
    }

    // true or false, обертка метода execute в Db
    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    // возвращает все данные из таблицы 
    public function findALl()
    {
        $sql = "SELECT *FROM {$this->table}";
        return $this->pdo->query($sql);
    }
}
