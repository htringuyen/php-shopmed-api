<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ProductOrder extends Model {
    protected string $table = "ProductOrder";

    protected array $references = [
        "user" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 0
        ],

        "orderItems" => [
            "model" => OrderItem::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "orderId",
            "maxRefDepth" => 1
        ]
    ];

}