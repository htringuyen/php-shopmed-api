<?php

namespace App\Controller\Admin;

use App\Model\ProductOrder;
use Slimmvc\Http\HttpResponse;

class AdminProductOrderController
{
    public function getAllProductOrders(HttpResponse $response)
    {
        $productOrders = ProductOrder::all();
        $data = [];
        foreach ($productOrders as $productOrder) {
            array_push($data, $productOrder->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function createProductOrder(HttpResponse $response, $productOrderData)
    {
        // Tạo một đối tượng ProductOrder mới từ dữ liệu đầu vào
        $newProductOrder = new ProductOrder();
        foreach ($productOrderData as $key => $value) {
            if (property_exists($newProductOrder, $key)) {
                $newProductOrder->$key = $value;
            }
        }

        $newProductOrder->save();

        $responseData = $newProductOrder->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    public function editProductOrder(HttpResponse $response, $productOrderId, $productOrderData)
    {
        $productOrder = ProductOrder::find($productOrderId);

        if (!$productOrder) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product order not found']);
            return $response;
        }

        foreach ($productOrderData as $key => $value) {
            if (property_exists($productOrder, $key)) {
                $productOrder->$key = $value;
            }
        }

        $productOrder->save();

        $responseData = $productOrder->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    public function deleteProductOrder(HttpResponse $response, $productOrderId)
    {
        $productOrder = ProductOrder::find($productOrderId);

        if (!$productOrder) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Product order not found']);
            return $response;
        }

        $productOrder->delete();

        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Product order deleted successfully']);
        return $response;
    }
}
