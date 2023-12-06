<?php

use App\Controller\Admin\AdminArticleCommentController;
use App\Controller\Admin\AdminArticleController;
use App\Controller\Admin\AdminAuthInfoController;
use App\Controller\Admin\AdminCartItemController;
use App\Controller\Admin\AdminOrderItemController;
use App\Controller\Admin\AdminProductController;
use App\Controller\Admin\AdminProductOrderController;
use App\Controller\Admin\AdminProductReviewController;
use App\Controller\Admin\AdminServiceCategoryController;
use App\Controller\Admin\AdminServiceController;
use App\Controller\Admin\AdminUserController;
use App\Controller\Admin\AdminProductCategoryController;
use Slimmvc\Routing\Router;

/** Author: Phan Ngoc Tram */

/******* BASE PATH: /api/v1/admin *******/

return function (Router $router) {
    $BASE_PATH = "/api/v1/admin";

    /***** path group: /products *****/
    $router->addRoute('PUT', $BASE_PATH."/products/{id}", [AdminProductController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/products", [AdminProductController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/products", [AdminProductController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/products/{id}", [AdminProductController::class, "delete"], protected: true, authority: 1);

    /***** path group: /users *****/
    $router->addRoute('PUT', $BASE_PATH."/users/{id}", [AdminUserController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/users", [AdminUserController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/users", [AdminUserController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/users/{id}", [AdminUserController::class, "delete"], protected: true, authority: 1);

    /***** path group: /product-review *****/
    $router->addRoute('PUT', $BASE_PATH."/product-review/{id}", [AdminProductReviewController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/product-review", [AdminProductReviewController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/product-review", [AdminProductReviewController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/product-review/{id}", [AdminProductReviewController::class, "delete"], protected: true, authority: 1);

    /***** path group: /product-order *****/
    $router->addRoute('PUT', $BASE_PATH."/product-order/{id}", [AdminProductOrderController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/product-order", [AdminProductOrderController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/product-order", [AdminProductOrderController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/product-order/{id}", [AdminProductOrderController::class, "delete"], protected: true, authority: 1);

    /***** path group: /order-item *****/
    $router->addRoute('PUT', $BASE_PATH."/order-item/{id}", [AdminOrderItemController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/order-item", [AdminOrderItemController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/order-item", [AdminOrderItemController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/order-item/{id}", [AdminOrderItemController::class, "delete"], protected: true, authority: 1);

    /***** path group: /article *****/
    $router->addRoute('PUT', $BASE_PATH."/article/{id}", [AdminArticleController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/article", [AdminArticleController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/article", [AdminArticleController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/article/{id}", [AdminArticleController::class, "delete"], protected: true, authority: 1);

    /***** path group: /article-comment *****/
    $router->addRoute('PUT', $BASE_PATH."/article-comment/{id}", [AdminArticleCommentController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/article-comment", [AdminArticleCommentController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/article-comment", [AdminArticleCommentController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/article-comment/{id}", [AdminArticleCommentController::class, "delete"], protected: true, authority: 1);

    /***** path group: /service *****/
    $router->addRoute('PUT', $BASE_PATH . "/service/{id}", [AdminServiceController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH . "/service", [AdminServiceController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH . "/service", [AdminServiceController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH . "/service/{id}", [AdminServiceController::class, "delete"], protected: true, authority: 1);

    /***** path group: /service-category *****/
    $router->addRoute('PUT', $BASE_PATH."/service-category/{id}", [AdminServiceCategoryController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/service-category", [AdminServiceCategoryController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/service-category", [AdminServiceCategoryController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/service-category/{id}", [AdminServiceCategoryController::class, "delete"], protected: true, authority: 1);

    /***** path group: /auth-info *****/
    $router->addRoute('PUT', $BASE_PATH."/auth-info/{id}", [AdminServiceCategoryController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/auth-info", [AdminServiceCategoryController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/auth-info", [AdminServiceCategoryController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/auth-info/{id}", [AdminServiceCategoryController::class, "delete"], protected: true, authority: 1);

    /***** path group: /product-category *****/
    $router->addRoute('PUT', $BASE_PATH."/product-category/{id}", [AdminServiceCategoryController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/product-category", [AdminServiceCategoryController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/product-category", [AdminServiceCategoryController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/product-category/{id}", [AdminServiceCategoryController::class, "delete"], protected: true, authority: 1);

    /***** path group: /product-category *****/
    $router->addRoute('PUT', $BASE_PATH."/cartitems/{id}", [AdminCartItemController::class, "update"], protected: true, authority: 1);

    $router->addRoute('GET', $BASE_PATH."/cartitems", [AdminCartItemController::class, "getAllOrSearch"], protected: true, authority: 1);

    $router->addRoute('POST', $BASE_PATH."/cartitems", [AdminCartItemController::class, "create"], protected: true, authority: 1);

    $router->addRoute('DELETE', $BASE_PATH."/cartitems/{id}", [AdminCartItemController::class, "delete"], protected: true, authority: 1);
};
