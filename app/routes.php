<?php

use App\Controller\Util\ReadImageController;
use App\Controller\Util\ShowGreetingController;
use Slimmvc\Routing\Router;

return function (Router $router) {
    $router->addRoute("GET", "/", function() {
        return "<h1>Hello world</h1>";
    });


    // host images
    $router->addRoute("GET", "/res/images/{category}/{imageId}", [ReadImageController::class, "handle"]);


    // CartItem routes
    $router->addRoute("GET", "/dev/cart",
        [\App\Controller\Example\CartItemsController::class, "getUserCartFromATime"],
        true
    );


    // Login route
    $router->addRoute("POST", "/dev/login",
        [\App\Controller\Example\LoginController::class, "login"]);
};
