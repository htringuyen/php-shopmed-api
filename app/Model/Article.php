<?php

namespace App\Model;

use Slimmvc\Database\Model;

class Article extends Model {
    protected string $table = "Article";

    protected array $references = [
        "authorUser" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 1
        ],

        "articleComments" => [
            "model" => ArticleComment::class,
            "relationship" => Model::HAS_MANY,
            "foreignKey" => "articleId",
            "maxRefDepth" => 1
        ]
    ];
}