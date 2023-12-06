<?php

namespace App\Controller\Admin;

use App\Model\CartItem;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminCartItemController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $cartItemId = $request->pathVariable("id");

        $cartItem = CartItem::where("id", $cartItemId)->first();

        if (! isset($cartItem)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Cart item not found..."]);
            return $response;
        }

        $fields = ["productId", "userId", "createdAt", "quantity", "isActive"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $cartItem->$field = $value;
            }
        }

        try {
            $cartItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($cartItem->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "productId", "userId", "createdAt", "quantity", "isActive"];

        $query = CartItem::query();
        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $cartItems = $query->all();

        $data = array_map(fn($cartItem) => $cartItem->toSerializationArray(), $cartItems);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $cartItem = new CartItem();

        $fields = ["productId", "userId", "createdAt", "quantity", "isActive"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $cartItem->$field = $value;
            }
        }

        try {
            $cartItem->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($cartItem->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $cartItemId = $request->pathVariable("id");

        $cartItem = CartItem::where("id", $cartItemId)->first();

        if (! isset($cartItem)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "Cart item not found..."]);
            return $response;
        }

        try {
            $cartItem->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "Cart item " . $cartItem->id . " deleted successfully"]);
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
