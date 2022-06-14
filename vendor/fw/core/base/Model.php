<?php

namespace fw\core\base;

use fw\core\Db;

abstract class Model
{
    protected $pdo;
    protected $table; // имя таблицы 
    protected $pk = 'id'; // первичный ключ 

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
    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    // только одну запись, обычно работает по полю id - первичный ключ
    // fild по какому полю мы выбираем данные (необяз)
    public function findOne($id, $field = '')
    {
        $field = $field ?: $this->pk;
        $sql = "SELECT * FROM {$this->table} WHERE $field =  ? LIMIT 1"; // (?) для защиты от инекций, делаем массивом 
        return $this->pdo->query($sql, [$id]);
    }

    // произвольный запрос 
    public function findBySql($sql, $params = [])
    {
        return $this->pdo->query($sql, $params);
    }

    // для запросов ввида Like
    public function findLike($str,$field, $table='')
    {
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%'. $str .'%']);
    }
}
