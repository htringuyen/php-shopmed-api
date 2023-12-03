<?php

namespace App\Controller\Example;

use App\Model\Product;
<<<<<<< HEAD
use function App\Controller\view;

class ProductController {

    public function index() {
        $products = Product::all();
        return view('products/index', compact('products'));
    }

    public function show($id) {
        $product = Product::find($id);
        return $this->view('products/show', compact('product'));
    }

    public function getAllProduct() {
        $products = Product::all();
        return $products;
    }

    public function getProductByNam($name) {
        $product = Product::where('name', $name)->first();
        return $product;
    }

    private function view(string $string, array $compact)
    {
    }

}
=======
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
>>>>>>> d1f315e7ae224bd1f1c5df923667b792d0b84367
