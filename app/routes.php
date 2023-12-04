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

    $router->addRoute("POST", "/dev/login",
        [\App\Controller\Example\LoginController::class, "login"]);

    //get all product
    $router->addRoute("GET", "/admin/product",
        [\App\Controller\Admin\AdminProductController::class, "getAllProduct"]);

    // create product
    $router->addRoute("POST", "/admin/product",
        handler: [\App\Controller\Admin\AdminProductController::class, "createProduct"]
    );

    // edit product
    $router->addRoute("PUT", "/admin/product/{productId}",
        handler: [\App\Controller\Admin\AdminProductController::class, "editProduct"]
    );

    // delete product
    $router->addRoute("DELETE", "/admin/product/{productId}",
        handler: [\App\Controller\Admin\AdminProductController::class, "deleteProduct"]
    );

    // get all product reviews
    $router->addRoute("GET", "/admin/product-review",
        [\App\Controller\Admin\AdminProductReviewController::class, "getAllProductReviews"]
    );

    // create product review
    $router->addRoute("POST", "/admin/product-review",
        handler: [\App\Controller\Admin\AdminProductReviewController::class, "createProductReview"]
    );

    // edit product review
    $router->addRoute("PUT", "/admin/product-review/{reviewId}",
        handler: [\App\Controller\Admin\AdminProductReviewController::class, "editProductReview"]
    );

    // delete product review
    $router->addRoute("DELETE", "/admin/product-review/{reviewId}",
        handler: [\App\Controller\Admin\AdminProductReviewController::class, "deleteProductReview"]
    );

    // add feedback to a product review
    $router->addRoute("POST", "/admin/product-review/{reviewId}/add-feedback",
        handler: [\App\Controller\Admin\AdminProductReviewController::class, "addFeedbackToReview"]
    );

    // report abuse for a product review
    $router->addRoute("POST", "/admin/product-review/{reviewId}/report-abuse",
        handler: [\App\Controller\Admin\AdminProductReviewController::class, "reportAbuse"]
    );

    // Get all users
    $router->addRoute("GET", "/admin/users",
        [\App\Controller\Admin\AdminUserController::class, "getAllUsers"]);

    // Get user by ID
    $router->addRoute("GET", "/admin/users/{userId}",
        [\App\Controller\Admin\AdminUserController::class, "getUserById"]);

    // Create user
    $router->addRoute("POST", "/admin/users",
        handler: [\App\Controller\Admin\AdminUserController::class, "createUser"]
    );

    // Edit user by ID
    $router->addRoute("PUT", "/admin/users/{userId}",
        handler: [\App\Controller\Admin\AdminUserController::class, "editUser"]
    );

    // Delete user by ID
    $router->addRoute("DELETE", "/admin/users/{userId}",
        handler: [\App\Controller\Admin\AdminUserController::class, "deleteUser"]
    );

    // Get all article comments
    $router->addRoute("GET", "/admin/article-comments",
        [\App\Controller\Admin\AdminArticleCommentController::class, "getAllArticleComments"]
    );

    // Create article comment
    $router->addRoute("POST", "/admin/article-comments",
        handler: [\App\Controller\Admin\AdminArticleCommentController::class, "createArticleComment"]
    );

    // Edit article comment by ID
    $router->addRoute("PUT", "/admin/article-comments/{commentId}",
        handler: [\App\Controller\Admin\AdminArticleCommentController::class, "editArticleComment"]
    );

    // Delete article comment by ID
    $router->addRoute("DELETE", "/admin/article-comments/{commentId}",
        handler: [\App\Controller\Admin\AdminArticleCommentController::class, "deleteArticleComment"]
    );

    // Add feedback to an article comment
    $router->addRoute("POST", "/admin/article-comments/{commentId}/add-feedback",
        handler: [\App\Controller\Admin\AdminArticleCommentController::class, "addFeedbackToArticleComment"]
    );

    // Lấy tất cả bài viết
    $router->addRoute("GET", "/admin/articles",
        [\App\Controller\Admin\AdminArticleController::class, "getAllArticles"]
    );

    // Lấy bài viết theo ID
    $router->addRoute("GET", "/admin/articles/{articleId}",
        [\App\Controller\Admin\AdminArticleController::class, "getArticleById"]
    );

    // Tạo bài viết mới
    $router->addRoute("POST", "/admin/articles",
        handler: [\App\Controller\Admin\AdminArticleController::class, "createArticle"]
    );

    // Chỉnh sửa bài viết theo ID
    $router->addRoute("PUT", "/admin/articles/{articleId}",
        handler: [\App\Controller\Admin\AdminArticleController::class, "editArticle"]
    );

    // Xóa bài viết theo ID
    $router->addRoute("DELETE", "/admin/articles/{articleId}",
        handler: [\App\Controller\Admin\AdminArticleController::class, "deleteArticle"]
    );

    // Đánh dấu bài viết là bị lạm dụng
    $router->addRoute("POST", "/admin/articles/{articleId}/report-abuse",
        handler: [\App\Controller\Admin\AdminArticleController::class, "reportAbuse"]
    );

    // Admin Order Items
    $router->addRoute("GET", "/admin/order-item",
        handler: [\App\Controller\Admin\AdminOrderItemController::class, "getAllOrderItems"]
    );

    $router->addRoute("POST", "/admin/order-item",
        handler: [\App\Controller\Admin\AdminOrderItemController::class, "createOrderItem"]
    );

    $router->addRoute("PUT", "/admin/order-item/{orderItemId}",
        handler: [\App\Controller\Admin\AdminOrderItemController::class, "editOrderItem"]
    );

    $router->addRoute("DELETE", "/admin/order-item/{orderItemId}",
        handler: [\App\Controller\Admin\AdminOrderItemController::class, "deleteOrderItem"]
    );

    // Admin Product Orders
    $router->addRoute("GET", "/admin/product-order",
        handler: [\App\Controller\Admin\AdminProductOrderController::class, "getAllProductOrders"]
    );

    $router->addRoute("POST", "/admin/product-order",
        handler: [\App\Controller\Admin\AdminProductOrderController::class, "createProductOrder"]
    );

    $router->addRoute("PUT", "/admin/product-order/{productOrderId}",
        handler: [\App\Controller\Admin\AdminProductOrderController::class, "editProductOrder"]
    );

    $router->addRoute("DELETE", "/admin/product-order/{productOrderId}",
        handler: [\App\Controller\Admin\AdminProductOrderController::class, "deleteProductOrder"]
    );
};
