<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ProductCategory extends Model {
    protected string $table = "ProductCategory";

    protected array $references = [
        "products" => [
            "model" => Product::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "categoryId",
            "maxRefDepth" => 0
        ]
    ];
}