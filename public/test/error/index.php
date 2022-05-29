<?php


define("DEBUG", 1); // режим разработки 1-разработки 0-чистовик 

// как пример
class NotFoundException extends Exception{
    public function __construct($message = '', $code = 404){
        parent::__construct($message, $code);
    }
}


class ErrorHendler
{
    public function __construct()
    {
        if (DEBUG) {
            error_reporting(-1); // показывать все ошибки 
        } else {
            error_reporting(0); // не показывать ошибки 
        }
        set_error_handler([$this, 'errorHeandler']); // set_error_handler — Задаёт пользовательский обработчик ошибок
        register_shutdown_function([$this, 'fatalErrorHendler']); // зарегестрировать функцию с  error_get_last
        ob_start(); // для того чтобы не выводить ошибки от встроенного PHP, при фатальных
        set_exception_handler([$this, 'exceptionHandler']); // зарегестрировать собственный обработчик исключений, отдельно от других ошибок 
    }
    public function errorHeandler($errno, $errstr, $errfile, $errline)
    {
        $this->displayError($errno, $errstr, $errfile, $errline);
        // var_dump($errno, $errstr, $errfile, $errline);
        return true; // false - нельзя, так как оброботка ошибок от PHP 
    }

    // $response - код ответа 
    // 500, ошибка сервера, если произойдет ошибка, то поисковик  считает что это внутренняя ошибка и не индексирует эту страницу 
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response); // http_response_code — Получает или устанавливает код ответа HTTP
        if (DEBUG) {
            require 'views/dev.php';
        } else {
            require 'views/prod.php';
        }
        die;
    }

    public function fatalErrorHendler()
    {
        $error = error_get_last(); // по завершании скрипат, всегда, сообщение о послденей ошибки 
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$error['message']} | Файл: {$error['file']}, | Строка: {$error['line']}\n==========================\n", 3, __DIR__ . '/errors.log');
            ob_end_clean(); // очищает буфер обмена 
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler($e)
    {
        // var_dump($e);
        // сохраняет ошибки, логирует их, так же можно отправлять на email
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$e->getMessage()} | Файл: {$e->getFile()}, | Строка: {$e->getLine()}\n==========================\n", 3, __DIR__ . '/errors.log'); 
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode()); // getCode -  в консоле 
    }
}

new ErrorHendler;
// test();
/*try{
    if(empty($test)){
        throw new Exception('Упс, исключение');
    }
}catch(Exception $e){
    var_dump($e);
}*/

throw new NotFoundException('Страница не найдена');

throw new Exception('ВВВ исключение', 404); // наш поймает ошибку, php нет  
