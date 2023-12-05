<?php

use App\Controller\Util\ReadImageController;
use Slimmvc\Routing\Router;
use App\Controller\Business\Product\ProductController;
use App\Controller\Business\Cart\CartController;

/** Author: ..... */

/******* BASE PATH: /api/v1/business *******/

return function (Router $router) {
    $BASE_PATH = "/api/v1/business";
    //product
    $router->addRoute('GET', $BASE_PATH."/products", [ProductController::class, "getAll"]);
    $router->addRoute('GET', $BASE_PATH."/products/{id}", [ProductController::class, "getProductDetail"]);

    //cart 
    $router->addRoute('GET', $BASE_PATH."/cart", [CartController::class, "getAllCartItems"] , protected: true  );
    $router->addRoute('POST', $BASE_PATH."/cart", [CartController::class, "addNewCartItem"] , protected: true, requiredParams: ["productId"] );
    $router->addRoute('DELETE', $BASE_PATH."/cart", [CartController::class, "deleteFromCart"] , protected: true, requiredParams: ["cartItemId"]);


    //cart item
    $router->addRoute('POST', $BASE_PATH."/cartitem/increase_quantity", [CartController::class, "increaseQuantity"] , protected: true, requiredParams: ["cartItemId"]);
    $router->addRoute('POST', $BASE_PATH."/cartitem/decrease_quantity", [CartController::class, "decreaseQuantity"] , protected: true, requiredParams: ["cartItemId"]);

};
