<?php

namespace vendor\core;

// как пример
// class NotFoundException extends Exception
// {
//     public function __construct($message = '', $code = 404)
//     {
//         parent::__construct($message, $code);
//     }
// }


class ErrorHandler
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
        $this->logErrors($errstr, $errfile, $errline);
        if(DEBUG || in_array($errno, [E_USER_ERROR, E_RECOVERABLE_ERROR])){ // для фатальных и смешеных 
        $this->displayError($errno, $errstr, $errfile, $errline);
        }
        // var_dump($errno, $errstr, $errfile, $errline);
        return true; // false - нельзя, так как оброботка ошибок от PHP 
    }

    // $response - код ответа 
    // 500, ошибка сервера, если произойдет ошибка, то поисковик  считает что это внутренняя ошибка и не индексирует эту страницу 
    // именно он останавливает 
    protected function displayError($errno, $errstr, $errfile, $errline, $response = 500)
    {
        http_response_code($response); // http_response_code — Получает или устанавливает код ответа HTTP
        if ($response == 404 && !DEBUG) {
            require WWW . '/errors/404.html';
            die;
        }
        if (DEBUG) {
            require WWW . '/errors/dev.php';
        } else {
            require WWW . '/errors/prod.php';
        }
        die;
    }

    public function fatalErrorHendler()
    {
        $error = error_get_last(); // по завершании скрипат, всегда, сообщение о послденей ошибки 
        if (!empty($error) && $error['type'] & (E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)) {
            // error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$error['message']} | Файл: {$error['file']}, | Строка: {$error['line']}\n==========================\n", 3, __DIR__ . '/errors.log');
            $this->logErrors($error['message'], $error['file'], $error['line']);
            ob_end_clean(); // очищает буфер обмена 
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
    }

    public function exceptionHandler($e)
    {
        $this->logErrors($e->getMessage(), $e->getFile(), $e->getLine());
        // var_dump($e);
        // сохраняет ошибки, логирует их, так же можно отправлять на email
        // error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$e->getMessage()} | Файл: {$e->getFile()}, | Строка: {$e->getLine()}\n==========================\n", 3, __DIR__ . '/errors.log');
        $this->displayError('Исключение', $e->getMessage(), $e->getFile(), $e->getLine(), $e->getCode()); // getCode -  в консоле 
        return true;
    }

    // логирование 
    protected function logErrors($message = '', $file = '', $line = '')
    {
        error_log("[" . date('Y-m-d H:i:s') . "] Текст ошибки: {$message} | Файл: {$file}, | Строка: {$line}\n==========================\n", 3, ROOT . '/tmp/errors.log');
    }
}

new ErrorHandler;
// test();
/*try{
    if(empty($test)){
        throw new Exception('Упс, исключение');
    }
}catch(Exception $e){
    var_dump($e);
}*/

// throw new NotFoundException('Страница не найдена');

// throw new Exception('ВВВ исключение', 404); // наш поймает ошибку, php нет  
