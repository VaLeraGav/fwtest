<?php 

function debug($arr){
    echo "<pre>".print_r($arr, true)."</pre>";
}

// принимать http, переотправка пользователя
function redirect($http = false){
    if($http){
        $redirect = $http; // адрес куда нужно отправить 
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/'; // на ту же самую 
    } 
    header("Location: $redirect"); // сама отправка 
    exit;
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

// function debug($value = null)
// {
//     echo '<br>Debug:<br><pre>';
//     print_r($value, true);
//     echo '</pre>';
// }
