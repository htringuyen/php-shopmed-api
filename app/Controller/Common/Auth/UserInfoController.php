<?php

namespace App\Controller\Common\Auth;

use App\Model\User;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class UserInfoController {

    public function getUserInfo(HttpResponse $response, HttpRequest $request, TokenAuthentication $auth) {
        $userId = $auth->getUserId();

        $user = User::query()->where("id", $userId)->first();

        $response->setType(HttpResponse::JSON);
        $response->setContent([
            ...$user->toSerializationArray(),
            "authority" => $user->authInfo->authority
        ]);
        return $response;
    }

}