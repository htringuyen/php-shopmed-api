<?php

require_once __DIR__ . '/../vendor/autoload.php';

$separator = DIRECTORY_SEPARATOR;

$CORS_ORIGIN_ALLOWED = "http://localhost:3000";

function applyCorsHeaders($origin) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization');
}

applyCorsHeaders($CORS_ORIGIN_ALLOWED);

$app = \Slimmvc\App::getInstance();
$app->bind('paths.base', fn() => __DIR__ . $separator.'..');
//$app->bind('url.path.prefix', fn() => "empalic-backend");
$app->prepare()->run()->send();