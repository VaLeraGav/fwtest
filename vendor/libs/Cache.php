<?php


namespace vendor\libs;

// элемнтарный вариант(запись, чтение, удаление)
class Cache
{
    public function __construct()
    {
    }
    // set -  положить данные в папку cache
    // $key - название данных которые кладем в cache
    // $date - данные 
    // $second -  время 
    public function set($key, $date, $second = 3600)
    {
        // конечную данные
        $content['date'] = $date;
        $content['end_time'] = time() + $second; // на 1 час
        // md5
        // serialize - Генерирует пригодное для хранения представление переменной, Это полезно для хранения или передачи значений PHP между скриптами без потери их типа и структуры.
        if (file_put_contents(CACHE . '/' . md5($key) . 'txt', serialize($content))) {
            return true;
        }
        return false;
    }
    public function get($key)
    {
        $file = CACHE . '/' . md5($key) . 'txt';

        if (file_exists($file)) {
            // unserialize - создает значение PHP из сохраненного представления, Для превращения сериализованной строки обратно в PHP-значение, 
            $content = unserialize(file_get_contents($file));
            if (time() <= $content['end_time']) // временная метка еще действительна
            {
                return $content['date'];
            }
            // unlink - удаляет файл
            unlink($file);
        }
        return false;
    }

    public function delete($key)
    {
        $file = CACHE . '/' . md5($key) . 'txt';
        if (file_exists($file))
            unlink($file);
        return false;
    }
}
