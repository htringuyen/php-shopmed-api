<?php

namespace App\Controller\Admin;

use App\Model\Product;
use Slimmvc\Http\HttpResponse;

class AdminProductController
{
    function getAllProduct(HttpResponse $response ){
        $products = Product::all();
        $data = [];
        foreach($products as $product){
            array_push($data, $product->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    function createProduct(HttpResponse $response, $productData)
    {
        // Tạo một đối tượng Product mới từ dữ liệu đầu vào
        $newProduct = new Product();
        $newProduct->fill($productData); // Giả sử có một phương thức fill để điền dữ liệu từ mảng vào đối tượng

        // Lưu sản phẩm mới vào cơ sở dữ liệu
        $newProduct->save();

        // Trả về thông tin của sản phẩm vừa được tạo
        $responseData = $newProduct->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function editProduct(HttpResponse $response, $productId, $productData)
    {
        // Tìm sản phẩm cần chỉnh sửa theo ID
        $product = Product::find($productId);

        if (!$product) {
            // Trả về lỗi nếu không tìm thấy sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product not found']);
            return $response;
        }

        // Cập nhật thông tin sản phẩm từ dữ liệu đầu vào
        $product->fill($productData);
        $product->save();

        // Trả về thông tin của sản phẩm sau khi chỉnh sửa
        $responseData = $product->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    function deleteProduct(HttpResponse $response, $productId)
    {
        // Tìm sản phẩm cần xóa theo ID
        $product = Product::find($productId);

        if (!$product) {
            // Trả về lỗi nếu không tìm thấy sản phẩm
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product not found']);
            return $response;
        }

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $product->delete();

        // Trả về thông báo xóa thành công
        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Product deleted successfully']);
        return $response;
    }


}