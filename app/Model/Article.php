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
    /**
     * @var true
     */
    private bool $abusive;

    public function markAsAbusive()
    {
        // Kiểm tra nếu bài viết chưa được đánh dấu là bị lạm dụng
        if (!$this->abusive) {
            $this->abusive = true;
            $this->save();
        }
    }
}