<?php

namespace App\Controller\Example;

use App\Model\Product;
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

