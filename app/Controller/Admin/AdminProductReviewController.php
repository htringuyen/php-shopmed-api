<?php

namespace App\Controller\Admin;

use App\Model\ProductReview;
use Slimmvc\Http\HttpResponse;

class AdminProductReviewController
{
    function getAllProductReviews(HttpResponse $response)
    {
        $productReviews = ProductReview::all();
        $data = [];
        foreach ($productReviews as $productReview) {
            array_push($data, $productReview->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    function createProductReview(HttpResponse $response, $productReviewData)
    {
        // Tạo một đối tượng ProductReview mới từ dữ liệu đầu vào
        $newProductReview = new ProductReview();
        foreach ($productReviewData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($newProductReview, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $newProductReview->$key = $value;
            }
        }

        // Lưu đánh giá mới vào cơ sở dữ liệu
        $newProductReview->save();

        // Trả về thông tin của đánh giá vừa được tạo
        $responseData = $newProductReview->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function editProductReview(HttpResponse $response, $productReviewId, $productReviewData)
    {
        // Tìm đánh giá sản phẩm cần chỉnh sửa theo ID
        $productReview = ProductReview::find($productReviewId);

        if (!$productReview) {
            // Trả về lỗi nếu không tìm thấy đánh giá sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product review not found']);
            return $response;
        }

        // Cập nhật thông tin đánh giá sản phẩm từ dữ liệu đầu vào
        foreach ($productReviewData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($productReview, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $productReview->$key = $value;
            }
        }
        $productReview->save();

        // Trả về thông tin của đánh giá sản phẩm sau khi chỉnh sửa
        $responseData = $productReview->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function deleteProductReview(HttpResponse $response, $productReviewId)
    {
        // Tìm đánh giá sản phẩm cần xóa theo ID
        $productReview = ProductReview::find($productReviewId);

        if (!$productReview) {
            // Trả về lỗi nếu không tìm thấy đánh giá sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product review not found']);
            return $response;
        }

        // Xóa đánh giá sản phẩm khỏi cơ sở dữ liệu
        $productReview->delete();

        // Trả về thông báo xóa thành công
        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Product review deleted successfully']);
        return $response;
    }

    function addFeedbackToReview(HttpResponse $response, $productReviewId, $feedbackData)
    {
        // Tìm đánh giá sản phẩm cần thêm phản hồi theo ID
        $productReview = ProductReview::find($productReviewId);

        if (!$productReview) {
            // Trả về lỗi nếu không tìm thấy đánh giá sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product review not found']);
            return $response;
        }

        // Thêm phản hồi vào đánh giá sản phẩm
        foreach ($feedbackData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($productReview, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $productReview->$key = $value;
            }
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $productReview->save();

        // Trả về thông tin của đánh giá sản phẩm sau khi thêm phản hồi
        $responseData = $productReview->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function reportAbuse(HttpResponse $response, $productReviewId)
    {
        // Tìm đánh giá sản phẩm cần báo cáo lạm dụng theo ID
        $productReview = ProductReview::find($productReviewId);

        if (!$productReview) {
            // Trả về lỗi nếu không tìm thấy đánh giá sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product review not found']);
            return $response;
        }

        // Đánh dấu đánh giá là bị lạm dụng (có thể thực hiện các bước kiểm tra và xử lý khác)
        $productReview->markAsAbusive(); // Giả sử có một phương thức markAsAbusive trong model ProductReview

        // Lưu thay đổi vào cơ sở dữ liệu
        $productReview->save();

        // Trả về thông báo báo cáo lạm dụng thành công
        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Review reported as abusive']);
        return $response;
    }
}
