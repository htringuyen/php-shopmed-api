<?php

namespace App\Controller\Example;

use App\Model\CartItem;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class CartItemsController {

    // get cart items for logged-in user from a time
    public function getUserCartFromATime(HttpResponse $response, HttpRequest $request, TokenAuthentication $auth) {
        // retrieve user id from authentication info
        $userId = $auth->getUserId();

        // retrieve request parameter 'from'
        $fromDateTime = $request->requestParam("from");

        // perform querying with Model's static methods
        $cartItems = CartItem::where("userId", $userId)->where("createdAt", $fromDateTime, ">")->all();

        // convert list of CartItem to plain array for transferring to user
        $data = array_map(function (CartItem $item) {
            return $item->toSerializationArray();
        }, $cartItems);

        // set response content type
        $response->setType(HttpResponse::JSON);
        $response->setContent($data);

        // return the HttpRespond object then framework will transfer it to user
        return $response;
    }

    // get cart items for logged in user

    public function getUserCart(HttpResponse $response, HttpRequest $request, TokenAuthentication $auth) {
        // retrieve user id from authentication info
        $userId = $auth->getUserId();

        // perform querying with Model's static methods
        $cartItems = CartItem::where("userId", $userId)->all();

        // convert list of CartItem to plain array for transferring to user
        $data = array_map(function (CartItem $item) {
            return $item->toSerializationArray();
        }, $cartItems);

        // set response content type
        $response->setType(HttpResponse::JSON);
        $response->setContent($data);

        return $response;
    }


}