<?php

namespace App\Controller\Content\AuthInfo;

use App\Model\AuthInfo;
use App\Model\User;

use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AuthInfoController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $userId = $auth->getUserId();

        $authInfo = AuthInfo::where("userId", $userId)->first();

        if (!isset($authInfo)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "user not found..."]);
            return $response;
        }

        $bodyData = json_decode(file_get_contents('php://input'));

        if($bodyData->oldPassword == $authInfo->passwordHash) {
            $authInfo->passwordHash = $bodyData->newPassword;

            try {
                $authInfo->save();
                $response->setType(HttpResponse::JSON);
                $response->setStatus(200);
                $response->setContent($authInfo->toSerializationArray());
                return $response;
            }
            catch (Exception $e) {
                $response->setType(HttpResponse::JSON);
                $response->setStatus(400);
                $response->setContent(["message" => $e->getMessage()]);
                return $response;
            }
        } else {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => "Your password is not suitable..."]);
            return $response;
        }
    }
}























