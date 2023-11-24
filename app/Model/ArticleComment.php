<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ArticleComment extends Model {
    protected string $table = "ArticleComment";

    protected array $references = [
        "authorUser" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 1
        ],

        "article" => [
            "model" => Article::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "articleId",
            "maxRefDepth" => 0
        ]
    ];

}