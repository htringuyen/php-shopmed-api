<?php

namespace App\Controller\Admin;

use App\Model\OrderItem;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminOrderItemController
{
    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $orderItemId = $request->pathVariable("id");

        $orderItem = OrderItem::where("id", $orderItemId)->first();

        if (!isset($orderItem)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Order item not found"]);
            return $response;
        }

        $fields = ["productId", "orderId", "price", "quantity"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $orderItem->$field = $value;
            }
        }

        try {
            $orderItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($orderItem->toSerializationArray());
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
        $searchFields = ["id", "productId", "orderId", "price", "quantity"];

        $query = OrderItem::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $orderItems = $query->all();

        $data = array_map(fn($orderItem) => $orderItem->toSerializationArray(), $orderItems);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response)
    {
        $orderItem = new OrderItem();

        $fields = ["productId", "orderId", "price", "quantity"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $orderItem->$field = $value;
            }
        }

        try {
            $orderItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($orderItem->toSerializationArray());
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
        $orderItemId = $request->pathVariable("id");

        $orderItem = OrderItem::where("id", $orderItemId)->first();

        if (!isset($orderItem)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Order item not found"]);
            return $response;
        }

        try {
            $orderItem->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Order item {$orderItem->id} deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
