<?php

namespace App\Controller\Content\ProductOrder;

use App\Model\ProductOrder;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;
use Exception;

class ProductOrderController
{
    public function getAll(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $searchValue = $auth->getUserId();

        $query = ProductOrder::query();

        $query->where("userId", "%{$searchValue}%", "like");

        $productOrders = $query->all();

        $data = [];
        foreach($productOrders as $productOrder) {
            $element=[
                "id" => $productOrder->id,
                "createdAt" => $productOrder->createdAt,
                "isPaid" => $productOrder->isPaid,
                "isDelivered" => $productOrder->isDelivered,
                "status" => $productOrder->status,
                "note" => $productOrder->note
            ];
            array_push($data,$element);
        }

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function countProductOrder(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $userId = $auth->getUserId();
        $ProductOrders = ProductOrder::query()->where("userId", $userId)->where("isActive", true)->all();
        $count = 0;
        foreach($ProductOrders as $ProductOrder){
            $count += $ProductOrder->quantity;
        }
        $response->setType(HttpResponse::JSON);
        $response->setContent(["count" => $count]);
        return $response;
    }
}
