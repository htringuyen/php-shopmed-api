<?php

namespace App\Controller\Admin;

use App\Model\ProductReview;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminProductReviewController
{
    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $reviewId = $request->pathVariable("id");

        $review = ProductReview::where("id", $reviewId)->first();

        if (!isset($review)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Product review not found..."]);
            return $response;
        }

        $fields = ["content", "reviewedAt", "rating", "userId", "productId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $review->$field = $value;
            }
        }

        try {
            $review->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($review->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response)
    {
        $searchRating = $request->requestParam("rating");

        $searchFields = ["id", "content", "reviewedAt", "rating", "userId", "productId"];

        $query = ProductReview::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $reviews = $query->all();

        $data = array_map(fn($review) => $review->toSerializationArray(), $reviews);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response)
    {
        $review = new ProductReview();

        $fields = ["content", "reviewedAt", "rating", "userId", "productId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $review->$field = $value;
            }
        }

        try {
            $review->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($review->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response)
    {
        $reviewId = $request->pathVariable("id");

        $review = ProductReview::where("id", $reviewId)->first();

        if (!isset($review)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Product review not found..."]);
            return $response;
        }

        try {
            $review->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "review " . $review->id . " deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
