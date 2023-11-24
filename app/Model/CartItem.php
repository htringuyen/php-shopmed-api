<?php

namespace App\Model;

use Slimmvc\Database\Model;

class CartItem extends Model {
    protected string $table = "CartItem";

    protected array $references = [
        "product" => [
            "model" => Product::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "productId",
            "maxRefDepth" => 1
        ],

        "user" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ]
    ];

}