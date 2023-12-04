<?php

use App\Controller\Auth\AuthController;
use App\Controller\Util\ReadImageController;
use Slimmvc\Routing\Router;

/** Author: ..... */

/******* BASE PATH: /api/v1/common *******/


return function (Router $router) {
    $BASE_PATH = "/api/v1/common";


    /***** path group: /res *****/
    $router->addRoute(
        'GET', BASE_PATH.'/res/images/{category}/{imageId}', [ReadImageController::class, "read"]);


    /***** path group: /auth *****/
    $router->addRoute(
        'POST', BASE_PATH.'/auth/session', [AuthController::class, "login"]);

    $router->addRoute(
        'POST', BASE_PATH.'/auth/refresh', [AuthController::class, "logout"]);

};
