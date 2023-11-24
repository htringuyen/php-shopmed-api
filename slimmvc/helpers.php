<?php

use Slimmvc\App;
use Slimmvc\Provider\ConfigProvider;

if (!function_exists('app')) {
    function app(string $alias = null): mixed
    {
        if (is_null($alias)) {
            return App::getInstance();
        }

        return App::getInstance()->resolve($alias);
    }
}


if (!function_exists('config')) {
    function config(string $key = null, mixed $default = null): mixed
    {
        $config = app(ConfigProvider::BEAN_NAME);

        if (is_null($key)) {
            return app('config');
        }

        return app(ConfigProvider::BEAN_NAME)->get($key, $default);
    }
}


//if (!function_exists("response")) {
//    function response(string $type = null, mixed $content = null,
//                            ?string $redirectLocation = null, ?int $status = null, ?array $headers = null) {
//        $response = app(\Slimmvc\Provider\HttpResponseProvider::$BEAN_NAME);
//
//        if (!is_null($type)) {
//            $response->setType($type);
//        }
//
//        if (!is_null($content)) {
//            $response->setContent($content);
//        }
//
//        if (!is_null($redirectLocation)) {
//            $response->setRedirectLocation($redirectLocation);
//        }
//
//        if (!is_null($status)) {
//            $response->setStatus($status);
//        }
//
//        if (!is_null($headers)) {
//            $response->setHeaders($headers);
//        }
//
//        return $response;
//    }
//}

















