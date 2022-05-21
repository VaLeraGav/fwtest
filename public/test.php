<?php 

require 'rb.php';
$db= require '../config/config_db.php';
R::setup($db['dsn'], $db['user'], $db['pass'], $options);
R::fancyDebug(TRUE);
// var_dump(R::testConnection()); для проверки подключения


// beans - обект, чтобы дальше работать его надо создать 
// post название таблицы, свойства именам полей в таблице 

// Create
// $cat = R::dispense('category');
// $cat->title = 'Категория_2';
// $id = R::store($cat); // сохранение 
// var_dump($id);

// Read
// $cat = R::load('category', 3);
// echo $cat->title; // как обект 
// echo $cat['title']; // как массив 

// Update
// $cat = R::load('category', 3);
// $cat->title = 'Категория_3';
// R::store($cat);
// var_dump($id);

// Delete
// $cat = R::load('category', 3);
// R::trash($cat);
// R::wipe('category'); // удаление таблицы 


