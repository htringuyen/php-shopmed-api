<?php

namespace App\Controller\Medshop;

use App\Model\AuthInfo;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class LoginController {

    public function login(HttpRequest $request, HttpResponse $response, TokenAuthentication $authentication) {
        $authHeaderValue = $request->getBasicAuthorizationHeaderValue();

        $credentials = explode(":", base64_decode($authHeaderValue));
        $username = $credentials[0];
        $password = $credentials[1];

        $authInfo = AuthInfo::where("username", $username)->first();

        if (isset($authInfo) && $password === $authInfo->passwordHash) {
            $user = $authInfo->user;
            $token = $authentication->createTokenFor($user->id, $authInfo->authority);
            $response->setType(HttpResponse::JSON);
            $response->setContent([
                "authorized" => "true",
                "userid" => $authentication->getUserId(),
                "authority" => $authentication->getAuthority(),
                "token" => $token
            ]);
            return $response;
        }

        $response->setStatus(401);
        $response->setType(HttpResponse::JSON);
        $response->setContent([
            "message" => "Authorization failed!"
        ]);

        return $response;
    }

}