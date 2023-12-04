<?php

namespace App\Controller\Admin;

use App\Model\OrderItem;
use Slimmvc\Http\HttpResponse;

class AdminOrderItemController
{
    public function getAllOrderItems(HttpResponse $response)
    {
        $orderItems = OrderItem::all();
        $data = [];
        foreach ($orderItems as $orderItem) {
            array_push($data, $orderItem->toSerializationArray());
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function createOrderItem(HttpResponse $response, $orderItemData)
    {
        // Tạo một đối tượng OrderItem mới từ dữ liệu đầu vào
        $newOrderItem = new OrderItem();
        foreach ($orderItemData as $key => $value) {
            if (property_exists($newOrderItem, $key)) {
                $newOrderItem->$key = $value;
            }
        }

        $newOrderItem->save();

        $responseData = $newOrderItem->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    public function editOrderItem(HttpResponse $response, $orderItemId, $orderItemData)
    {
        $orderItem = OrderItem::find($orderItemId);

        if (!$orderItem) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Order item not found']);
            return $response;
        }

        foreach ($orderItemData as $key => $value) {
            if (property_exists($orderItem, $key)) {
                $orderItem->$key = $value;
            }
        }

        $orderItem->save();

        $responseData = $orderItem->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setContent($responseData);
        return $response;
    }

    public function deleteOrderItem(HttpResponse $response, $orderItemId)
    {
        $orderItem = OrderItem::find($orderItemId);

        if (!$orderItem) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(['error' => 'Order item not found']);
            return $response;
        }

        $orderItem->delete();

        $response->setType(HttpResponse::JSON);
        $response->setContent(['message' => 'Order item deleted successfully']);
        return $response;
    }
}
