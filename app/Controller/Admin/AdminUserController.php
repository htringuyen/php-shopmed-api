<?php

namespace App\Controller\Admin;

use App\Model\User;
use Exception;
use Slimmvc\Http\HttpRequest;
use Slimmvc\Http\HttpResponse;
use Slimmvc\Http\TokenAuthentication;

class AdminUserController {

    public function update(HttpRequest $request, HttpResponse $response, TokenAuthentication $auth) {
        $userId = $request->pathVariable("id");

        $user = User::where("id", $userId)->first();

        if (!isset($user)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "User not found..."]);
            return $response;
        }

        $fields = ["fullName", "email", "address", "phone"];
        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $user->$field = $value;
            }
        }

        try {
            $user->save();
            $response->setType(HttpResponse::JSON);
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

    public function getAllOrSearch(HttpRequest $request, HttpResponse $response) {
        $searchFields = ["id", "fullName", "email", "address", "phone"];

        $query = User::query();

        foreach ($searchFields as $field) {
            $searchValue = $request->requestParam($field);

            if (isset($searchValue)) {
                $query->where($field, "%{$searchValue}%", "like");
            }
        }

        $users = $query->all();

        $data = array_map(fn ($user) => $user->toSerializationArray(), $users);

        $response->setType(HttpResponse::JSON);
        $response->setContent($data);
        return $response;
    }

    public function create(HttpRequest $request, HttpResponse $response) {
        $user = new User();

        $fields = ["fullName", "email", "address", "phone"];

        foreach ($fields as $field) {
            $value = $request->requestParam($field);
            if (isset($value)) {
                $user->$field = $value;
            }
        }

        try {
            $user->save();
            $response->setType(HttpResponse::JSON);
            $response->setContent($user->toSerializationArray());
            return $response;
        } catch (Exception $e) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(400);
            $response->setContent(["message" => $e->getMessage()]);
            return $response;
        }
    }

    public function delete(HttpRequest $request, HttpResponse $response) {
        $userId = $request->pathVariable("id");

        $user = User::where("id", $userId)->first();

        if (!isset($user)) {
            $response->setType(HttpResponse::JSON);
            $response->setStatus(404);
            $response->setContent(["message" => "User not found..."]);
            return $response;
        }

        try {
            $user->delete();
            $response->setType(HttpResponse::JSON);
            $response->setContent(["message" => "user " . $user->id . " deleted successfully"]);
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
