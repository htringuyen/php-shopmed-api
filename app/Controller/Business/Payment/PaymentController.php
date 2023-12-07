<?php

namespace App\Controller\Business\Payment;

use App\Model\CartItem;
use App\Model\User;
use App\Model\Product;
use App\Model\OrderItem;
use App\Model\ProductOrder;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;
use Exception;

class PaymentController
{
    public function createOrder(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $userId = $auth->getUserId();
        $note = json_decode($request->getRawContent(), true);

        //create order
        $productOrder = new ProductOrder();
        $productOrder->userId = $userId;
        $productOrder->note = is_array($note) && array_key_exists('note', $note) ? $note['note'] : '';
        $productOrder->createdAt = date("Y-m-d H:i:s");
        $productOrder->isPaid = false;
        $productOrder->isDelivered = false;
        $productOrder->status = "Pending";
        $productOrder->save();

        //create order items
        $cartItems = CartItem::query()->where("userId", $userId)->all();
        foreach ($cartItems as $cartItem) {
            $orderItem = new OrderItem();
            $orderItem->productId = $cartItem->productId;
            $orderItem->quantity = $cartItem->quantity;
            $orderItem->price = $cartItem->product->price;
            $orderItem->orderId = $productOrder->id;
            $orderItem->save();
        }

        //CartItem::query()->where("userId", $userId)->delete();
        foreach ($cartItems as $cartItem) {
            $cartItem->isActive = false;
            $cartItem->save();
        }
        $response->setType(HttpResponse::JSON);
        $response->setContent(["message" => "Order created successfully"]);
        return $response;
    }

    public function getPaymentInfo(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $userId = $auth->getUserId();
        $user = User::query()->where("id", $userId, "=")->first();
        $cartItems = CartItem::query()->where("userId", $userId, "=")->all();
        $data = [];
        foreach($cartItems as $cartItem){
            $element = [
                "id" => $cartItem->id,
                "price" => $cartItem->product->price,
                "productName" => $cartItem->product->name,
                "productId" => $cartItem->product->id,
                "quantity" => $cartItem->quantity
            ];
            array_push($data , $element);
        }
        $totalPrice = 0;
        foreach($data as $item){
            $totalPrice += $item["price"] * $item["quantity"];
        }
        $responseArray = [
            "user" => $user->toSerializationArray(),
            "cartItems" => $data,
            "subtotalPrice" => $totalPrice,
        ];
    
        $response->setType(HttpResponse::JSON);
        $response->setContent($responseArray);
        return $response;

    }
}
