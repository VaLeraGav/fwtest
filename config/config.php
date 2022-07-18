<?php


//  всевозможные конфигурации нашего проекта 
$config = [
    'components' => [
        'cache' => 'fw\libs\Cache',
        'test' => 'fw\libs\Test',
    ] // те классы которые в автозагрузке 

];

return $config;
