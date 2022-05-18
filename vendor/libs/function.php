<?php 

// function debug($arr){
//     echo "<pre>".print_r($arr, true)."</pre>";
// }

function debug($value = null)
{
    echo '<br>Debug:<br><pre>';
    print_r($value);
    echo '</pre>';
}
