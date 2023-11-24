<?php

namespace App\Model;

use Slimmvc\Database\Model;

class User extends Model{
    protected string $table = "User";

    protected array $references = [
        "authInfo" => [
            "model" => AuthInfo::class,
            "relationship" => Model::HAS_ONE,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "cartItems" => [
            "model" => CartItem::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "productOrders" => [
            "model" => ProductOrder::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "productReviews" => [
            "model" => ProductReview::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "articles" => [
            "model" => Article::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "articleComments" => [
            "model" => ArticleComment::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ]
    ];
}
























