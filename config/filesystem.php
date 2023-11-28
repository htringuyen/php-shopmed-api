<?php

$separator = DIRECTORY_SEPARATOR;
return [
    'default' => 'local',
    'local' => [
        'type' => 'local',
        'path' => __DIR__ . $separator."..".$separator.'storage',
        //'path' => "/storage"
    ]
];
