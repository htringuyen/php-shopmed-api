<?php

namespace App\Model;

use Slimmvc\Database\Model;

class Product extends Model {
    protected string $table = "Product";

    protected array $references = [
        "cartItems" => [
            "model" => CartItem::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "productId",
            "maxRefDepth" => 0
        ],

        "orderItems" => [
            "model" => OrderItem::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "productId",
            "maxRefDepth" => 0
        ],

        "reviews" => [
            "model" => ProductReview::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "productId",
            "maxRefDepth" => 0
        ],

        "category" => [
            "model" => ProductCategory::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "categoryId",
            "maxRefDepth" => 0
        ]
    ];
}