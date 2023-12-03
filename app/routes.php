<?php

use App\Controller\Util\ReadImageController;
use Slimmvc\Routing\Router;

return function (Router $router) {

    // hello world
    $router->addRoute("GET", "/", function() {
        return "<h1>Hello world</h1>";
    });


    // host images
    $router->addRoute("GET", "/res/images/{category}/{imageId}",
        [ReadImageController::class, "handle"]
    );


    // get cart items of logged-in user with time filtering from a time
    $router->addRoute("GET", "/dev/cart",
       handler: [\App\Controller\Example\CartItemsController::class, "getUserCartFromATime"],
        requiredParams: ["from"], protected: true
    );

    // get cart items of logged-in user
    $router->addRoute("GET", "/dev/cart",
        handler: [\App\Controller\Example\CartItemsController::class, "getUserCart"],
        requiredParams: [], protected: true
    );

    // login user
    $router->addRoute("POST", "/auth/login",
        [\App\Controller\Auth\AuthController::class, "login"]);

    // refresh access token
    $router->addRoute("POST", "/auth/refresh",
        [\App\Controller\Auth\AuthController::class, "refreshAccessToken"]);
};
