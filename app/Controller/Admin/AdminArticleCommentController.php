<?php

namespace App\Controller\Admin;

use App\Model\ArticleComment;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminArticleCommentController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $articleCommentId = $request->pathVariable("id");

        $articleComment = ArticleComment::where("id", $articleCommentId)->first();

        if (!isset($articleComment)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Article comment not found..."]);
            return $response;
        }

        $fields = ["content", "commentedAt", "userId", "articleId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $articleComment->$field = $value;
            }
        }

        try {
            $articleComment->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($articleComment->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "content", "commentedAt", "userId", "articleId"];

        $query = ArticleComment::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $articleComments = $query->all();

        $data = array_map(fn($articleComment) => $articleComment->toSerializationArray(), $articleComments);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $articleComment = new ArticleComment();

        $fields = ["content", "commentedAt", "userId", "articleId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $articleComment->$field = $value;
            }
        }

        try {
            $articleComment->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($articleComment->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $articleCommentId = $request->pathVariable("id");

        $articleComment = ArticleComment::where("id", $articleCommentId)->first();

        if (!isset($articleComment)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Article comment not found..."]);
            return $response;
        }

        try {
            $articleComment->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Article comment " . $articleComment->id . " deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
