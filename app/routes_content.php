<?php

use App\Controller\Content\Article\ArticleController;
use App\Controller\Content\ArticleComment\ArticleCommentController;
use App\Controller\Content\User\UserController;
use App\Controller\Content\AuthInfo\AuthInfoController;
use App\Controller\Util\ReadImageController;
use Slimmvc\Routing\Router;

/** Author: ..... */

/******* BASE PATH: /api/v1/content *******/

return function (Router $router) {
    $BASE_PATH = "/api/v1/content";

    /***** path group: /article *****/
    $router->addRoute('GET', $BASE_PATH."/articles", [ArticleController::class, "getAllOrSearch"], protected: false);

    /***** path group: /commentArticle *****/
    $router->addRoute('GET', $BASE_PATH."/articlecomments", [ArticleCommentController::class, "getAllOrSearch"], protected: false);

    $router->addRoute('POST', $BASE_PATH."/articlecomments", [ArticleCommentController::class, "create"], protected: true);

    /***** path group: /User *****/
    $router->addRoute('POST', $BASE_PATH."/user/create", [UserController::class, "create"], protected: false);
    $router->addRoute('GET', $BASE_PATH."/user/getinfor", [UserController::class, "getInfor"], protected: true);
    $router->addRoute('PUT', $BASE_PATH."/user/update", [UserController::class, "update"], protected: true);

    /***** path group: /AuthInfor *****/
    $router->addRoute('PUT', $BASE_PATH."/authinfo/update", [AuthInfoController::class, "update"], protected: true);
};
