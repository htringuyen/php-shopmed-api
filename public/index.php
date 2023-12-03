<?php

require_once __DIR__ . '/../vendor/autoload.php';

$separator = DIRECTORY_SEPARATOR;



$JETBRAINS_ORIGIN_ALLOWED = "http://localhost:63342";

function applyCorsHeaders($origin)
{
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type, Accept, Authorization, Cookie, Set-Cookie');

    header("Access-Control-Expose-Headers: Set-Cookie, Cookie");
}
function retrieveOrigin() {
    $origin = null;

    if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        $origin = $_SERVER['HTTP_ORIGIN'];
    }
    else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $origin = $_SERVER['HTTP_REFERER'];
    } else {
        $origin = $_SERVER['REMOTE_ADDR'];
    }

    return $origin;
}

applyCorsHeaders(retrieveOrigin());

$app = \Slimmvc\App::getInstance();
$app->bind('paths.base', fn() => __DIR__ . $separator.'..');
//$app->bind('url.path.prefix', fn() => "empalic-backend");
$app->prepare()->run()->send();