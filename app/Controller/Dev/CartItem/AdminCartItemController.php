<?php

namespace App\Controller\Dev\CartItem;

use App\Model\CartItem;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;

class AdminCartItemController {

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "userId", "productId", "quantity", "isActive", "createdAt"];

        $query = CartItem::query();

        foreach($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $cartItems = $query->all();

        $data = array_map(function (CartItem $item) {
            return $item->toSerializationArray();
        }, $cartItems);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

}