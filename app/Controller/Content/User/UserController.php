<?php

namespace App\Controller\Content\User;
use App\Model\AuthInfo;

use App\Model\User;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class UserController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $userId = $auth->getUserId();

        $user = User::where("id", $userId)->first();

        if (! isset($user)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "user not found..."]);
            return $response;
        }

        $bodyData = json_decode(file_get_contents('php://input'));
        
        $user->fullName = $bodyData->fullName;
        $user->email = $bodyData->email;
        $user->address = $bodyData->address;
        $user->phone = $bodyData->phone;

        try {
            $user->save();
            $response->setType(HttpResponse::JSON);
            $response->setStatus(200);
            $response->setContent($user->toSerializationArray());
            return $response;
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getInfor(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $userId = $auth->getUserId();
        $user = User::where("id", $userId)->first();

        $data = $user->toSerializationArray();

        $response->setType(HttpResponse::JSON);
        $response->setStatus(200);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $user = new User();

        $fields = ["fullName"];
        foreach($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $user->$field = $value;
            }
        }

        try {
            $user->save();
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
        

        $authInfo = new AuthInfo();
        $authInfo -> username = $request->requestParam("username");
        $authInfo -> passwordHash = $request->requestParam("password");
        $authInfo -> authority = $_ENV["DEFAULT_AUTHORITY"];
        $authInfo -> userId = $user -> id;
        
        try {
            $authInfo -> save();
        }
        catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
        
        $response->setStatus(200);
        $response->setType(HttpResponse::JSON);
        $response->setContent([
            "message" => "sign up successfully"
        ]);
        return $response;
    }


    // public function delete(HttpRequest $request, HttpResponse $response) {
    //     $userId = $request->pathVariable("id");

    //     $user = User::where("id", $userId)->first();

    //     if (! isset($user)) {
    //         $response->setType(HttpResponse::JSON);
    //         $response->setStatus(404);
    //         $response->setContent(["message" => "user not found..."]);
    //         return $response;
    //     }

    //     try {
    //         $user->delete();
    //         $response->setType(HttpResponse::JSON);
    //         $response->setContent(["message" => "user " . $user->id . " deleted successfully"]);
    //         return $response;
    //     }
    //     catch (Exception $e) {
    //         $response->setType(HttpResponse::JSON);
    //         $response->setStatus(400);
    //         $response->setContent(["message" => $e->getMessage()]);
    //         return $response;
    //     }
    // }
}























