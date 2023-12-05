<?php

namespace App\Controller\Dev\Product;

use App\Model\Product;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class ProductController {
    public function getAll(HttpResponse $response) {
        $products = Product::all();

        $data = array_map(fn($product) => $product->toSerializationArray(), $products);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $productId = $request->pathVariable("id");

        $product = Product::where("id", $productId)->first();

        if (! isset($product)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "product not found..."]);
            return $response;
        }


        $product->name = $request->requestParam("name") ?? $product->name;
        $product->description = $request->requestParam("description") ?? $product->description;
        $product->categoryId = $request->requestParam("categoryId") ?? $product->categoryId;
        $product->inStockCount = $request->requestParam("inStockCount") ?? $product->inStockCount;
        $product->price = $request->requestParam("price") ?? $product->price;

        $product->save();

        $response->setType(HttpResponse::JSON);
        $response->setContent($product->toSerializationArray());
        return $response;
    }

    public function search(HttpRequest $request, HttpResponse $response) {
        $searchName = $request->requestParam("name");
        $searchDescription = $request->requestParam("description");

        $query = Product::query();

        if (isset($searchName)) {
            $query->where("name", "%{$searchName}%", "like");
        }

        if (isset($searchDescription)) {
            $query->where("description", "%{$searchDescription}%", "like");
        }

        $products = $query->all();


        $data = array_map(fn($product) => $product->toSerializationArray(), $products);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $product = new Product();

        $product->name = $request->requestParam("name");
        $product->description = $request->requestParam("description");
        $product->categoryId = $request->requestParam("categoryId");
        $product->inStockCount = $request->requestParam("inStockCount");
        $product->price = $request->requestParam("price");

        $product->save();

        $response->setType(HttpResponse::JSON);
        $response->setContent($product->toSerializationArray());
        return $response;
    }
}























