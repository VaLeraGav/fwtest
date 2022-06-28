<?php

namespace fw\core\base;

use fw\core\Db;
use Valitron\Validator;

abstract class Model
{
    protected $pdo;
    protected $table; // имя таблицы 
    protected $pk = 'id'; // первичный ключ 
    public $attributes = [];
    public $errors = []; // ошибки валидации
    public $rules = []; // правила валидации

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
    public function findLike($str, $field, $table = '')
    {
        $table = $table ?: $this->table;
        $sql = "SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%' . $str . '%']);
    }

    // для автоматической загрузки данных
    public function load($data)
    {
        foreach ($this->attributes as $name => $value) {
            if (isset($data[$name])) {
                $this->attributes[$name] = $data[$name];
            }
        }
    }
    // метод для валидации 
    public function validate($data)
    {
        Validator::langDir(WWW . '/valitron/lang');
        Validator::lang('ru');

        $v = new Validator($data);
        $v->rules($this->rules);
        if ($v->validate()) // если есть ошибки 
        {
            return true;
        }
        $this->errors = $v->errors(); // запись ошибок 
        return false;
    }

    public function getErrors(){
        $errors = '<ul>';
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    public function save($table){
        $tbl = \R::dispense($table);
        foreach($this->attributes as $name => $value){
            $tbl->$name = $value;
        }
        return \R::store($tbl);
    }




}
