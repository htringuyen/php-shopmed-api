<?php

namespace App\Controller\Dev\Product;

use App\Model\Product;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class ProductController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $productId = $request->pathVariable("id");

        $product = Product::where("id", $productId)->first();

        if (! isset($product)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "product not found..."]);
            return $response;
        }

        $fields = ["name", "description", "categoryId", "inStockCount", "price"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $product->$field = $value;
            }
        }

        try {
            $product->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($product->toSerializationArray());
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
        $searchName = $request->requestParam("name");
        $searchDescription = $request->requestParam("description");

        $searchFields = ["id", "name", "description", "categoryId", "inStockCount", "price"];

        $query = Product::query();
        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $products = $query->all();

        $data = array_map(fn($product) => $product->toSerializationArray(), $products);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }


    public function create(HttpRequest $request, HttpResponse $response) {
        $product = new Product();

        $fields = ["name", "description", "categoryId", "inStockCount", "price"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $product->$field = $value;
            }
        }

        try {
            $product->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($product->toSerializationArray());
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
        $productId = $request->pathVariable("id");

        $product = Product::where("id", $productId)->first();

        if (! isset($product)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "product not found..."]);
            return $response;
        }

        try {
            $product->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "product " . $product->id . " deleted successfully"]);
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























