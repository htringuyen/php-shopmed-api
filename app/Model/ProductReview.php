<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ProductReview extends Model {
    protected string $table = "ProductReview";

    protected array $references = [
        "authorUser" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 1
        ],

        "product" => [
            "model" => Product::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "productId",
            "maxRefDepth" => 0
        ]
    ];

}