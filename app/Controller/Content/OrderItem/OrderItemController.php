<?php

namespace App\Controller\Content\OrderItem;

use App\Model\OrderItem;
use App\Model\Product;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;
use Exception;

class OrderItemController
{
    public function getAll(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $searchValue = $request->requestParam("oderId");

        $query = OrderItem::query();

        $query->where("orderId", "%{$searchValue}%", "like");

        $orderItems = $query->all();

        $data = array_map(fn($productOrder) => $productOrder->toSerializationArray(), $orderItems);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function countorderItem(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $userId = $auth->getUserId();
        $orderItems = OrderItem::query()->where("userId", $userId)->where("isActive", true)->all();
        $count = 0;
        foreach($orderItems as $orderItem){
            $count += $orderItem->quantity;
        }
        $response->setType(HttpResponse::JSON);
        $response->setContent(["count" => $count]);
        return $response;
    }
}
