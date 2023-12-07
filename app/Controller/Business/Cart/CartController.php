<?php

namespace App\Controller\Business\Cart;

use App\Model\CartItem;
use App\Model\Product;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;
use Exception;

class CartController
{
    public function getAllCartItems(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth){
        $userId = $auth->getUserId();
        $cartItems = CartItem::query()->where("userId", $userId, "=")->where("isActive", true, "=")->all();
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

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;

    }


    public function addNewCartItem(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth){
        $userId = $auth->getUserId();
        
        $productId = $request->requestParam("productId");
        $item = CartItem::query()->where("userId", $userId)->where("productId", $productId)->where("isActive", true)->first();
        if ($item) {
            $item->quantity = intval($item->quantity) + 1;
            $item->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($item->toSerializationArray());
            return $response;
        }

        $cartItem = new CartItem();
        $cartItem->userId = $userId;
        $cartItem->productId = $request->requestParam("productId");
        $cartItem->quantity = $request->requestParam("quantity") ?? 1;
        $cartItem->createdAt = date("Y-m-d H:i:s");
        $cartItem->isActive = true;

        
        try {
            $cartItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($cartItem->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function increaseQuantity(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $id = $request->requestParam("cartItemId");
        $userId = $auth->getUserId();
        $cartItem = CartItem::where("id", $id)->where("userId", $userId)->first();

        if (!$cartItem) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Cart item not found"]);
            $response->setStatus(404);
            return $response;
        }

        $cartItem->quantity = intval($cartItem->quantity) + 1;
        $cartItem->save();

        $response->setType(HttpResponse::JSON);
        $response->setContent($cartItem->toSerializationArray());
        return $response;
    }

    public function decreaseQuantity(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth){
        $id = $request->requestParam("cartItemId");
        $userId = $auth->getUserId();
        $cartItem = CartItem::where("id", $id)->where("userId", $userId)->first();

        if (!$cartItem) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Cart item not found"]);
            $response->setStatus(404);
            return $response;
        }
        if ($cartItem->quantity == 1) {
            $cartItem->isActive = false;
            $cartItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "min Quantity reached"]);
            return $response;
        }
        $cartItem->quantity = intval($cartItem->quantity) - 1;
        $cartItem->save();

        $response->setType(HttpResponse::JSON);
        $response->setContent($cartItem->toSerializationArray());
        return $response;
    }

    public function deleteFromCart(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $id = $request->requestParam("cartItemId");
        $userId = $auth->getUserId();
        $cartItem = CartItem::where("id", $id)->where("userId", $userId)->first();

        if (!$cartItem) {
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Cart item not found"]);
            $response->setStatus(404);
            return $response;
        }

        
        $cartItem->isActive = false;
        $cartItem->save();
        $response->setType(HttpResponse::JSON);
        $response->setContent($cartItem->toSerializationArray());
        return $response;
    }

    public function countCartItem(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth)
    {
        $userId = $auth->getUserId();
        $cartItems = CartItem::query()->where("userId", $userId)->where("isActive", true)->all();
        $count = 0;
        foreach($cartItems as $cartItem){
            $count += 1;
        }
        $response->setType(HttpResponse::JSON);
        $response->setContent(["count" => $count]);
        return $response;
    }
}
