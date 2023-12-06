<?php

namespace App\Controller\Content\Article;

use App\Model\Article;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class ArticleController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $articleId = $request->pathVariable("id");

        $article = Article::where("id", $articleId)->first();

        if (! isset($article)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "article not found..."]);
            return $response;
        }

        $fields = ["name", "description", "categoryId", "inStockCount", "price"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $article->$field = $value;
            }
        }

        try {
            $article->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($article->toSerializationArray());
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

        $searchFields = ["id", "title", "content", "publishedOn", "inStockCount", "userId"];

        $query = Article::query();
        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $articles = $query->all();

        $data = array_map(fn($articles) => $articles->toSerializationArray(), $articles);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }


    public function create(HttpRequest $request, HttpResponse $response) {
        $article = new Article();

        $fields = ["name", "description", "categoryId", "inStockCount", "price"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $article->$field = $value;
            }
        }

        try {
            $article->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($article->toSerializationArray());
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
        $articleId = $request->pathVariable("id");

        $article = Article::where("id", $articleId)->first();

        if (! isset($article)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "article not found..."]);
            return $response;
        }

        try {
            $article->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "article " . $article->id . " deleted successfully"]);
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























