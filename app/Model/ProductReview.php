<?php

namespace App\Model;

use Slimmvc\Database\Model;

class ProductReview extends Model {
    protected string $table = "ProductReview";

    protected array $references = [
        "authorUser" => [
            "model" => User::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "userId",
            "maxRefDepth" => 1
        ],

        "product" => [
            "model" => Product::class,
            "relationship" => Model::BELONGS_TO,
            "foreignKey" => "productId",
            "maxRefDepth" => 0
        ]
    ];
    /**
     * @var true
     */
    private bool $isAbusive;

    public function markAsAbusive()
    {
        // Kiểm tra xem đánh giá đã được đánh dấu là lạm dụng hay chưa
        if (!$this->isAbusive) {
            // Đặt cờ lạm dụng thành true
            $this->isAbusive = true;

            // Thực hiện các bước kiểm tra và xử lý khác nếu cần thiết

            // Lưu thay đổi vào cơ sở dữ liệu
            $this->save();
        }
    }
}