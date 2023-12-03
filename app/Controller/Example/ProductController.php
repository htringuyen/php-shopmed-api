<?php

namespace App\Controller\Example;

use App\Model\Product;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

// $router->addRoute("GET", "/dev/product",
// handler: [\App\Controller\Example\ProductController::class, "getAllProducts"],
// );

class ProductController
{
    // get all products
    public function getAllProducts(HttpResponse $response, HttpRequest $request)
    {
        $products = Product::all();

        $data = array_map(function (Product $product) {
           return $product->toSerializationArray();
        }, $products);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);

        return $response;
    }
}
