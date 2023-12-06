<?php

namespace App\Controller\Admin;

use App\Model\ProductOrder;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminProductOrderController
{
    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $orderId = $request->pathVariable("id");

        $order = ProductOrder::where("id", $orderId)->first();

        if (!isset($order)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Product order not found..."]);
            return $response;
        }

        $fields = ["userId", "createdAt", "isPaid", "isDelivered", "status", "note"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $order->$field = $value;
            }
        }

        try {
            $order->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($order->toSerializationArray());
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
        $searchStatus = $request->requestParam("status");
        $searchTrackingNumber = $request->requestParam("trackingNumber");

        $searchFields = ["id", "userId", "createdAt", "isPaid", "isDelivered", "status", "note"];

        $query = ProductOrder::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $orders = $query->all();

        $data = array_map(fn($order) => $order->toSerializationArray(), $orders);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response)
    {
        $order = new ProductOrder();

        $fields = ["userId", "createdAt", "isPaid", "isDelivered", "status", "note"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $order->$field = $value;
            }
        }

        try {
            $order->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($order->toSerializationArray());
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
        $orderId = $request->pathVariable("id");

        $order = ProductOrder::where("id", $orderId)->first();

        if (!isset($order)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Product order not found..."]);
            return $response;
        }

        try {
            $order->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Product order {$order->id} deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
