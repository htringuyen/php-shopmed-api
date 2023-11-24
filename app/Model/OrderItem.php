<?php

namespace App\Model;

use Slimmvc\Database\Model;

class OrderItem extends Model {
    protected string $table = "OrderItem";

    protected array $references = [
        "product" => [
            "model" => Product::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "productId",
            "maxRefDepth" => 1
        ],

        "productOrder" => [
            "model" => ProductOrder::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "orderId",
            "maxRefDepth" => 0
        ]
    ];

}