<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ServiceCategory extends Model {
    protected string $table = "ServiceCategory";

    protected array $references = [
        "services" => [
            "model" => Service::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "categoryId",
            "maxRefDepth" => 0
        ]
    ];
}