<?php

namespace App\Controller\Content\ArticleComment;

use App\Model\ArticleComment;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class articleCommentController {

    public function update(HttpRequest $request, HttpResponse $response) {
        $articleCommentId = $request->pathVariable("id");

        $articleComment = ArticleComment::where("id", $articleCommentId)->first();

        if (! isset($articleComment)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "articleComment not found..."]);
            return $response;
        }

        $fields = ["content", "commentedAt", "userId", "articleId"];
        foreach($fields as $field) {
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
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {

        $searchFields = ["content", "commentedAt", "userId", "articleId"];


        $query = ArticleComment::query();
        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $comments = $query->all();
        $data = [];
        foreach($comments as $comment) {
            $element=[
                "userFullName" => $comment->authorUser->fullName,
                "content" => $comment->content,
                "commentedAt" => $comment->commentedAt
            ];
            array_push($data,$element);
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }


    public function create(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $userId = $auth->getUserId();
        $articleComment = new articleComment();
        
        // $bodyData = json_decode($request->getRawContent());
        $bodyData = json_decode(file_get_contents('php://input'));
        print_r("bodyData:");
        // print_r(file_get_contents('php://input'));
        print_r($bodyData);
        
        $currentDateTime = date('Y-m-d H:i:s',time());

        $articleComment->content = $bodyData->content;
        $articleComment->userId = $userId;
        $articleComment->commentedAt = $currentDateTime;
        $articleComment->articleId = $bodyData->articleId;

        try {
            $articleComment->save();
            $response->setStatus(200);
            $response->setType(HttpResponse::JSON);
            $response->setContent($articleComment->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }


    public function delete(HttpRequest $request, HttpResponse $response) {
        $articleCommentId = $request->pathVariable("id");

        $articleComment = articleComment::where("id", $articleCommentId)->first();

        if (! isset($articleComment)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "articleComment not found..."]);
            return $response;
        }

        try {
            $articleComment->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "articleComment " . $articleComment->id . " deleted successfully"]);
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}























