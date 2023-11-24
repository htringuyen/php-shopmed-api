<?php

namespace App\Model;

use Slimmvc\Database\Model;

class AuthInfo extends Model {
    protected string $table = "AuthInfo";

    protected array $references = [
        "user" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 1
        ]
    ];
}