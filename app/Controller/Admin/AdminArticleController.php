<?php

namespace App\Controller\Admin;

use App\Model\Article;
use Slimmvc\Http\HttpResponse;

class AdminArticleController
{
    function getAllArticles(HttpResponse $response)
    {
        $articles = Article::all();
        $data = [];
        foreach ($articles as $article) {
            array_push($data, $article->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    function getArticleById(HttpResponse $response, $articleId)
    {
        $article = Article::find($articleId);

        if (!$article) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article not found']);
            return $response;
        }

        $responseData = $article->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function createArticle(HttpResponse $response, $articleData)
    {
        $newArticle = new Article();
        foreach ($articleData as $key => $value) {
            if (property_exists($newArticle, $key)) {
                $newArticle->$key = $value;
            }
        }

        $newArticle->save();

        $responseData = $newArticle->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function editArticle(HttpResponse $response, $articleId, $articleData)
    {
        $article = Article::find($articleId);

        if (!$article) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article not found']);
            return $response;
        }

        foreach ($articleData as $key => $value) {
            if (property_exists($article, $key)) {
                $article->$key = $value;
            }
        }
        $article->save();

        $responseData = $article->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function deleteArticle(HttpResponse $response, $articleId)
    {
        $article = Article::find($articleId);

        if (!$article) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article not found']);
            return $response;
        }

        $article->delete();

        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Article deleted successfully']);
        return $response;
    }

    function reportAbuse(HttpResponse $response, $articleId)
    {
        $article = Article::find($articleId);

        if (!$article) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Article not found']);
            return $response;
        }

        // Assuming there's a method markAsAbusive in the Article model
        $article->markAsAbusive();

        $article->save();

        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Article reported as abusive']);
        return $response;
    }
}
