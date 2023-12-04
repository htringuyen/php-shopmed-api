<?php

namespace App\Controller\Admin;

use App\Model\ArticleComment;
use Slimmvc\Http\HttpResponse;

class AdminArticleCommentController
{
    function getAllArticleComments(HttpResponse $response)
    {
        $articleComments = ArticleComment::all();
        $data = [];
        foreach ($articleComments as $articleComment) {
            array_push($data, $articleComment->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    function createArticleComment(HttpResponse $response, $articleCommentData)
    {
        // Tạo một đối tượng ArticleComment mới từ dữ liệu đầu vào
        $newArticleComment = new ArticleComment();
        foreach ($articleCommentData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($newArticleComment, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $newArticleComment->$key = $value;
            }
        }

        // Lưu bình luận mới vào cơ sở dữ liệu
        $newArticleComment->save();

        // Trả về thông tin của bình luận vừa được tạo
        $responseData = $newArticleComment->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function editArticleComment(HttpResponse $response, $articleCommentId, $articleCommentData)
    {
        // Tìm bình luận bài viết cần chỉnh sửa theo ID
        $articleComment = ArticleComment::find($articleCommentId);

        if (!$articleComment) {
            // Trả về lỗi nếu không tìm thấy bình luận bài viết
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article comment not found']);
            return $response;
        }

        // Cập nhật thông tin bình luận bài viết từ dữ liệu đầu vào
        foreach ($articleCommentData as $key => $value) {
            // Kiểm tra xem thuộc tính có tồn tại trong đối tượng hay không
            if (property_exists($articleComment, $key)) {
                // Nếu tồn tại, gán giá trị từ mảng vào thuộc tính
                $articleComment->$key = $value;
            }
        }
        $articleComment->save();

        // Trả về thông tin của bình luận bài viết sau khi chỉnh sửa
        $responseData = $articleComment->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function deleteArticleComment(HttpResponse $response, $articleCommentId)
    {
        // Tìm bình luận bài viết cần xóa theo ID
        $articleComment = ArticleComment::find($articleCommentId);

        if (!$articleComment) {
            // Trả về lỗi nếu không tìm thấy bình luận bài viết
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article comment not found']);
            return $response;
        }

        // Xóa bình luận bài viết khỏi cơ sở dữ liệu
        $articleComment->delete();

        // Trả về thông báo xóa thành công
        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Article comment deleted successfully']);
        return $response;
    }

    function addFeedbackToArticleComment(HttpResponse $response, $articleCommentId, $feedbackData)
    {
        $articleComment = ArticleComment::find($articleCommentId);

        if (!$articleComment) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article comment not found']);
            return $response;
        }

        foreach ($feedbackData as $key => $value) {
            if (property_exists($articleComment, $key)) {
                $articleComment->$key = $value;
            }
        }

        $articleComment->save();

        $responseData = $articleComment->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }
}
