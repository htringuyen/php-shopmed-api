<?php

namespace App\Model;

use Slimmvc\Database\Model;

class Service extends Model {
    protected string $table = "Service";

    protected array $references = [
        "category" => [
            "model" => ServiceCategory::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "categoryId",
            "maxRefDepth" => 0
        ]
    ];

}