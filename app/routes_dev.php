<?php

use App\Controller\Dev\Product\ProductController;
use App\Controller\Util\ReadImageController;
use Slimmvc\Routing\Router;

/** Author: Nguyen Huu Tri */

/******* BASE PATH: /api/v1/dev *******/

return function (Router $router) {
    $BASE_PATH = "/api/v1/dev";

    /***** group path: /product *****/
    $router->addRoute(
        'GET', $BASE_PATH."/products", [ProductController::class, "getAll"]);

    $router->addRoute('PUT', $BASE_PATH."/products/{id}", [ProductController::class, "update"]);
};
