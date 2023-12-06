<?php

namespace App\Controller\Admin;

use App\Model\AuthInfo;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminAuthInfoController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $authInfoId = $request->pathVariable("id");

        $authInfo = AuthInfo::where("id", $authInfoId)->first();

        if (!isset($authInfo)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "AuthInfo not found..."]);
            return $response;
        }

        $fields = ["username", "passwordHash", "authority", "userId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $authInfo->$field = $value;
            }
        }

        try {
            $authInfo->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($authInfo->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "username", "authority", "userId"];

        $query = AuthInfo::query();
        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);
            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $authInfos = $query->all();

        $data = array_map(fn($authInfo) => $authInfo->toSerializationArray(), $authInfos);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $authInfo = new AuthInfo();

        $fields = ["username", "passwordHash", "authority", "userId"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $authInfo->$field = $value;
            }
        }

        try {
            $authInfo->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($authInfo->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $authInfoId = $request->pathVariable("id");

        $authInfo = AuthInfo::where("id", $authInfoId)->first();

        if (!isset($authInfo)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "AuthInfo not found..."]);
            return $response;
        }

        try {
            $authInfo->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "AuthInfo " . $authInfo->id . " deleted successfully"]);
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }
}
