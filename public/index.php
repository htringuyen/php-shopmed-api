<?php

require_once __DIR__ . '/../vendor/autoload.php';

$separator = DIRECTORY_SEPARATOR;

$app = \Slimmvc\App::getInstance();
$app->bind('paths.base', fn() => __DIR__ . $separator.'..');
//$app->bind('url.path.prefix', fn() => "empalic-backend");
$app->prepare()->run()->send();