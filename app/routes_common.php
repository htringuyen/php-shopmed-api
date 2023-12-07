<?php

use App\Controller\Common\Auth\AuthController;
use App\Controller\Common\Auth\UserInfoController;
use App\Controller\Common\Util\ReadImageController;
use Slimmvc\Routing\Router;

/** Author: ..... */

/******* BASE PATH: /api/v1/common *******/


return function (Router $router) {
    $BASE_PATH = "/api/v1/common";


    /***** path group: /res *****/
    $router->addRoute(
        'GET', $BASE_PATH.'/res/images/{category}/{imageId}', [ReadImageController::class, "read"]);

    /***** path group: /auth *****/
    $router->addRoute(
        'POST', $BASE_PATH.'/auth/login', [AuthController::class, "login"]);

    $router->addRoute(
        'POST', $BASE_PATH.'/auth/logout', [AuthController::class, "logout"], protected: true);

    $router->addRoute(
        'POST', $BASE_PATH.'/auth/refresh', [AuthController::class, "refreshAccessToken"]);

    $router->addRoute(
        'GET', $BASE_PATH.'/auth/duration', [AuthController::class, "getSessionDuration"]);

    /***** path group: auth/user-info *****/
    $router->addRoute(
        'GET', $BASE_PATH.'/auth/user-info', [UserInfoController::class, "getUserInfo"], protected: true);
};
