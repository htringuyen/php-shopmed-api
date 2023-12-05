<?php

use App\Controller\Dev\CartItem\AdminCartItemController;
use App\Controller\Dev\Product\ProductController;
use App\Controller\Dev\User\AdminUserController;
use Slimmvc\Routing\Router;

/** Author: Nguyen Huu Tri */

/******* BASE PATH: /api/v1/dev *******/

return function (Router $router) {
    $BASE_PATH = "/api/v1/dev";

    /***** path group: /products *****/
    $router->addRoute('PUT', $BASE_PATH."/products/{id}", [ProductController::class, "update"], protected: true);

    $router->addRoute('GET', $BASE_PATH."/products", [ProductController::class, "getAllOrSearch"], protected: true);

    $router->addRoute('POST', $BASE_PATH."/products", [ProductController::class, "create"], protected: true);

    $router->addRoute('DELETE', $BASE_PATH."/products/{id}", [ProductController::class, "delete"], protected: true);

    /***** path group: /cartitems *****/
    $router->addRoute('GET', $BASE_PATH."/cartitems", [AdminCartItemController::class, "getAllOrSearch"], protected: true);


    /**** path group: /user ****/
    $router->addRoute('GET', $BASE_PATH."/users", [AdminUserController::class, "getAllOrSearch"], protected: true);
};
